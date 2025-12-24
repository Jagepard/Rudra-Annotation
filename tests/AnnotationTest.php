<?php

declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Jagepard <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 * 
 * phpunit src/tests/ContainerTest --coverage-html src/tests/coverage-html
 */

namespace Rudra\Annotation\Tests;

use ReflectionClass;
use ReflectionMethod;
use Rudra\Annotation\{
    Annotation, 
    AnnotationInterface, 
    Tests\Stub\PageController
};
use PHPUnit\Framework\TestCase;

class AnnotationTest extends TestCase
{
    private AnnotationInterface $annotation;
    private string $docBlock = "    
        /**
         * @Routing(url = '')
         * @Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
         * @assertResult(false)
         * @Validate(name = 'min:150', phone = 'max:9')
         * @Middleware('Middleware', params = {int1 : '123'})
         * @Annotation(param1, param2 = 'param2', param3={param1;param2:'param2'})
         */
         ";
    private array $result = [
        "Routing" => [["url" => ""]],
        "Defaults" => [
            [
                "name" => "user1",
                "lastname" => "sample",
                "age" => "0",
                "address" => [
                    "country" => "Russia",
                    "state" => "Tambov",
                ],
                "phone" => "000-00000000",
            ],
        ],
        "assertResult" => [["false"]],
        "Validate" => [
            [
                "name" => "min:150",
                "phone" => "max:9",
            ],
        ],
        "Middleware" => [
            [
                "'Middleware'",
                "params" => [
                    "int1" => "123",
                ],
            ],
        ],
        "Annotation" => [
            [
                "param1",
                "param2" => "param2",
                "param3" => [
                    "param1",
                    "param2" => "param2",
                ],
            ],
        ],
    ];

    protected function setUp(): void
    {
        $this->annotation = new Annotation();
    }

    private function getMethod(string $name): ReflectionMethod
    {
        $class = new ReflectionClass($this->annotation);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    public function testParseAnnotations(): void
    {
        $parseAnnotations = $this->getMethod("parseAnnotations");
        $this->assertEquals($this->result, $parseAnnotations->invokeArgs($this->annotation, [$this->docBlock]));
    }

    public function testGetClassAnnotations(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAnnotations(PageController::class));
    }

    public function testGetMethodAnnotations(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAnnotations(PageController::class, "indexAction"));
    }

    public function testGetClassAttributes(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAttributes(PageController::class));
    }

    public function testGetMethodAttributes(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAttributes(PageController::class, "secondAction"));
    }

    public function testGetMethodWithoutAnnotations(): void
    {
        $this->assertEquals([], $this->annotation->getAnnotations(PageController::class, "withoutDocblock"));
    }
}
