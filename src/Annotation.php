<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPL-3.0
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
 * «коммерческое at»Routing(url = '')
 * «коммерческое at»Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
 * «коммерческое at»assertResult(false)
 * «коммерческое at»Validate(name = 'min:150', phone = 'max:9')
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
     * Преобразовывает материалы представленные в аннотации в массив
     */
    protected function parseAnnotations(string $docBlock): array
    {
        $annotations = [];

        /* Разбираем данные из аннотаций (docBlock)                */
        /* matches[0] - параметр целиком: '@Routing(url = 'blog')' */
        /* matches[1] - имя параметра   : 'Routing'                */
        /* matches[2] - аргументы       : 'url = 'blog'            */
        if (preg_match_all('#@([A-Za-z_-]+)[\s\t]*\((.*)\)[\s\t]*\r?$#m', $docBlock, $matches)) {

            $count = count($matches[0]);

            for ($i = 0; $i < $count; $i++) {
                $annotations[$matches[1][$i]][] = $this->container->new(AnnotationMatcher::class)
                    ->handleDelimiter(trim($matches[2][$i]));
            }
        }

        return $annotations;
    }
}
