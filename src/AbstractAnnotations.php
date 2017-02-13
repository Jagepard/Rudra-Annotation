<?php

/**
 * Date: 13.02.17
 * Time: 16:54
 *
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2016, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPLv3.0
 */

namespace Rudra;

/**
 * Class AbstractAnnotations
 *
 * @package Rudra
 */
abstract class AbstractAnnotations
{

    /**
     * @param $className
     *
     * @return array
     */
    public function getClassAnnotations($className)
    {
        $class = new \ReflectionClass($className);

        return $this->parseAnnotations($class->getDocComment());
    }

    /**
     * @param $className
     * @param $methodName
     *
     * @return mixed
     */
    public function getMethodAnnotations($className, $methodName)
    {
        $method = new \ReflectionMethod($className, $methodName);

        return $this->parseAnnotations($method->getDocComment());
    }

    /**
     * Parse annotations
     *
     * @param  string $docBlock
     *
     * @return array parsed annotations params
     */
    abstract protected function parseAnnotations($docBlock);

}