<?php

declare(strict_types=1);

/**
 * @author  Jagepard <jagepard@yandex.ru">
 * @license https://mit-license.org/ MIT
 */

namespace Rudra\Annotation;

use ReflectionClass;
use ReflectionMethod;
use Rudra\Exceptions\LogicException;

class Annotation implements AnnotationInterface
{
    /*
     * Parameter separator
     * in the line  ',', example: key='param', key2='param2'
     * in the array ';', example {key:'param'; key2:'param2'}
     */
    const DELIMITER = ["string" => ',', "array" => ';'];

    /*
     * Sign assigning value
     * in the line  '=', example: key='param'
     * in the array ':', example: {key:'param'}
     */
    const ASSIGNMENT = ["string" => '=', "array" => ':'];

    /**
     * @param  string      $className
     * @param  string|null $methodName
     * @return void
     */
    public function getAnnotations(string $className, ?string $methodName = null)
    {
        $docBlock = $this->getReflection($className, $methodName)->getDocComment();

        if (is_string($docBlock)) {
            return $this->parseAnnotations($docBlock); 
        }
    }

    /**
     * @param  string      $className
     * @param  string|null $methodName
     * @return void
     */
    public function getAttributes(string $className, ?string $methodName = null): array
    {
        if (version_compare(PHP_VERSION, '8.0', '<')) {
            throw new LogicException('Attributes are only supported in PHP 8.0 and above.');
        }

        $reflection = $this->getReflection($className, $methodName);
        $attributes = [];

        foreach ($reflection->getAttributes() as $attribute) {
            $attributeName = $this->extractShortName($attribute->getName());
            $attributes[$attributeName][] = $attribute->getArguments();
        }

        return $attributes;
    }

    /**
     * @param  string $fullyQualifiedName
     * @return string
     */
    private function extractShortName(string $fullyQualifiedName): string
    {
        return basename(str_replace('\\', '/', $fullyQualifiedName));
    }

    /**
     * @param  string      $className
     * @param  string|null $methodName
     * @return void
     */
    private function getReflection(string $className, ?string $methodName = null)
    {
        return isset($methodName)
            ? new ReflectionMethod($className, $methodName)
            : new ReflectionClass($className);
    }

    /**
     * @param  string $docBlock
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
