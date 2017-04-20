<?php

declare(strict_types = 1);

/**
 * Date: 17.02.17
 * Time: 13:23
 *
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2016, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPLv3.0
 *
 *  phpunit src/tests/ContainerTest --coverage-html src/tests/coverage-html
 */


use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;
use Rudra\Annotations;


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
        $this->annotations = new Annotations();
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
    public function getAnnotations()
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
        $this->assertEquals($this->getResult(), $this->getAnnotations()->getClassAnnotations('PageController'));
    }

    public function testGetMethodAnnotations(): void
    {
        $this->assertEquals($this->getResult(), $this->getAnnotations()->getMethodAnnotations('PageController', 'indexAction'));
    }
}
