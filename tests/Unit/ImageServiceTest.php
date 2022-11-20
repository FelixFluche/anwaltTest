<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Service\ImageService;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ImageServiceTest extends TestCase
{
    private MockObject $imageManager;
    private MockObject $image;

    public function setUp(): void
    {
        $this->imageManager = $this->createMock(ImageManager::class);
        $this->image = $this->createMock(Image::class);
        parent::setUp();
    }

    public function testGetImage()
    {
        $this->image->filename = 'test';
        $this->imageManager->expects($this->once())->method('make')->willReturn($this->image);
        $service = new ImageService(
            $this->imageManager
        );

        $image = $service->getImage('test.png');
        $this->assertSame('test.png', $image->getFullName());
    }
}