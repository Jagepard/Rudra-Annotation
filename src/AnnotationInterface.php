<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Annotation;

interface AnnotationInterface
{
    public function getAnnotations(string $className, ?string $methodName = null): array;
}
