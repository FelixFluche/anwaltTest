<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class ImageNotFoundException extends Exception
{
    public function __construct($filename = "")
    {
        $message = sprintf('File with name %s not found', $filename);
        parent::__construct($message);
    }
}