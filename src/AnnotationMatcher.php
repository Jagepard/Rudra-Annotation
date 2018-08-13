<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPL-3.0
 */

namespace Rudra;

use Rudra\Exceptions\AnnotationException;
use Rudra\ExternalTraits\SetContainerTrait;

/**
 * Класс преобразует данные анотаций в ассоциативный массив
 *
 * Class AnnotationMatcher
 * @package Rudra
 */
class AnnotationMatcher
{

    use SetContainerTrait;

    /**
     * Разбирает данные в зависимости от разделителя (delimiter)
     *
     * @param        $data
     * @param string $delimiter
     * @param string $assignment
     * @return mixed
     * @throws AnnotationException
     */
    public function handleDelimiter(string $data, string $delimiter = ',', string $assignment = '=')
    {
        if (strpos($data, $delimiter) !== false) {
            return $this->getParams(explode($delimiter, $data), $assignment);
        }

        return $this->handleAssignment($data);
    }

    /**
     * Разбирает параметры на ключ (assignment) значение
     * и возращает массив параметров
     *
     * @param array $exploded
     * @param string $assignment
     *
     * @return array
     * @throws AnnotationException
     */
    protected function getParams(array $exploded, string $assignment): array
    {
        $handled  = [];

        foreach ($exploded as $item) {
            /* Разбираем на ключ (assignment) значение */
            $item = $this->handleAssignment($item, $assignment);

            if (!is_array($item)) {
                set_exception_handler([new AnnotationException($this->container), 'handler']);
                throw new AnnotationException($this->container, 'Ошибка парсинга аннотаций');
            }

            $handled[key($item)] = $item[key($item)];
        }

        return $handled;
    }

    /**
     * Обрабатывает строку в зависимости от наличия (assignment)
     *
     * @param string $data
     * @param string $assignment
     * @return mixed
     * @throws AnnotationException
     */
    protected function handleAssignment(string $data, string $assignment = '=')
    {
        if (strpos($data, $assignment) !== false) {
            return $this->handleData($data, explode($assignment, $data));
        }

        return $data;
    }

    /**
     * Разбирает данные на пары ключ => значение
     *
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
