<?php

namespace App\Jobs;

use App\Models\Design;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $design;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Design $design)
    {
        $this->design = $design;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $disk = $this->design->disk;
        $filename = $this->design->image;
        $original_file = storage_path() . '/uploads/original/' . $filename;
        $large = storage_path() . '/uploads/large/' . $filename;
        $thumbnail = storage_path() . '/uploads/thumbnail/' . $filename;

        try {

            // create the large image
            $this->resizeImage($original_file, 800, 600, $large);

            // create the thumbnail
            $this->resizeImage($original_file, 250, 200, $thumbnail);

            // store image to permanent disk
            // original image
            $this->saveImageToDisk($disk, 'uploads/designs/original/', $filename, $original_file);

            // large images
            $this->saveImageToDisk($disk, 'uploads/designs/large/', $filename, $large);

            // thumbnail images
            $this->saveImageToDisk($disk, 'uploads/designs/thumbnail/', $filename, $thumbnail);

            // update db
            $this->design->update([
                'upload_successful' => true,
            ]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function resizeImage($file, $width, $height, $path)
    {
        Image::make($file)
            ->fit($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($path);
    }

    private function saveImageToDisk($disk, $path, $filename, $oldImg)
    {
        if (Storage::disk($disk)
            ->put($path . $filename, fopen($oldImg, 'r+'))) {
            File::delete($oldImg);
        }
    }
}
