<?php

declare(strict_types=1);

/**
 * @author  Jagepard <jagepard@yandex.ru">
 * @license https://mit-license.org/ MIT
 */

namespace Rudra\Annotation;

interface AnnotationInterface
{
    /**
     * @param string $className
     * @param string|null $methodName
     * @return array
     */
    public function getAnnotations(string $className, ?string $methodName = null): array;

    /**
     * @param string $className
     * @param string|null $methodName
     * @return array
     */
    public function getAttributes(string $className, ?string $methodName = null): array;
}
