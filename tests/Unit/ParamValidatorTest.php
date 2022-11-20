<?php

namespace App\Tests\Unit;

use App\Validator\ImageParamValidator;
use PHPUnit\Framework\TestCase;

class ParamValidatorTest extends TestCase
{
    public function testValidateSuccess()
    {
        $params = [
            'height' => 100,
            'width' => 100
        ];

        $validator = new ImageParamValidator();
        $result = $validator->validate($params);
        $this->assertCount(0, $result->getErrors());
    }

    public function testValidateInvalidWidth()
    {
        $params = [
            'height' => 100,
            'width' => 'abcd'
        ];

        $validator = new ImageParamValidator();
        $result = $validator->validate($params);
        $this->assertCount(1, $result->getErrors());
        $this->assertSame('abcd is not a numeric value', $result->getErrors()[0]);
    }

    public function testValidateInvalidHeight()
    {
        $params = [
            'height' => 'abcd',
            'width' => 100
        ];

        $validator = new ImageParamValidator();
        $result = $validator->validate($params);
        $this->assertCount(1, $result->getErrors());
        $this->assertSame('abcd is not a numeric value', $result->getErrors()[0]);
    }
}