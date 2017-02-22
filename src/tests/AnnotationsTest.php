<?php

use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

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
class AnnotationsTest extends PHPUnit_Framework_TestCase
{

    protected $annotations;
    protected $docBlock;
    protected $result;

    protected function setUp()
    {
        $this->annotations = new \Rudra\Annotations();
        $this->docBlock    = "    
        /**
         * @Routing(url = '')
         * @Defaults(name='user1'| lastname = 'sample'| age='0'| address = {country : 'Russia', state : 'Tambov'}| phone = '000-00000000')
         * @assertResult(false)
         * @Validate(name = 'min:150'| phone = 'max:9')
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
     * @return mixed
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @return mixed
     */
    public function getDocBlock()
    {
        return $this->docBlock;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $name
     *
     * @return \ReflectionMethod
     */
    protected function getMethod($name)
    {
        $class  = new ReflectionClass($this->annotations);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    public function testParseAnnotations()
    {
        $parseAnnotations = $this->getMethod('parseAnnotations');

        $this->assertEquals($this->getResult(), $parseAnnotations->invokeArgs($this->annotations, [$this->getDocBlock()]));
    }

    public function testGetClassAnnotations()
    {
        $this->assertEquals($this->getResult(), $this->getAnnotations()->getClassAnnotations('Test'));
    }

    public function testGetMethodAnnotations()
    {
        $this->assertEquals($this->getResult(), $this->getAnnotations()->getMethodAnnotations('Test', 'index'));
    }

}
