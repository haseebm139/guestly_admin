<?php
namespace App\Services\Studio;
use Illuminate\Http\UploadedFile;

class StudioImageService
{
    /**
     * Upload a single image (logo or cover).
     */
    public function uploadImage(UploadedFile $file, string $type, string $folder): string
    {
        $filename = 'studio-' . $type . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Store in public folder
        $file->move(public_path('studios/' . $folder), $filename);

        return 'studios/' . $folder . '/' . $filename;
    }

    /**
     * Upload multiple gallery images (max 5).
     */
    public function uploadGalleryImages(array $files, int $limit = 5): array
    {
        $paths = [];

        foreach (array_slice($files, 0, $limit) as $index => $file) {
            $filename = 'studio-gallery-' . time() . '-' . $index . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('studios/gallery'), $filename);

            $paths[] = 'studios/gallery/' . $filename;
        }

        return $paths;
    }

    public function uploadPortfolio(array $files,int $user_id ,int $limit = 5): array
    {
         $paths = [];

        foreach (array_slice($files, 0, $limit) as $index => $file) {

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // name without extension
            $extension = $file->getClientOriginalExtension();

            $filename = $originalName .'.' . $extension;

            $file->move(public_path('artists/portfolio/'.$user_id. '/'), $filename);

            $paths[] = 'artists/portfolio/'.$user_id . '/' . $filename;
        }

        return $paths;
    }



}
