<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPL-3.0
 */

namespace Rudra;

use Rudra\ExternalTraits\SetContainerTrait;
use Rudra\Exceptions\AnnotationException;

/**
 * Class AnnotationsSupport
 * @package Rudra
 */
class AnnotationsSupport
{

    use SetContainerTrait;

    /**
     * @param        $args
     * @param string $delimiter
     * @param string $assignment
     * @return mixed
     * @throws AnnotationException
     */
    public function handleDelimiter(string $args, string $delimiter = ',', string $assignment = '=')
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
                set_exception_handler([new AnnotationException($this->container), 'handler']);
                throw new AnnotationException($this->container, 'Ошибка парсинга аннотаций');
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
            return $this->handleData($args, explode($assignment, $args));
        }

        return $args;
    }

    /**
     * @param string $args
     * @param array  $data
     * @return array
     * @throws AnnotationException
     */
    protected function handleData(string $args, array $data): array
    {
        /* Если в $args массив типа address = {country : 'Russia'| state : 'Tambov'}*/
        if (preg_match('#=[\s\t]*{#', $args) && preg_match('#{(.*)}#', $data[1], $dataMatch)) {
            return [trim($data[0]) => $this->handleDelimiter(trim($dataMatch[1]), '|', ':')];
        }

        /* Убираем кавычки вокуруг параметра */
        if (preg_match("#'(.*)'#", $data[1], $dataMatch)) {
            return [trim($data[0]) => $dataMatch[1]];
        }
    } // @codeCoverageIgnore
}
