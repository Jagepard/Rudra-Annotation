## Table of contents

- [\Rudra\AnnotationMatcher](#class-rudraannotationmatcher)
- [\Rudra\Annotation](#class-rudraannotation)
- [\Rudra\Interfaces\AnnotationInterface (interface)](#interface-rudrainterfacesannotationinterface)

<hr /><a id="class-rudraannotationmatcher"></a>
### Class: \Rudra\AnnotationMatcher

> Класс преобразует данные анотаций в ассоциативный массив Class AnnotationMatcher

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

> Class Annotations Класс разбора данных из аннотаций, представленных в следующем виде:

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Rudra\Interfaces\ContainerInterface</em> <strong>$container</strong>)</strong> : <em>void</em><br /><em>SetContainerTrait constructor.</em> |
| public | <strong>container()</strong> : <em>\Rudra\ContainerInterface</em> |
| public | <strong>getClassAnnotations(</strong><em>\string</em> <strong>$className</strong>)</strong> : <em>array Получает массив из аннотаций DOCблока класса</em> |
| public | <strong>getMethodAnnotations(</strong><em>\string</em> <strong>$className</strong>, <em>\string</em> <strong>$methodName</strong>)</strong> : <em>array Получает массив из аннотаций DOCблока метода</em> |
| protected | <strong>parseAnnotations(</strong><em>\string</em> <strong>$docBlock</strong>)</strong> : <em>array Преобразовывает материалы из аннотаций в массив</em> |

*This class implements [\Rudra\Interfaces\AnnotationInterface](#interface-rudrainterfacesannotationinterface)*

<hr /><a id="interface-rudrainterfacesannotationinterface"></a>
### Interface: \Rudra\Interfaces\AnnotationInterface

> Interface AnnotationInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getClassAnnotations(</strong><em>\string</em> <strong>$className</strong>)</strong> : <em>array Получает массив из аннотаций DOCблока класса</em> |
| public | <strong>getMethodAnnotations(</strong><em>\string</em> <strong>$className</strong>, <em>\string</em> <strong>$methodName</strong>)</strong> : <em>array Получает массив из аннотаций DOCблока метода</em> |

