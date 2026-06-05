<?php declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\Annotation;

class Annotation implements AnnotationInterface
{
    /**
     * Parameter separator
     * 
     * in the line  ',', example: key='param', key2='param2'
     * in the array ';', example: {key:'param'; key2:'param2'}
     */
    public const array DELIMITER = ["string" => ',', "array" => ';'];

    /**
     * Assignment mark
     * 
     * in the line  '=', example: key='param'
     * in the array ':', example: {key:'param'}
     */
    public const array ASSIGNMENT = ["string" => '=', "array" => ':'];

    /**
     * Each parameter must be on its own line.
     */
    #[\Override]
    public function getAnnotations(string $className, ?string $methodName = null): array
    {
        $docBlock = $this->getReflection($className, $methodName)->getDocComment();

        if (is_string($docBlock)) {
            return $this->parseAnnotations($docBlock);
        }

        return [];
    }

    /**
     * Returns all attributes for a class or method.
     * Returns short class names (e.g. `Cache`, not `App\Attributes\Cache`).
     */
    #[\Override]
    public function getAttributes(string $className, ?string $methodName = null): array
    {
        $reflection = $this->getReflection($className, $methodName);
        $attributes = [];

        foreach ($reflection->getAttributes() as $attribute) {
            $attributeName = $this->extractShortClassName($attribute->getName());
            $attributes[$attributeName][] = $attribute->getArguments();
        }

        return $attributes;
    }

    private function extractShortClassName(string $fullyQualifiedName): string
    {
        $pos = strrpos($fullyQualifiedName, '\\');
        return $pos === false ? $fullyQualifiedName : substr($fullyQualifiedName, $pos + 1);
    }

    private function getReflection(string $className, ?string $methodName = null): \ReflectionClass|\ReflectionMethod
    {
        return $methodName !== null
            ? new \ReflectionMethod($className, $methodName)
            : new \ReflectionClass($className);
    }

    private function parseAnnotations(string $docBlock): array
    {
        $annotations = [];

        /**
         * $matches[0][0] - @Annotation(param1, param2='param2', param3={param1;param2:'param2'})
         * $matches[1][0] - Annotation         
         * $matches[2][0] - param1, param2 = 'param2', param3={param1;param2:'param2'}
         */
        if (preg_match_all("/@([A-Za-z0-9_-]+)\((.*?)\)/", $docBlock, $matches)) {
            $count = count($matches[0]);
            $extractor = new ParamsExtractor();

            // $annotations = ["Annotation" => [[0 => "param1", "param2" => "param2", "param3" => ["param1", "param2" => "param2"]]]]
            for ($i = 0; $i < $count; $i++) {
                $annotations[$matches[1][$i]][] = $extractor->getParams(
                    str_getcsv(trim($matches[2][$i]), self::DELIMITER["string"], '"', ''),
                    self::ASSIGNMENT["string"]
                );
            }
        }

        return $annotations;
    }
}
