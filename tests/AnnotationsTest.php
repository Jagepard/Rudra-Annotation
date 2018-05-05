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
    /**
     * @var string
     */
    protected $className;

    protected function setUp(): void
    {
        $this->annotations = new Annotations(Container::app());
        $this->className   = 'Rudra\\Tests\\Stub\\PageController';
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
        $this->assertEquals($this->result, $parseAnnotations->invokeArgs($this->annotations, [$this->docBlock]));
    }

    public function testGetClassAnnotations(): void
    {
        $this->assertEquals($this->result, $this->annotations->getClassAnnotations($this->className));
    }

    public function testGetMethodAnnotations(): void
    {
        $this->assertEquals($this->result, $this->annotations->getMethodAnnotations(
            $this->className,
            'indexAction'
        ));
    }

    public function testAnnotationException()
    {
        $this->expectException(AnnotationException::class);
        $this->annotations->getMethodAnnotations($this->className, 'errorAction');
    } // @codeCoverageIgnore
}
