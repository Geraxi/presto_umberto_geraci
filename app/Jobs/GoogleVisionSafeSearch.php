<?php

namespace App\Jobs;

use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use GPBMetadata\Google\Cloud\Vision\V1\ImageAnnotator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Image;
use Google\Cloud\Vision\V1\ImageAnnotationClient;

class GoogleVisionSafeSearch implements ShouldQueue
{
    use Diapatchable,InteractsWithQueue, Queueable, SerializesModels;

    private $article_image_id;
    public function __construct($article_image_id){
        $this->article_image_id = $article_image_id;
    }

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $i= Image::find($this->article_image_id);
        if(!$id){
            return;
        }
        $image = file_get_contents(storage_path('app/public/' . $i->path));
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path('google_credential.json'));

        $imageAnnotator = new ImageAnnotatorClient();
        $response=$imageAnnotator->safeSearchDetection($image);
        $imageAnnotator->close();

        $safe=$response->getSafeSearchAnnotation();

        $adult= $safe->getAdult();
        $medical= $safe->getMedical();
        $spoof= $safe->getSpoof();
        $violence= $safe->getViolence();
        $racy= $safe->getRacy();

        $likelihoodName= [
            'text-secondary bi bi-circle-fill',
            'text-success bi bi-check-circle-fill',
            'text-success bi bi-check-circle-fill',
            'text-warning bi bi-exclamation-circle-fill',
            'text-warning bi bi-exclamation-circle-fill',
            'text-danger bi bi-dash-circle-fill',
        ];


        $i->adult=$likelihoodName[$adult];
        $i->spoof=$likelihoodName[$spoof];
        $i->racy=$likelihoodName[$racy];
        $i->medical=$likelihoodName[$medical];
        $i->violence=$likelihoodName[$violence];
    }
    
    
}
