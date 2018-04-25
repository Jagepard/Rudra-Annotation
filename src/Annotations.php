<?php

declare(strict_types = 1);

/**
 * Date: 13.02.17 Updated 25.04.18
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
     * Annotations constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        set_exception_handler([new AnnotationException($container), 'handler']);
    }

    /**
     * @param string $docBlock
     * @return array
     * @throws AnnotationException
     *
     * Преобразовывает материалы представленные в аннотации в массив
     */
    protected function parseAnnotations(string $docBlock): array
    {
        $annotations = [];

        /* Разбираем данные из аннотаций (docBlock)                */
        /* $matches[0] - параметр целиком: '@Routing(url = 'blog')' */
        /* $matches[1] - имя параметра   : 'Routing'                */
        /* $matches[2] - аргументы       : 'url = 'blog'            */
        if (preg_match_all('#@([A-Za-z_-]+)[\s\t]*\((.*)\)[\s\t]*\r?$#m', $docBlock, $matches)) {

            for ($i = 0; $i < count($matches[0]); $i++) {
                $name = $matches[1][$i];
                $args = trim($matches[2][$i]);
                /* Получаем значение параметра ($args): 'blog' */
                $value = $this->handleDelimiter($args);
                /* Собираем массив из полученных параметров */
                $annotations[$name][] = $value;
            }
        }

        return $annotations;
    }

    /**
     * @param        $args
     * @param string $symbol
     * @param bool   $arr
     * @return array|string
     * @throws AnnotationException
     *
     * Разделяет параметры по разделителю (symbol)
     */
    protected function handleDelimiter($args, string $symbol = ',', bool $arr = false)
    {
        if ($arr) {
            /* Разбираем на ключ : значение в массив */
            return $this->supportDelimiter($args, $symbol, ':');
        }

        if (strpos($args, $symbol) !== false) {
            /* Разбираем на ключ = значение в массив */
            return $this->supportDelimiter($args, $symbol);
        }

        /* Если в строке нет разделителя (symbol), то разбираем на ключ = значение */
        return $this->handleEquals($args);
    }

    /**
     * @param        $args
     * @param string $symbol
     * @param string $equalsSymbol
     *
     * @return array
     * @throws AnnotationException
     *
     * Разбирает параметры на ключ (equalsSymbol) значение
     * и возращает массив параметров
     */
    protected function supportDelimiter($args, string $symbol, string $equalsSymbol = '='): array
    {
        $delimitersData = [];

        foreach (explode($symbol, $args) as $data) {
            /* Разбираем на ключ (equalsSymbol) значение */
            $data = $this->handleEquals($data, $equalsSymbol);

            if (!is_array($data)) {
                throw new AnnotationException($this->container(), 'Ошибка парсинга аннотаций');
            }

            $delimitersData[key($data)] = $data[key($data)];
        }

        return $delimitersData;
    }

    /**
     * @param        $args
     * @param string $symbol
     * @param bool   $arr
     * @return array
     * @throws AnnotationException
     *
     * Разбирает данные на пары ключ => значение
     */
    protected function handleEquals($args, string $symbol = '=', bool $arr = false)
    {
        if (strpos($args, $symbol) !== false) {
            $data = explode($symbol, $args);

            /* Если в $args массив типа address = {country : 'Russia'| state : 'Tambov'}*/
            if (preg_match('#=[\s\t]*{#', $args) || $arr) {

                /* Получаем данные внутри { dataMatch[1] } */
                if (preg_match('#{(.*)}#', $data[1], $dataMatch)) {
                    $dataMatch[1] = $this->handleDelimiter(trim($dataMatch[1]), '|', true);
                }

                /* Возвращаем ключ => значение */
                return [trim($data[0]) => $dataMatch[1]];
            }

            /* Убираем кавычки вокуруг параметра */
            if (preg_match('#\'(.*)\'#', $data[1], $dataMatch)) {
                /* Возвращаем ключ => значение */
                return [trim($data[0]) => $dataMatch[1]];
            }
        }

        return $args;
    }
}
