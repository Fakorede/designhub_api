<?php

namespace App\Jobs;

use App\Models\Design;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Image;

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
        $original_file = storage_path() . '/uploads/original' . $this->design->image;

        try {

            // create the large image
            $this->saveImage($original_file, 800, 600, 'uploads/large/');

            // create the thumbnail
            $this->saveImage($original_file, 250, 200, 'uploads/thumbnail/');

            // store image to permanent disk
            

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function saveImage($file, $width, $height, $path)
    {
        Image::make($file)
            ->fit($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($large = storage_path($path . $this->design->image));
    }
}
