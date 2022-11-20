<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ImageNotFoundException;
use App\Model\Image;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManager;

class ImageService
{
    public function __construct(
        private ImageManager $imageManager
    ) { }

    /**
     * @throws ImageNotFoundException
     */
    public function getImage(string $fileName): Image
    {
        try {
            $image = $this->imageManager->make(Image::PATH . $fileName);
            $fileNameParts = explode('.', $fileName);
            $suffix = '.' . end($fileNameParts);
            return new Image($image, $image->filename, $suffix);
        } catch (NotReadableException) {
            throw new ImageNotFoundException($fileName);
        }
    }

    /**
     * @throws ImageNotFoundException
     */
    public function resizeImage(string $fileName, int $width, int $height): Image
    {
        $image = $this->getImage($fileName);
        $resizedImage = $image->resize($width, $height);
        $resizedImage->save();

        return $resizedImage;
    }

    /**
     * @throws ImageNotFoundException
     */
    public function cropImage(string $fileName, int $width, int $height): Image
    {
        $image = $this->getImage($fileName);
        $resizedImage = $image->crop($width, $height);
        $resizedImage->save();

        return $resizedImage;
    }
}