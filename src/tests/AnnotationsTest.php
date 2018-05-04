<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2016, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPL-3.0
 *
 *  phpunit src/tests/ContainerTest --coverage-html src/tests/coverage-html
 */

use Rudra\Container;
use Rudra\Annotations;
use Rudra\AnnotationException;
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

/**
 * Class AnnotationsTest
 */
class AnnotationsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Annotations
     */
    protected $annotations;
    /**
     * @var string
     */
    protected $docBlock;
    /**
     * @var array
     */
    protected $result;

    protected function setUp(): void
    {
        $this->annotations = new Annotations(Container::app());
        $this->docBlock    = "    
        /**
         * @Routing(url = '')
         * @Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'| state : 'Tambov'}, phone = '000-00000000')
         * @assertResult(false)
         * @Validate(name = 'min:150', phone = 'max:9')
         */
         ";

        $this->result = [
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
    }

    /**
     * @return Annotations
     */
    public function getRudraAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @return string
     */
    public function getDocBlock(): string
    {
        return $this->docBlock;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param string $name
     *
     * @return ReflectionMethod
     */
    protected function getMethod(string $name): ReflectionMethod
    {
        $class  = new ReflectionClass($this->annotations);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    public function testParseAnnotations(): void
    {
        $parseAnnotations = $this->getMethod('parseAnnotations');

        $this->assertEquals($this->getResult(), $parseAnnotations->invokeArgs($this->annotations, [$this->getDocBlock()]));
    }

    public function testGetClassAnnotations(): void
    {
        $this->assertEquals($this->getResult(), $this->getRudraAnnotations()->getClassAnnotations('PageController'));
    }

    public function testGetMethodAnnotations(): void
    {
        $this->assertEquals($this->getResult(), $this->getRudraAnnotations()->getMethodAnnotations(
            'PageController',
            'indexAction'
        ));
    }

    public function testAnnotationException()
    {
        $this->expectException(AnnotationException::class);
        $this->getRudraAnnotations()->getMethodAnnotations('PageController', 'errorAction');
    } // @codeCoverageIgnore
}
