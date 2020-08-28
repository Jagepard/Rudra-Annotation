<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Annotation;

use ReflectionClass;
use ReflectionMethod;

class Annotation implements AnnotationInterface
{
    const DELIMITER  = ["string" => ',', "array" => ';'];
    const ASSIGNMENT = ["string" => '=', "array" => ':'];

    public function getAnnotations(string $className, string $methodName = null): array
    {
        $source = isset($methodName)
            ? new ReflectionMethod($className, $methodName)
            : new ReflectionClass($className);

        return $this->parseAnnotations($source->getDocComment());
    }

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
