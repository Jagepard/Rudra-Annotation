<?php

declare(strict_types = 1);

/**
 * Date: 13.02.17
 * Time: 16:54
 *
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2016, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPLv3.0
 */

namespace Rudra;

/**
 * Class Annotations
 *
 * @package Rudra
 */
class Annotations extends AbstractAnnotations
{

    /**
     * @param string $docBlock
     *
     * @return array
     */
    protected function parseAnnotations(string $docBlock): array
    {
        $annotations = [];
        if (preg_match_all('#@([A-Za-z_-]+)[\s\t]*\((.*)\)[\s\t]*\r?$#m', $docBlock, $matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $name                 = $matches[1][$i];
                $args                 = trim($matches[2][$i]);
                $value                = $this->handleDelimiter($args);
                $annotations[$name][] = $value;
            }
        }

        return $annotations;
    }

    /**
     * @param        $args
     * @param string $symbol
     * @param bool   $arr
     *
     * @return array|string
     */
    protected function handleDelimiter($args, string $symbol = '|', bool $arr = false)
    {
        if (strpos($args, $symbol) !== false) {
            if ($arr) {
                return $this->supportDelimiter($args, $symbol, ':');
            }

            return $this->supportDelimiter($args, $symbol);
        }

        return $this->handleEquals($args);
    }

    /**
     * @param        $args
     * @param string $symbol
     * @param string $equalsSymbol
     *
     * @return array
     */
    protected function supportDelimiter($args, string $symbol, string $equalsSymbol = '='): array
    {
        $delimitersData = [];
        foreach (explode($symbol, $args) as $data) {
            $data                       = $this->handleEquals($data, $equalsSymbol);
            $delimitersData[key($data)] = $data[key($data)];
        }

        return $delimitersData;
    }

    /**
     * @param        $args
     * @param string $symbol
     * @param bool   $arr
     *
     * @return array|string
     */
    protected function handleEquals($args, string $symbol = '=', bool $arr = false)
    {
        if (strpos($args, $symbol) !== false) {
            $data = explode($symbol, $args);

            if (preg_match('#=[\s\t]*{#', $args) or $arr) {
                if (preg_match('#{(.*)}#', $data[1], $dataMatch)) {
                    $dataMatch[1] = $this->handleDelimiter(trim($dataMatch[1]), ',', true);
                }

                return [trim($data[0]) => $dataMatch[1]];
            }

            if (preg_match('#\'(.*)\'#', $data[1], $dataMatch)) {
                return [trim($data[0]) => $dataMatch[1]];
            }
        }

        return $args;
    }
}