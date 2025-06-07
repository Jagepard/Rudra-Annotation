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
|public|<em><strong>getAnnotations</strong>( string $className  ?string $methodName )</em><br>|
|public|<em><strong>getAttributes</strong>( string $className  ?string $methodName ): array</em><br>|
|private|<em><strong>extractShortName</strong>( string $fullyQualifiedName ): string</em><br>|
|private|<em><strong>getReflection</strong>( string $className  ?string $methodName )</em><br>|
|private|<em><strong>parseAnnotations</strong>( string $docBlock ): array</em><br>|


<a id="rudra_annotation_annotationinterface"></a>

### Class: Rudra\Annotation\AnnotationInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>getAnnotations</strong>( string $className  ?string $methodName )</em><br>|
|abstract public|<em><strong>getAttributes</strong>( string $className  ?string $methodName )</em><br>|


<a id="rudra_annotation_annotationmatcher"></a>

### Class: Rudra\Annotation\AnnotationMatcher
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>getParams</strong>( array $exploded  string $assignment ): array</em><br>Parses parameters by key (assignment) value and returns an array of parameters|
|private|<em><strong>handleData</strong>( string $data  array $exploded ): ?array</em><br>Parses data into key => value pairs|
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
