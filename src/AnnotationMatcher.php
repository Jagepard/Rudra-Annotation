<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @copyright Copyright (c) 2019, Jagepard
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra;

use Rudra\Exceptions\AnnotationException;

final class AnnotationMatcher
{
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
        return $this->getParams(explode($delimiter, $data), $assignment);
    }

    /**
     * Разбирает параметры на ключ (assignment) значение
     * и возращает массив параметров
     *
     * @param array  $exploded
     * @param string $assignment
     *
     * @return array
     * @throws AnnotationException
     */
    private function getParams(array $exploded, string $assignment): array
    {
        $i       = 0;
        $handled = [];

        foreach ($exploded as $item) {
            $item = $this->handleAssignment($item, $assignment);
            (is_array($item)) ? $handled[key($item)] = $item[key($item)] : $handled[$i] = $item;
            $i++;
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
    private function handleAssignment(string $data, string $assignment = '=')
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
    private function handleData(string $data, array $exploded): array
    {
        /* Если в $data массив типа address = {country : 'Russia'; state : 'Tambov'}*/
        if (preg_match('/=[\s]+{/', $data) && preg_match('/{(.*)}/', $exploded[1], $dataMatch)) {
            return [trim($exploded[0]) => $this->handleDelimiter(trim($dataMatch[1]), ';', ':')];
        }

        /* Убираем кавычки вокуруг параметра */
        if (preg_match("/'(.*)'/", $exploded[1], $dataMatch)) {
            return [trim($exploded[0]) => $dataMatch[1]];
        }
    } // @codeCoverageIgnore
}
