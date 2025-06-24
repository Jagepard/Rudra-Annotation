## Table of contents
- [Rudra\Annotation\Annotation](#rudra_annotation_annotation)
- [Rudra\Annotation\AnnotationInterface](#rudra_annotation_annotationinterface)
- [Rudra\Annotation\ParamsExtractor](#rudra_annotation_paramsextractor)
<hr>

<a id="rudra_annotation_annotation"></a>

### Class: Rudra\Annotation\Annotation
##### implements [Rudra\Annotation\AnnotationInterface](#rudra_annotation_annotationinterface)
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>getAnnotations</strong>( string $className  ?string $methodName ): array</em><br>|
|public|<em><strong>getAttributes</strong>( string $className  ?string $methodName ): array</em><br>|
|private|<em><strong>extractShortClassName</strong>( string $fullyQualifiedName ): string</em><br>|
|private|<em><strong>getReflection</strong>( string $className  ?string $methodName ): ReflectionClass|ReflectionMethod</em><br>|
|private|<em><strong>parseAnnotations</strong>( string $docBlock ): array</em><br>|


<a id="rudra_annotation_annotationinterface"></a>

### Class: Rudra\Annotation\AnnotationInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>getAnnotations</strong>( string $className  ?string $methodName ): array</em><br>|
|abstract public|<em><strong>getAttributes</strong>( string $className  ?string $methodName ): array</em><br>|


<a id="rudra_annotation_paramsextractor"></a>

### Class: Rudra\Annotation\ParamsExtractor
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>getParams</strong>( array $exploded  string $assignment ): array</em><br>Parses an array of parameter strings into an associative array.<br>Преобразует массив строк с параметрами в ассоциативный массив.<br>from: "param1, param2 = 'param2', param3={param1;param2:'param2'}"<br>to: ["param1", "param2" => "param2", "param3" => ["param1", "param2" => "param2"]]|
|private|<em><strong>handleData</strong>( string $data  array $exploded ): ?array</em><br>Parses data into key => value pairs<br>Преобразует данные в пары «ключ => значение»|
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
