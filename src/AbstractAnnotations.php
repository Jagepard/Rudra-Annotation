<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPLv3.0
 */

namespace Rudra;


use \ReflectionClass;
use \ReflectionMethod;


/**
 * Class AbstractAnnotations
 * @package Rudra
 *
 * Класс определяет источники извлечения аннотаций
 */
abstract class AbstractAnnotations
{

    /**
     * @param string $className
     * @return array
     *
     * Получает массив из аннотаций DOCблока класса
     */
    public function getClassAnnotations(string $className): array
    {
        $class = new ReflectionClass($className);

        return $this->parseAnnotations($class->getDocComment());
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return array
     *
     * Получает массив из аннотаций DOCблока метода
     */
    public function getMethodAnnotations(string $className, string $methodName): array
    {
        $method = new ReflectionMethod($className, $methodName);

        return $this->parseAnnotations($method->getDocComment());
    }

    /**
     * @param string $docBlock
     * @return array
     *
     * Метод должен преобразовать материалы представленные в аннотации в массив
     */
    abstract protected function parseAnnotations(string $docBlock): array;
}
