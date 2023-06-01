[![PHPunit](https://github.com/Jagepard/Rudra-Annotation/actions/workflows/php.yml/badge.svg)](https://github.com/Jagepard/Rudra-Annotation/actions/workflows/php.yml)
[![codecov](https://codecov.io/gh/Jagepard/Rudra-Annotation/branch/master/graph/badge.svg)](https://codecov.io/gh/Jagepard/Rudra-Annotation)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/?branch=master)
[![Code Climate](https://lima.codeclimate.com/github/Jagepard/Rudra-Annotation/badges/gpa.svg)](https://lima.codeclimate.com/github/Jagepard/Rudra-Annotation)
-----
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Latest Stable Version](https://poser.pugx.org/rudra/annotation/v/stable)](https://packagist.org/packages/rudra/annotation)
[![Total Downloads](https://poser.pugx.org/rudra/annotation/downloads)](https://packagist.org/packages/rudra/annotation)
![GitHub](https://img.shields.io/github/license/jagepard/Rudra-Annotation.svg)

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
 */
class PageController
{
    /**
     * @Routing(url = '')
     * @Defaults(name = 'user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
     * @assertResult(false)
     * @Validate(name = 'min:150', phone = 'max:9')
     * @Middleware('Middleware', params = {int1 : '123'})
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
class PageController
{
    #[Routing(url:'')]
    #[Defaults(name:'user1', lastname:'sample', age:'0', address:['country' => 'Russia', 'state' => 'Tambov'], phone:'000-00000000')]
    #[assertResult(false)]
    #[Validate(name:'min:150', phone:'max:9')]
    #[Middleware('Middleware', params:['int1' => '123'])]
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
            0 => "'Middleware'",
            'params' => [
                'int1' => '123',
            ],
        ],
    ],
];
```
