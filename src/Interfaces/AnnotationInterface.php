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
     * @param string $methodName
     * @return array
     */
    public function getAnnotations(string $className, string $methodName = null): array;
}
