<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Result\ValidatorResult;

class ImageParamValidator
{
    public function validate(array $args): ValidatorResult
    {
        $result = new ValidatorResult();
        if (isset($args['width']) && !is_numeric($args['width'])) {
            $result->appendError(sprintf('%s is not a numeric value', $args['width']));
        }

        if (isset($args['height']) && !is_numeric($args['height'])) {
            $result->appendError(sprintf('%s is not a numeric value', $args['height']));
        }

        return $result;
    }
}