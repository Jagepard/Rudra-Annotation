[![PHPunit](https://github.com/Jagepard/Rudra-Annotation/actions/workflows/php.yml/badge.svg)](https://github.com/Jagepard/Rudra-Annotation/actions/workflows/php.yml)
[![Maintainability](https://qlty.sh/badges/597f5043-9af1-4970-9eed-86f35c750a5d/maintainability.svg)](https://qlty.sh/gh/Jagepard/projects/Rudra-Annotation)
[![CodeFactor](https://www.codefactor.io/repository/github/jagepard/rudra-annotation/badge)](https://www.codefactor.io/repository/github/jagepard/rudra-annotation)
[![Coverage Status](https://coveralls.io/repos/github/Jagepard/Rudra-Annotation/badge.svg?branch=master)](https://coveralls.io/github/Jagepard/Rudra-Annotation?branch=master)
-----

## Annotations and attributes reader / Читатель аннотаций и атрибутов | [API](https://github.com/Jagepard/Rudra-Annotation/blob/master/docs.md "Documentation API")
#### Installation / Установка
```composer require rudra/annotation```
#### Using / Использование
```php
$annotation = new Annotation();
```
##### An example of reading annotations / Пример чтения аннотаций
```php
$annotation->getAnnotations(PageController::class);
$annotation->getAnnotations(PageController::class, "indexAction");
```
```php
/**
 * @Routing(url = '')
 * @Defaults(name = 'user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
 * @assertResult(false)
 * @Validate(name = 'min:150', phone = 'max:9')
 * @Middleware('Middleware', params = {int1 : '123'})
 * @Annotation(param1, param2 = 'param2', param3={param1;param2:'param2'})
 */
class PageController
{
    /**
     * @Routing(url = '')
     * @Defaults(name = 'user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
     * @assertResult(false)
     * @Validate(name = 'min:150', phone = 'max:9')
     * @Middleware('Middleware', params = {int1 : '123'})
     * @Annotation(param1, param2 = 'param2', param3={param1;param2:'param2'})
     */
    public function indexAction()
    {
        // Your code
    }        
}
```
##### An example of reading attributes / Пример чтения атрибутов
```php
$annotation->getAttributes(PageController::class);
$annotation->getAttributes(PageController::class, "indexAction");
```
```php
#[Routing(url:'')]
#[Defaults(name:'user1', lastname:'sample', age:'0', address:['country' => 'Russia', 'state' => 'Tambov'], phone:'000-00000000')]
#[assertResult(false)]
#[Validate(name:'min:150', phone:'max:9')]
#[Middleware('Middleware', params:['int1' => '123'])]
#[Annotation("param1", param2:'param2', param3:['param1', 'param2' => 'param2'])]
class PageController
{
    #[Routing(url:'')]
    #[Defaults(name:'user1', lastname:'sample', age:'0', address:['country' => 'Russia', 'state' => 'Tambov'], phone:'000-00000000')]
    #[assertResult(false)]
    #[Validate(name:'min:150', phone:'max:9')]
    #[Middleware('Middleware', params:['int1' => '123'])]
    #[Annotation("param1", param2:'param2', param3:['param1', 'param2' => 'param2'])]
    public function indexAction()
    {
        // Your code
    }        
}
```
##### Result in both cases / Результат чтения в обоих случаях:
```php
[
    'Routing' => [['url' => ""]],
    'Defaults' => [
        [
            'name' => "user1",
            'lastname' => "sample",
            'age' => "0",
            'address' => [
                'country' => "Russia",
                'state' => "Tambov",
            ],
            'phone' => "000-00000000",
        ],
    ],
    'assertResult' => [["false"]],
    'Validate' => [
        [
            'name' => "min:150",
            'phone' => "max:9",
        ],
    ],
    'Middleware' => [
        [
            "'Middleware'",
            'params' => [
                'int1' => '123',
            ],
        ],
    ],
    "Annotation" => [
        [
            "param1",
            "param2" => "param2",
            "param3" => [
                "param1",
                "param2" => "param2",
            ],
        ],
    ],
];
```
