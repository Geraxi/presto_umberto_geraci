<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Image;
class ResizeImage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

     private $w,$h,$filename,$path;
    public function __construct($filepath,$w,$h)
    {
        $this->path= dirnmae($filepath);
        $this->fileName= basename($filePath);
        $this->w = $w;
        $this->h =$h;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $w= $this->w;
        $h= $this->h;
        $srcPath= storage_path() . '/app/public/' . $this->path . '/' . $this->fileName;
        $destPath= storage_path() . '/app/public/' . $this->path . "/crop_{$w}x{$h}_" . $this->fileName;

        Image::load($srcPath)
        ->crop($w, $h, CropPosition::Center)
        ->save($destPath);
    }
}
