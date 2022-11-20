<?php

declare(strict_types=1);

namespace App\Renderer;

use Exception;

class HtmlRenderer
{
    public function __construct(
        private string $templatePath
    ) { }

    /**
     * @throws Exception
     */
    public function render(string $templateName, array $args): string
    {
        try {
            $file = file_get_contents($this->templatePath . $templateName);
        } catch (\Throwable) {
            throw new Exception('File not found');
        }

        if ($file === false) {
            throw new Exception('File not found');
        }

        foreach ($args as $key => $value) {
            $key = sprintf("{%s}",$key);
            if (strpos($file, $key) > 0) {
                $file = str_replace($key, $value, $file);
            }
        }

        return $file;
    }
}