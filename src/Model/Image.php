<?php

declare(strict_types=1);

namespace App\Model;

use Intervention\Image\Image as InterventionImage;

class Image
{
    public const PATH = 'images/';

    public function __construct(
        private InterventionImage $image,
        private string $name,
        private string $suffix
    ) {
    }

    public function save(): void
    {
        $this->image->save(self::PATH . $this->name . $this->suffix);
    }

    public function resize(int $width, int $height): self
    {
        $this->image = $this->image->resize($width, $height);
        $this->name = $this->image->filename . $width . 'x' . $height;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->name . $this->suffix;
    }
}
