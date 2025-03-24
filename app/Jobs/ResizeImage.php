<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Queueable;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Spatie\Image\Enums\Unit;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $path;
    private string $fileName;
    private int $w;
    private int $h;

    public function __construct(string $filepath, int $w, int $h)
    {
        $this->path = dirname($filepath);
        $this->fileName = basename($filepath);
        $this->w = $w;
        $this->h = $h;
    }

    public function handle(): void
    {
        $w = $this->w;
        $h = $this->h;
        $srcPath = storage_path('app/public/' . $this->path . '/' . $this->fileName);
        $destPath = storage_path('app/public/' . $this->path . "/crop_{$w}x{$h}_" . $this->fileName);

        Image::load($srcPath)
            ->crop($w, $h, CropPosition::Center)
            ->watermark(
                base_path('resources/img/watermark.png'),
                width:50,
                height:50,
                paddingX:5,
                paddingY:5,
                paddingUnit: Unit::Percent
            )
            ->save($destPath);
    }
}
