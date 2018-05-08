<?php

declare(strict_types=1);

/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPL-3.0
 */

namespace Rudra;

use Rudra\Traits\SetContainerTrait;

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
     * @param string $docBlock
     * @return array
     *
     * Преобразовывает материалы представленные в аннотации в массив
     */
    protected function parseAnnotations(string $docBlock): array
    {
        $annotations = [];

        /* Разбираем данные из аннотаций (docBlock)                */
        /* matches[0] - параметр целиком: '@Routing(url = 'blog')' */
        /* matches[1] - имя параметра   : 'Routing'                */
        /* matches[2] - аргументы       : 'url = 'blog'            */
        if (preg_match_all('#@([A-Za-z_-]+)[\s\t]*\((.*)\)[\s\t]*\r?$#m', $docBlock, $matches)) {

            $count = count($matches[0]);

            for ($i = 0; $i < $count; $i++) {
                $name                 = $matches[1][$i];
                $argsString           = trim($matches[2][$i]);
                $delimited            = $this->container->new(AnnotationsSupport::class)->handleDelimiter($argsString);
                $annotations[$name][] = $delimited;
            }
        }

        return $annotations;
    }
}
