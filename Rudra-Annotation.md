## Table of contents

- [\Rudra\AnnotationMatcher](#class-rudraannotationmatcher)
- [\Rudra\Annotation](#class-rudraannotation)
- [\Rudra\Interfaces\AnnotationInterface (interface)](#interface-rudrainterfacesannotationinterface)

<hr /><a id="class-rudraannotationmatcher"></a>
### Class: \Rudra\AnnotationMatcher

> Class AnnotationMatcher

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Rudra\Interfaces\ContainerInterface</em> <strong>$container</strong>)</strong> : <em>void</em><br /><em>SetContainerTrait constructor.</em> |
| public | <strong>container()</strong> : <em>\Rudra\ContainerInterface</em> |
| public | <strong>handleDelimiter(</strong><em>mixed/\string</em> <strong>$data</strong>, <em>\string</em> <strong>$delimiter=`','`</strong>, <em>\string</em> <strong>$assignment=`'='`</strong>)</strong> : <em>mixed</em> |
| protected | <strong>getArrayParams(</strong><em>\string</em> <strong>$data</strong>, <em>\string</em> <strong>$delimiter</strong>, <em>\string</em> <strong>$assignment</strong>)</strong> : <em>array</em> |
| protected | <strong>handleAssignment(</strong><em>\string</em> <strong>$data</strong>, <em>\string</em> <strong>$assignment=`'='`</strong>)</strong> : <em>mixed</em> |
| protected | <strong>handleData(</strong><em>\string</em> <strong>$data</strong>, <em>array</em> <strong>$exploded</strong>)</strong> : <em>array</em> |

<hr /><a id="class-rudraannotation"></a>
### Class: \Rudra\Annotation

> Class Annotations Класс разбора данных из аннотаций, представленных в следующем виде: «коммерческое at»Routing(url = '') «коммерческое at»Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000') «коммерческое at»assertResult(false) «коммерческое at»Validate(name = 'min:150', phone = 'max:9') Разделителем свойств является - ',' Разделителем в массивах является - ';' ':' - разделяет ключ, значение в ассоциативном массиве Значение параметров указывается в одинарных кавычках

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Rudra\Interfaces\ContainerInterface</em> <strong>$container</strong>)</strong> : <em>void</em><br /><em>SetContainerTrait constructor.</em> |
| public | <strong>container()</strong> : <em>\Rudra\ContainerInterface</em> |
| public | <strong>getClassAnnotations(</strong><em>\string</em> <strong>$className</strong>)</strong> : <em>array Получает массив из аннотаций DOCблока класса</em> |
| public | <strong>getMethodAnnotations(</strong><em>\string</em> <strong>$className</strong>, <em>\string</em> <strong>$methodName</strong>)</strong> : <em>array Получает массив из аннотаций DOCблока метода</em> |
| protected | <strong>parseAnnotations(</strong><em>\string</em> <strong>$docBlock</strong>)</strong> : <em>array Преобразовывает материалы представленные в аннотации в массив</em> |

*This class implements [\Rudra\Interfaces\AnnotationInterface](#interface-rudrainterfacesannotationinterface)*

<hr /><a id="interface-rudrainterfacesannotationinterface"></a>
### Interface: \Rudra\Interfaces\AnnotationInterface

> Interface AnnotationInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getClassAnnotations(</strong><em>\string</em> <strong>$className</strong>)</strong> : <em>array Получает массив из аннотаций DOCблока класса</em> |
| public | <strong>getMethodAnnotations(</strong><em>\string</em> <strong>$className</strong>, <em>\string</em> <strong>$methodName</strong>)</strong> : <em>array Получает массив из аннотаций DOCблока метода</em> |

