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

class ParamsExtractor
{
    /**
     * Parses an array of parameter strings into an associative array.
     * --------------------
     * Преобразует массив строк с параметрами в ассоциативный массив.
     * 
     * `from: "param1, param2 = 'param2', param3={param1;param2:'param2'}"`
     * `to: ["param1", "param2" => "param2", "param3" => ["param1", "param2" => "param2"]]`
     * 
     * @param array $exploded
     * @param string $assignment
     * @return array
     */
    public function getParams(array $exploded, string $assignment): array
    {
        $processed = [];

        foreach ($exploded as $key => $item) {
            if (str_contains($item, $assignment)) {
                $item = $this->handleData($item, explode($assignment, $item));
            }
            $processed[is_array($item) ? key($item) : $key] = is_array($item) ? $item[key($item)] : $item;
        }

        return $processed;
    }


    /**
     * Parses data into `key => value` pairs
     * --------------------
     * Преобразует данные в пары `ключ => значение`
     *
     * @param string $data
     * @param array $exploded
     * @return array|null
     */
    private function handleData(string $data, array $exploded): ?array
    {
        /**
         * If in data an array of type param3={param1;param2:'param2'}
         * --------------------
         * Если в данных есть массив типа param3={param1;param2:'param2'}
         */
        if (preg_match("/=\s*{/", $data) && preg_match("/{(.*)}/", $exploded[1], $matches)) {
            return [
                trim($exploded[0]) => $this->getParams(
                    explode(Annotation::DELIMITER["array"], trim($matches[1])),
                    Annotation::ASSIGNMENT["array"]
                ),
            ];
        }

        /**
         * Remove quotation marks around parameter
         * --------------------
         * Удаляет кавычки вокруг параметра
         * 
         * matches[1] = 'param2';
         */
        if (preg_match("/'(.*)'/", $exploded[1], $matches)) {
            return [trim($exploded[0]) => $matches[1]];
        }
    } // @codeCoverageIgnore
}
