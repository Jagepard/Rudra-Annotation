## Table of contents
- [Rudra\Annotation\Annotation](#rudra_annotation_annotation)
- [Rudra\Annotation\AnnotationInterface](#rudra_annotation_annotationinterface)
- [Rudra\Annotation\ParamsExtractor](#rudra_annotation_paramsextractor)


---



<a id="rudra_annotation_annotation"></a>

### Class: Rudra\Annotation\Annotation
| Visibility | Function |
|:-----------|:---------|
| public | `getAnnotations(string $className, ?string $methodName): array`<br> |
| public | `getAttributes(string $className, ?string $methodName): array`<br> |
| private | `extractShortClassName(string $fullyQualifiedName): string`<br> |
| private | `getReflection(string $className, ?string $methodName): ReflectionClass\|ReflectionMethod`<br> |
| private | `parseAnnotations(string $docBlock): array`<br> |


<a id="rudra_annotation_annotationinterface"></a>

### Class: Rudra\Annotation\AnnotationInterface
| Visibility | Function |
|:-----------|:---------|
| abstract public | `getAnnotations(string $className, ?string $methodName): array`<br> |
| abstract public | `getAttributes(string $className, ?string $methodName): array`<br> |


<a id="rudra_annotation_paramsextractor"></a>

### Class: Rudra\Annotation\ParamsExtractor
| Visibility | Function |
|:-----------|:---------|
| public | `getParams(array $exploded, string $assignment): array`<br>--------------------------------------------------------------<br>Parses an array of parameter strings into an associative array<br>--------------------------------------------------------------<br>Преобразует массив строк с параметрами в ассоциативный массив<br>--------------------------------------------------------------<br>------------------------------------------------------------------------------------<br>`from: "param1, param2 = 'param2', param3={param1;param2:'param2'}"`<br>`to: ["param1", "param2" => "param2", "param3" => ["param1", "param2" => "param2"]]`<br>------------------------------------------------------------------------------------ |
| private | `handleData(string $data, array $exploded): ?array`<br>--------------------------------------------<br>Parses data into `key => value` pairs<br>--------------------------------------------<br>Преобразует данные в пары `ключ => значение`<br>--------------------------------------------<br>⚠️ IMPORTANT / ВАЖНО:<br>--------------------------------------------<br>Values inside arrays (curly braces) must not<br>contain the array assignment mark (`:`)<br>--------------------------------------------<br>Значения внутри массивов (фигурные скобки)<br>не должны содержать знак присваивания (`:`)<br>-------------------------------------------- |


---

###### created with [Rudra-Documentation-Collector](https://github.com/Jagepard/Rudra-Documentation-Collector)
