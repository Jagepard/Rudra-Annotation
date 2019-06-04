## Table of contents

- [\Rudra\AnnotationMatcher](#class-rudraannotationmatcher)
- [\Rudra\Annotation](#class-rudraannotation)
- [\Rudra\Interfaces\AnnotationInterface (interface)](#interface-rudrainterfacesannotationinterface)

<hr /><a id="class-rudraannotationmatcher"></a>
### Class: \Rudra\AnnotationMatcher

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Rudra\Interfaces\ContainerInterface</em> <strong>$container</strong>)</strong> : <em>void</em><br /><em>SetContainerTrait constructor.</em> |
| public | <strong>container()</strong> : <em>\Rudra\ContainerInterface</em> |
| public | <strong>handleDelimiter(</strong><em>mixed/\string</em> <strong>$data</strong>, <em>\string</em> <strong>$delimiter=`','`</strong>, <em>\string</em> <strong>$assignment=`'='`</strong>)</strong> : <em>mixed</em><br /><em>Разбирает данные в зависимости от разделителя (delimiter)</em> |
| protected | <strong>getParams(</strong><em>array</em> <strong>$exploded</strong>, <em>\string</em> <strong>$assignment</strong>)</strong> : <em>array</em><br /><em>Разбирает параметры на ключ (assignment) значение и возращает массив параметров</em> |
| protected | <strong>handleAssignment(</strong><em>\string</em> <strong>$data</strong>, <em>\string</em> <strong>$assignment=`'='`</strong>)</strong> : <em>mixed</em><br /><em>Обрабатывает строку в зависимости от наличия (assignment)</em> |
| protected | <strong>handleData(</strong><em>\string</em> <strong>$data</strong>, <em>array</em> <strong>$exploded</strong>)</strong> : <em>array</em><br /><em>Разбирает данные на пары ключ => значение</em> |

<hr /><a id="class-rudraannotation"></a>
### Class: \Rudra\Annotation

> Класс разбора данных из аннотаций, представленных в следующем виде: Routing(url = '') Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000') assertResult(false) Validate(name = 'min:150', phone = 'max:9') Разделителем свойств является - ',' Разделителем в массивах является - ';' ':' - разделяет ключ, значение в ассоциативном массиве Значение параметров указывается в одинарных кавычках

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Rudra\Interfaces\ContainerInterface</em> <strong>$container</strong>)</strong> : <em>void</em><br /><em>SetContainerTrait constructor.</em> |
| public | <strong>container()</strong> : <em>\Rudra\ContainerInterface</em> |
| public | <strong>getAnnotations(</strong><em>\string</em> <strong>$className</strong>, <em>\string</em> <strong>$methodName=null</strong>)</strong> : <em>array</em> |
| protected | <strong>parseAnnotations(</strong><em>\string</em> <strong>$docBlock</strong>)</strong> : <em>array</em> |

*This class implements [\Rudra\Interfaces\AnnotationInterface](#interface-rudrainterfacesannotationinterface)*

<hr /><a id="interface-rudrainterfacesannotationinterface"></a>
### Interface: \Rudra\Interfaces\AnnotationInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getAnnotations(</strong><em>\string</em> <strong>$className</strong>, <em>\string</em> <strong>$methodName=null</strong>)</strong> : <em>array</em> |

