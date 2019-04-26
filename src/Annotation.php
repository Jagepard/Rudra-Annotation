<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @copyright Copyright (c) 2019, Jagepard
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra;

use \ReflectionClass;
use \ReflectionMethod;
use Rudra\Interfaces\AnnotationInterface;
use Rudra\ExternalTraits\SetContainerTrait;

/**
 * Class Annotations
 *
 * Класс разбора данных из аннотаций, представленных в следующем виде:
 *
 * Routing(url = '')
 * Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
 * assertResult(false)
 * Validate(name = 'min:150', phone = 'max:9')
 *
 * Разделителем свойств является - ','
 * Разделителем в массивах является - ';'
 * ':' - разделяет ключ, значение в ассоциативном массиве
 * Значение параметров указывается в одинарных кавычках
 *
 * @package Rudra
 */
class Annotation implements AnnotationInterface
{
    use SetContainerTrait;

    /**
     * @param string $className
     * @return array
     * @throws Exceptions\AnnotationException
     * @throws \ReflectionException
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
     * @throws Exceptions\AnnotationException
     * @throws \ReflectionException
     */
    public function getMethodAnnotations(string $className, string $methodName): array
    {
        $method = new ReflectionMethod($className, $methodName);
        return $this->parseAnnotations($method->getDocComment());
    }

    /**
     * @param string $docBlock
     * @return array
     * @throws Exceptions\AnnotationException
     */
    protected function parseAnnotations(string $docBlock): array
    {
        $annotations = [];

        if (preg_match_all('/@([A-Za-z_-]+)\((.*)?\)/', $docBlock, $matches)) {
            $count   = count($matches[0]);
            $matcher = new AnnotationMatcher($this->container());

            for ($i = 0; $i < $count; $i++) {
                $annotations[$matches[1][$i]][] = $matcher->handleDelimiter(trim($matches[2][$i]));
            }
        }

        return $annotations;
    }
}
