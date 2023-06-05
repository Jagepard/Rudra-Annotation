## Table of contents
- [Rudra\Annotation\Annotation](#rudra_annotation_annotation)
- [Rudra\Annotation\AnnotationInterface](#rudra_annotation_annotationinterface)
- [Rudra\Annotation\AnnotationMatcher](#rudra_annotation_annotationmatcher)
<hr>

<a id="rudra_annotation_annotation"></a>

### Class: Rudra\Annotation\Annotation
##### implements [Rudra\Annotation\AnnotationInterface](#rudra_annotation_annotationinterface)
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>getAnnotations</strong>( string $className  ?string $methodName )</em><br>Get data from annotations<br>Получить данные из аннотаций|
|public|<em><strong>getAttributes</strong>( string $className  ?string $methodName )</em><br>Get data from attributes (for php 8 and up)<br>Получить данные из атрибутов (для php 8 и выше)|
|private|<em><strong>getReflection</strong>( string $className  ?string $methodName )</em><br>Provides information about a method or class<br>Сообщает информацию о методе или классе|
|private|<em><strong>parseAnnotations</strong>( string $docBlock ): array</em><br>Parses annotation data<br>Разбирает данные аннотаций|


<a id="rudra_annotation_annotationinterface"></a>

### Class: Rudra\Annotation\AnnotationInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>getAnnotations</strong>( string $className  ?string $methodName )</em><br>Get data from annotations<br>Получить данные из аннотаций|
|abstract public|<em><strong>getAttributes</strong>( string $className  ?string $methodName )</em><br>Get data from attributes (for php 8 and up)<br>Получить данные из атрибутов (для php 8 и выше)|


<a id="rudra_annotation_annotationmatcher"></a>

### Class: Rudra\Annotation\AnnotationMatcher
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>getParams</strong>( array $exploded  string $assignment ): array</em><br>Parses parameters by key (assignment) value<br>and returns an array of parameters<br>Анализирует параметры по значению ключа (присваивания)<br>и возвращает массив параметров|
|private|<em><strong>handleData</strong>( string $data  array $exploded ): ?array</em><br>Parses data into key => value pairs<br>Разбирает данные в пары ключ => значение|
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
