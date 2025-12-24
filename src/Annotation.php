<?php

declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Jagepard <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\Annotation;

use ReflectionClass;
use ReflectionMethod;
use Rudra\Exceptions\LogicException;

class Annotation implements AnnotationInterface
{
    /**
     * Parameter separator
     * --------------------
     * Разделитель параметров
     * 
     * in the line  ',', example: key='param', key2='param2'
     * in the array ';', example: {key:'param'; key2:'param2'}
     */
    const DELIMITER = ["string" => ',', "array" => ';'];

    /**
     * Assignment mark
     * --------------------
     * Знак присваивания
     * 
     * in the line  '=', example: key='param'
     * in the array ':', example: {key:'param'}
     */
    const ASSIGNMENT = ["string" => '=', "array" => ':'];

    /**
     * @param string $className
     * @param string|null $methodName
     * @return array
     */
    public function getAnnotations(string $className, ?string $methodName = null): array
    {
        $docBlock = $this->getReflection($className, $methodName)->getDocComment();

        if (is_string($docBlock)) {
            return $this->parseAnnotations($docBlock);
        }

        return [];
    }

    /**
     * @param string $className
     * @param string|null $methodName
     * @return array
     */
    public function getAttributes(string $className, ?string $methodName = null): array
    {
        if (version_compare(PHP_VERSION, '8.0', '<')) {
            throw new LogicException('Attributes are only supported in PHP 8.0 and above.');
        }

        $reflection = $this->getReflection($className, $methodName);
        $attributes = [];

        foreach ($reflection->getAttributes() as $attribute) {
            $attributeName = $this->extractShortClassName($attribute->getName());
            $attributes[$attributeName][] = $attribute->getArguments();
        }

        return $attributes;
    }

    /**
     * @param string $fullyQualifiedName
     * @return string
     */
    private function extractShortClassName(string $fullyQualifiedName): string
    {
        return basename(str_replace('\\', '/', $fullyQualifiedName));
    }

    /**
     * @param string $className
     * @param string|null $methodName
     * @return ReflectionClass|ReflectionMethod
     */
    private function getReflection(string $className, ?string $methodName = null): ReflectionClass|ReflectionMethod
    {
        return isset($methodName)
            ? new ReflectionMethod($className, $methodName)
            : new ReflectionClass($className);
    }

    /**
     * @param string $docBlock
     * @return array
     */
    private function parseAnnotations(string $docBlock): array
    {
        $annotations = [];

        /**
         * $matches[0][0] - @Annotation(param1, param2='param2', param3={param1;param2:'param2'})
         * $matches[1][0] - Annotation
         * $matches[2][0] - param1, param2 = 'param2', param3={param1;param2:'param2'}
         */
        if (preg_match_all("/@([A-Za-z_-]+)\((.*)?\)/", $docBlock, $matches)) {
            $count = count($matches[0]);
            $extractor = new ParamsExtractor();

            /**
             * $annotations = ["Annotation" => [[0 => "param1", "param2" => "param2", "param3" => ["param1", "param2" => "param2"]]]]
             */
            for ($i = 0; $i < $count; $i++) {
                $annotations[$matches[1][$i]][] = $extractor->getParams(
                    explode(Annotation::DELIMITER["string"], trim($matches[2][$i])),
                    Annotation::ASSIGNMENT["string"]
                );
            }
        }

        return $annotations;
    }
}
