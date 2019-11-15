<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @copyright Copyright (c) 2019, Jagepard
 * @license   https://mit-license.org/ MIT
 *
 * phpunit src/tests/ContainerTest --coverage-html src/tests/coverage-html
 */

namespace Rudra\Tests;

use ReflectionClass;
use ReflectionMethod;
use Rudra\Annotation;
use Rudra\Tests\Stub\PageController;
use Rudra\Interfaces\ContainerInterface;
use Rudra\Interfaces\AnnotationInterface;
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

class AnnotationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotationInterface
     */
    private $annotation;
    /**
     * @var string
     */
    private $docBlock = "    
        /**
         * @Routing(url = '')
         * @Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
         * @assertResult(false)
         * @Validate(name = 'min:150', phone = 'max:9')
         * @Middleware('Middleware', params = {int1 : '123'})
         */
         ";
    /**
     * @var array
     */
    private $result = [
        'Routing'      => [['url' => ""]],
        'Defaults'     => [
            [
                'name'     => "user1",
                'lastname' => "sample",
                'age'      => "0",
                'address'  => [
                    'country' => "Russia",
                    'state'   => "Tambov"
                ],
                'phone'    => "000-00000000"
            ]
        ],
        'assertResult' => [["false"]],
        'Validate'     => [
            [
                'name'  => "min:150",
                'phone' => "max:9"
            ]
        ],
        'Middleware'   => [
            [
                0        => "'Middleware'",
                'params' => [
                    'int1' => '123'
                ]
            ]
        ]
    ];

    protected function setUp(): void
    {
        rudra()->setBinding(ContainerInterface::class, rudra());
        $this->annotation = rudra()->new(Annotation::class);
    }

    /**
     * @param string $name
     * @return ReflectionMethod
     * @throws \ReflectionException
     */
    private function getMethod(string $name): ReflectionMethod
    {
        $class  = new ReflectionClass($this->annotation);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    public function testParseAnnotations(): void
    {
        $parseAnnotations = $this->getMethod('parseAnnotations');
        $this->assertEquals($this->result, $parseAnnotations->invokeArgs($this->annotation, [$this->docBlock]));
    }

    public function testGetClassAnnotations(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAnnotations(PageController::class));
    }

    public function testGetMethodAnnotations(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAnnotations(
            PageController::class,
            'indexAction'
        ));
    }
}
