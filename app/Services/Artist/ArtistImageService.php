<?php
namespace App\Services\Artist;
use Illuminate\Http\UploadedFile;

class ArtistImageService
{
    /**
     * Upload a single image (logo or cover).
     */
    public function uploadImage(UploadedFile $file, string $type, string $folder): string
    {
        $filename = 'artist-' . $type . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Store in public folder
        $file->move(public_path('artists/' . $folder), $filename);

        return 'artists/' . $folder . '/' . $filename;
    }

    /**
     * Upload multiple gallery images (max 5).
     */
    public function uploadGalleryImages(array $files, int $limit = 5): array
    {
        $paths = [];

        foreach (array_slice($files, 0, $limit) as $index => $file) {
            $filename = 'artist-gallery-' . time() . '-' . $index . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('artists/gallery'), $filename);

            $paths[] = 'artists/gallery/' . $filename;
        }

        return $paths;
    }
}
