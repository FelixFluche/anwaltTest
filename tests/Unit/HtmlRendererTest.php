<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Renderer\HtmlRenderer;
use PHPUnit\Framework\TestCase;

class HtmlRendererTest extends TestCase
{
    public function testRenderSuccess()
    {
        $renderer = new HtmlRenderer('/var/www/html/tests/templates/');

        $html = $renderer->render('test.html', ['test' => 'test message']);
        $this->assertFalse(strpos($html, '{test}'));
        $this->assertSame(2, substr_count($html, 'test message'));
    }

    public function testRenderFileNotFound()
    {
        $renderer = new HtmlRenderer(
            '/var/www/html/tests/templates/'
        );
        $this->expectException(\Exception::class);
        $renderer->render('test123213123.html', ['test' => 'test message']);
    }
}