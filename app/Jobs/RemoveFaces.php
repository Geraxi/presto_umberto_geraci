<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Queueable;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use App\Models\Image;
use Spatie\Image\Image as SpatieImage;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;

class RemoveFaces implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $article_image_id;

    public function __construct($article_image_id)
    {
        $this->article_image_id = $article_image_id;
    }

    public function handle()
    {
        $i = Image::find($this->article_image_id);
        if (!$i) {
            return;
        }

        $srcPath = storage_path('app/public/' . $i->path);
        $imageContent = file_get_contents($srcPath);

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path('google_credential.json'));

        $imageAnnotator = new ImageAnnotatorClient();
        $response = $imageAnnotator->faceDetection($imageContent);
        $faces = $response->getFaceAnnotations();

        foreach ($faces as $face) {
            $boundingPoly = $face->getBoundingPoly();
            if (!$boundingPoly) {
                continue;
            }

            $vertices = $boundingPoly->getVertices();
            $bounds = [];

            foreach ($vertices as $vertex) {
                $bounds[] = [$vertex->getX(), $vertex->getY()];
            }

            if (count($bounds) < 3) {
                continue; // Evita errori in caso di dati incompleti
            }

            $w = $bounds[2][0] - $bounds[0][0];
            $h = $bounds[2][1] - $bounds[0][1];

            $image = SpatieImage::load($srcPath);

            $image->watermark(base_path('resources/img/smile.png'))
                ->align(Manipulations::ALIGN_TOP_LEFT)
                ->width($w)
                ->height($h)
                ->opacity(100)
                ->watermarkPadding($bounds[0][0], $bounds[0][1])
                ->watermarkFit(Manipulations::FIT_STRETCH);

            $image->save($srcPath);
        }

        $imageAnnotator->close();
    }
}

