<?php

/**
 * @author  Jagepard <jagepard@yandex.ru">
 * @license https://mit-license.org/ MIT
 */

namespace Rudra\Annotation;

interface AnnotationInterface
{
    /**
     * Get data from annotations
     * -------------------------
     * Получить данные из аннотаций
     * 
     * @param string $className
     * @param string|null $methodName
     * @return array
     */
    public function getAnnotations(string $className, ?string $methodName = null);

    /**
     * Get data from attributes (for php 8 and up)
     * -------------------------------------------
     * Получить данные из атрибутов (для php 8 и выше)
     * 
     * @param string $className
     * @param string|null $methodName
     * @return array
     */
    public function getAttributes(string $className, ?string $methodName = null);
}
