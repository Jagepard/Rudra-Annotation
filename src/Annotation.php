<?php

declare(strict_types=1);

/**
 * @author  Jagepard <jagepard@yandex.ru">
 * @license https://mit-license.org/ MIT
 */

namespace Rudra\Annotation;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionException;

class Annotation implements AnnotationInterface
{
    /*
     * Parameter separator
     * in the line  ',', example: key='param', key2='param2'
     * in the array ';', example {key:'param'; key2:'param2'}
     * ------------------------------------------------------
     * Разделитель параметров
     * в строке  ',', пример: key='param', key2='param2'
     * в массиве ';', пример: {key:'param'; key2:'param2'}
     */
    const DELIMITER  = ["string" => ',', "array" => ';'];

    /*
     * Sign assigning value
     * in the line  '=', example: key='param'
     * in the array ':', example: {key:'param'}
     * ----------------------------------------
     * Знак присваивающий значение
     * в строке  '=', пример: key='param'
     * в массиве ':', пример: {key:'param'}
     */
    const ASSIGNMENT = ["string" => '=', "array" => ':'];

    /**
     * Get data from annotations
     * -------------------------
     * Получить данные из аннотаций
     * 
     * @param string $className
     * @param string|null $methodName
     * @return array
     * @throws ReflectionException
     */
    public function getAnnotations(string $className, ?string $methodName = null)
    {
        $docBlock = $this->getReflection($className, $methodName)->getDocComment();

        if (is_string($docBlock)) return $this->parseAnnotations($docBlock);
    }

    /**
     * Get data from attributes (for php 8 and up)
     * -------------------------------------------
     * Получить данные из атрибутов (для php 8 и выше)
     * 
     * @param string $className
     * @param string|null $methodName
     * @return array
     * @throws Exception
     */
    public function getAttributes(string $className, ?string $methodName = null)
    {
        if (version_compare(phpversion(), "8.0", ">=")) {
            $attributes = [];
            foreach ($this->getReflection($className, $methodName)->getAttributes() as $attribute) {
                $attributes[substr(strrchr($attribute->getName(), "\\"), 1)][] = $attribute->getArguments();
            }

            return $attributes;
        }

        throw new Exception("Wrong php version!");
    }

    /**
     * Provides information about a method or class
     * --------------------------------------------
     * Сообщает информацию о методе или классе
     * 
     * @param string $className
     * @param string|null $methodName
     * @return ReflectionClass|ReflectionMethod
     * @throws ReflectionException
     */
    private function getReflection(string $className, ?string $methodName = null)
    {
        return isset($methodName)
            ? new ReflectionMethod($className, $methodName)
            : new ReflectionClass($className);
    }

    /**
     * Parses annotation data
     * ----------------------
     * Разбирает данные аннотаций
     * 
     * @param string $docBlock
     * @return array
     */
    private function parseAnnotations(string $docBlock): array
    {
        $annotations = [];

        if (preg_match_all("/@([A-Za-z_-]+)\((.*)?\)/", $docBlock, $matches)) {
            $count = count($matches[0]);
            $matcher = new AnnotationMatcher();

            for ($i = 0; $i < $count; $i++) {
                $annotations[$matches[1][$i]][] = $matcher->getParams(
                    explode(Annotation::DELIMITER["string"], trim($matches[2][$i])),
                    Annotation::ASSIGNMENT["string"]
                );
            }
        }

        return $annotations;
    }
}
