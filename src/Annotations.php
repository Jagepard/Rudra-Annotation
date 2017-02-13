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
     * @var
     */
    protected $value;

    /**
     * Parse annotations
     *
     * @param  string $docBlock
     *
     * @return array parsed annotations params
     */
    protected function parseAnnotations($docBlock)
    {
        if (preg_match_all('#@(?<name>[A-Za-z_-]+)[\s\t]*\((?<args>.*)\)[\s\t]*\r?$#m', $docBlock, $matches)) {

            for ($i = 0; $i < count($matches[0]); $i++) {
                $name = $matches['name'][$i];
                $args = trim($matches['args'][$i]);

                if (preg_match('#=[\s\t]*{#', $args) == false) {
                    $this->handleComma($args);
                } // TODO: описать работу с массивом параметров

                !d($this->getValue());
                $annotations[$name][] = $this->getValue();
            }
        }

        return $annotations;
    }

    /**
     * Ищем ','
     *
     * @param $args
     */
    protected function handleComma($args)
    {
        if (strpos($args, ',') !== false) {
            $commas = explode(',', $args);
            foreach ($commas as $comma) {
                $this->handleEvo($comma);
            }
        } else {
            $comma = $args;
            $this->handleEvo($comma);
        }
    }

    /**
     * Ищем '='
     *
     * @param $comma
     */
    protected function handleEvo($comma)
    {
        if (strpos($comma, '=') !== false) {
            $evo = explode('=', $comma);
            if (preg_match('#\'(.*)\'#', $evo[1], $evoMatch)) {
                $evo[1] = $evoMatch[1];
            }

            $this->setValue(trim($evo[0]), trim($evoMatch[1]));
        } else {
            $this->setValue('string', $comma);
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setValue($key, $value)
    {
        if ('string' == $key) {
            $this->value = $value;
        } else {
            $this->value[$key] = $value;
        }
    }

}