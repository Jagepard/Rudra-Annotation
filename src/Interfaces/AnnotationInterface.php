<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPL-3.0
 */

namespace Rudra\Interfaces;

/**
 * Interface AnnotationInterface
 * @package Rudra\Interfaces
 */
interface AnnotationInterface
{

    /**
     * @param string $className
     * @return array
     *
     * Получает массив из аннотаций DOCблока класса
     */
    public function getClassAnnotations(string $className): array;

    /**
     * @param string $className
     * @param string $methodName
     * @return array
     *
     * Получает массив из аннотаций DOCблока метода
     */
    public function getMethodAnnotations(string $className, string $methodName): array;
}
