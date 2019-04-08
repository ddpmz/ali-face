<?php

/*
 * This file is part of the renfan/face.
 *
 * (c) renfan <renfan1204@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Renfan\Face\Tests;

use PHPUnit\Framework\TestCase;
use Renfan\Face\Exception\InvalidArgumentException;
use Renfan\Face\Face;

class FaceTest extends TestCase
{
    public function testVerifyWithInvalidType()
    {
        $f = new Face('mock-key', 'mock-key');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type value(0/1): 2');
        $f->verify('image1', 'image2', 2);
        $this->fail('Failed to assert verify throw exception with invalid argument.');
    }

    public function testAliApiAccessWithInvalidPath()
    {
        $f = new Face('mock-key', 'mock-key');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type value(detect, attribute, verify): foo');
        $f->aliApiAccess('mock-content', 'foo');
        $this->fail('Failed to assert aliApiAccess throw exception with invalid argument.');
    }
}
