<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Image;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\ImageDriver;

class ResizeImage implements ShouldQueue
{
    use Queueable;

    public $path;
    public $w;
    public $h;

    public function __construct($filePath, $w, $h)
    {
        $this->path = $filePath;
        $this->w = $w;
        $this->h = $h;
    }

    public function handle(): void
    {
        $srcPath = storage_path('app/public/' . $this->path);

        $destPath = storage_path('app/public/' . dirname($this->path) . '/crop_' . $this->w . 'x' . $this->h . '_' . basename($this->path));

        Image::useImageDriver(ImageDriver::Gd)
            ->load($srcPath)
            ->crop($this->w, $this->h, CropPosition::Center)
            ->save($destPath);
    }
}