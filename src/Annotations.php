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
        if (preg_match_all('#@([A-Za-z_-]+)[\s\t]*\((.*)\)[\s\t]*\r?$#m', $docBlock, $matches)) {

            for ($i = 0; $i < count($matches[0]); $i++) {
                $name = $matches[1][$i];
                $args = trim($matches[2][$i]);

                if (preg_match('#=[\s\t]*{#', $args) == false) {
                    $value = $this->handleComma($args);
                } // TODO: описать работу с массивом параметров

                $annotations[$name][] = $value;//$this->getValue();
            }
        }

        return $annotations;
    }

    /**
     * Ищем ','
     * @param $args
     *
     * @return array
     */
    protected function handleComma($args)
    {
        if (strpos($args, ',') !== false) {
            $commas = explode(',', $args);
            foreach ($commas as $comma) {
                return $this->handleEvo($comma);
            }
        }

        return $this->handleEvo($args);
    }

    /**
     * Ищем '='
     *
     * @param $comma
     *
     * @return array
     */
    protected function handleEvo($comma)
    {
        if (strpos($comma, '=') !== false) {
            $evo = explode('=', $comma);
            if (preg_match('#\'(.*)\'#', $evo[1], $evoMatch)) {
                $evo[1] = $evoMatch[1];
            }

            return [trim($evo[0]) => trim($evoMatch[1])];
        }

        return $comma;
    }

}