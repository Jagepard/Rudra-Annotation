<?php

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
     * Parse annotations
     *
     * @param  string $docBlock
     *
     * @return array parsed annotations params
     */
    protected function parseAnnotations($docBlock)
    {
        $annotations = [];

        if (preg_match_all('#@([A-Za-z_-]+)[\s\t]*\((.*)\)[\s\t]*\r?$#m', $docBlock, $matches)) {

            for ($i = 0; $i < count($matches[0]); $i++) {
                $name = $matches[1][$i];
                $args = trim($matches[2][$i]);

                if (preg_match('#=[\s\t]*{#', $args) == false) {
                    $value = $this->handleDelimiter($args);
                } else {
                    $value = $this->handleEquals($args, '=', true);
                }

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
     * @return array
     */
    protected function handleDelimiter($args, $symbol = '|', $arr = false)
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
     * @param        $symbol
     * @param string $equalsSymbol
     *
     * @return array
     */
    protected function supportDelimiter($args, $symbol, $equalsSymbol = '=')
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
     * @return array
     */
    protected function handleEquals($args, $symbol = '=', $arr = false)
    {
        if (strpos($args, $symbol) !== false) {
            $data = explode($symbol, $args);

            if ($arr) {
                return [trim($data[0]) => $this->supportEquals($data, '#{(.*)}#')];
            }

            return [trim($data[0]) => trim($this->supportEquals($data))];
        }

        return $args;
    }

    /**
     * @param        $data
     * @param string $pattern
     *
     * @return array
     */
    protected function supportEquals($data, $pattern = '#\'(.*)\'#')
    {
        if (preg_match($pattern, $data[1], $dataMatch)) {
            $dataMatch[1] = $this->handleDelimiter(trim($dataMatch[1]), ',', true);

            return $dataMatch[1];
        }
    }

}