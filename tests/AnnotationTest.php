<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPL-3.0
 *
 *  phpunit src/tests/ContainerTest --coverage-html src/tests/coverage-html
 */

namespace Rudra\Tests;

use ReflectionClass;
use ReflectionMethod;
use Rudra\Annotation;
use Rudra\Tests\Stub\PageController;
use Rudra\Interfaces\ContainerInterface;
use Rudra\Exceptions\AnnotationException;
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

/**
 * Class AnnotationsTest
 */
class AnnotationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Annotation
     */
    protected $annotation;
    /**
     * @var string
     */
    protected $docBlock = "    
        /**
         * @Routing(url = '')
         * @Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
         * @assertResult(false)
         * @Validate(name = 'min:150', phone = 'max:9')
         */
         ";
    /**
     * @var array
     */
    protected $result = [
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
        'assertResult' => [
            "false"
        ],
        'Validate'     => [
            [
                'name'  => "min:150",
                'phone' => "max:9"
            ]
        ]
    ];

    protected function setUp(): void
    {
        $rudra = rudra();
        $rudra->setBinding(ContainerInterface::class, rudra());
        $this->annotation = $rudra->new(Annotation::class);
    }

    /**
     * @param string $name
     *
     * @return ReflectionMethod
     */
    protected function getMethod(string $name): ReflectionMethod
    {
        $class  = new ReflectionClass($this->annotation());
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    public function testParseAnnotations(): void
    {
        $parseAnnotations = $this->getMethod('parseAnnotations');
        $this->assertEquals($this->result(), $parseAnnotations->invokeArgs($this->annotation(), [$this->docBlock()]));
    }

    public function testGetClassAnnotations(): void
    {
        $this->assertEquals($this->result(), $this->annotation()->getClassAnnotations(PageController::class));
    }

    public function testGetMethodAnnotations(): void
    {
        $this->assertEquals($this->result(), $this->annotation()->getMethodAnnotations(
            PageController::class,
            'indexAction'
        ));
    }

    public function testAnnotationException()
    {
        $this->expectException(AnnotationException::class);
        $this->annotation()->getMethodAnnotations(PageController::class, 'errorAction');
    }

    /**
     * @return Annotation
     */
    public function annotation(): Annotation
    {
        return $this->annotation;
    }

    /**
     * @return array
     */
    public function result(): array
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function docBlock(): string
    {
        return $this->docBlock;
    } // @codeCoverageIgnore
}
