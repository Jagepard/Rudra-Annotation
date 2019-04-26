<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @copyright Copyright (c) 2019, Jagepard
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Interfaces;

interface AnnotationInterface
{
    /**
     * @param string $className
     * @return array
     */
    public function getClassAnnotations(string $className): array;

    /**
     * @param string $className
     * @param string $methodName
     * @return array
     */
    public function getMethodAnnotations(string $className, string $methodName): array;
}
