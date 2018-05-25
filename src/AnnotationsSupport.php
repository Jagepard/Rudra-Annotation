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
 *
 * Класс преобразует данные анотаций в ассоциативный массив
 */
class AnnotationsSupport
{

    use SetContainerTrait;

    /**
     * @param        $data
     * @param string $delimiter
     * @param string $assignment
     * @return mixed
     * @throws AnnotationException
     *
     * Разбирает данные в зависимости от наличия разделителя
     */
    public function handleDelimiter(string $data, string $delimiter = ',', string $assignment = '=')
    {
        if (strpos($data, $delimiter) !== false) {
            return $this->getArrayParams($data, $delimiter, $assignment);
        }

        return $this->handleAssignment($data);
    }

    /**
     * @param string $data
     * @param string $delimiter
     * @param string $assignment
     *
     * @return array
     * @throws AnnotationException
     *
     * Разбирает параметры на ключ (assignment) значение
     * и возращает массив параметров
     */
    protected function getArrayParams(string $data, string $delimiter, string $assignment): array
    {
        $delimited  = [];
        $inputArray = explode($delimiter, $data);

        foreach ($inputArray as $item) {
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
     * @param string $data
     * @param string $assignment
     * @return mixed
     * @throws AnnotationException
     *
     * Разбирает данные на пары ключ => значение
     */
    protected function handleAssignment(string $data, string $assignment = '=')
    {
        if (strpos($data, $assignment) !== false) {
            return $this->handleData($data, explode($assignment, $data));
        }

        return $data;
    }

    /**
     * @param string $data
     * @param array  $exploded
     * @return array
     * @throws AnnotationException
     */
    protected function handleData(string $data, array $exploded): array
    {
        /* Если в $data массив типа address = {country : 'Russia'; state : 'Tambov'}*/
        if (preg_match('#=[\s\t]*{#', $data) && preg_match('#{(.*)}#', $exploded[1], $dataMatch)) {
            return [trim($exploded[0]) => $this->handleDelimiter(trim($dataMatch[1]), ';', ':')];
        }

        /* Убираем кавычки вокуруг параметра */
        if (preg_match("#'(.*)'#", $exploded[1], $dataMatch)) {
            return [trim($exploded[0]) => $dataMatch[1]];
        }
    } // @codeCoverageIgnore
}
