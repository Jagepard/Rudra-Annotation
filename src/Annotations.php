<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPLv3.0
 */

namespace Rudra;

/**
 * Class Annotations
 * @package Rudra
 *
 * Класс разбора данных из аннотаций, представленных в следующем виде:
 *
 * @Routing(url = '')
 * @Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'| state : 'Tambov'}, phone = '000-00000000')
 * @assertResult(false)
 * @Validate(name = 'min:150', phone = 'max:9')
 *
 * Разделителем свойств является - ','
 * Разделителем в массивах является - '|'
 * ':' - разделяет ключ, значение в ассоциативном массиве
 * Значение параметров указывается в одинарных кавычках
 */
class Annotations extends AbstractAnnotations
{

    use SetContainerTrait;

    /**
     * Annotations constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        set_exception_handler([new AnnotationException($container), 'handler']);
    }

    /**
     * @param string $docBlock
     * @return array
     * @throws AnnotationException
     *
     * Преобразовывает материалы представленные в аннотации в массив
     */
    protected function parseAnnotations(string $docBlock): array
    {
        $annotations = [];

        /* Разбираем данные из аннотаций (docBlock)                */
        /* $matches[0] - параметр целиком: '@Routing(url = 'blog')' */
        /* $matches[1] - имя параметра   : 'Routing'                */
        /* $matches[2] - аргументы       : 'url = 'blog'            */
        if (preg_match_all('#@([A-Za-z_-]+)[\s\t]*\((.*)\)[\s\t]*\r?$#m', $docBlock, $matches)) {

            $count = count($matches[0]);

            for ($i = 0; $i < $count; $i++) {
                $name                 = $matches[1][$i];
                $argsString           = trim($matches[2][$i]);
                $delimited            = $this->handleDelimiter($argsString);
                $annotations[$name][] = $delimited;
            }
        }

        return $annotations;
    }

    /**
     * @param        $args
     * @param string $delimiter
     * @param string $assignment
     * @return array
     * @throws AnnotationException
     */
    protected function handleDelimiter(string $args, string $delimiter = ',', string $assignment = '=')
    {
        if (strpos($args, $delimiter) !== false) {
            return $this->getArrayParams($args, $delimiter, $assignment);
        }

        return $this->handleAssignment($args);
    }

    /**
     * @param string $args
     * @param string $delimiter
     * @param string $assignment
     *
     * @return array
     * @throws AnnotationException
     *
     * Разбирает параметры на ключ (assignment) значение
     * и возращает массив параметров
     */
    protected function getArrayParams(string $args, string $delimiter, string $assignment): array
    {
        $delimited = [];
        $arrayArgs = explode($delimiter, $args);

        foreach ($arrayArgs as $item) {
            /* Разбираем на ключ (assignment) значение */
            $item = $this->handleAssignment($item, $assignment);

            if (!is_array($item)) {
                throw new AnnotationException($this->container(), 'Ошибка парсинга аннотаций');
            }

            $delimited[key($item)] = $item[key($item)];
        }

        return $delimited;
    }

    /**
     * @param string $args
     * @param string $assignment
     * @return mixed
     * @throws AnnotationException
     *
     * Разбирает данные на пары ключ => значение
     */
    protected function handleAssignment(string $args, string $assignment = '=')
    {
        if (strpos($args, $assignment) !== false) {
            $data = explode($assignment, $args);

            /* Если в $args массив типа address = {country : 'Russia'| state : 'Tambov'}*/
            if (preg_match('#=[\s\t]*{#', $args)) {

                /* Получаем данные внутри { dataMatch[1] } */
                if (preg_match('#{(.*)}#', $data[1], $dataMatch)) {
                    $dataMatch[1] = $this->handleDelimiter(trim($dataMatch[1]), '|', ':');
                }

                return [trim($data[0]) => $dataMatch[1]];
            }

            /* Убираем кавычки вокуруг параметра */
            if (preg_match("#'(.*)'#", $data[1], $dataMatch)) {
                return [trim($data[0]) => $dataMatch[1]];
            }
        }

        return $args;
    }
}
