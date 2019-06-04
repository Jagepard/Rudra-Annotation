[![Build Status](https://travis-ci.org/Jagepard/Rudra-Annotation.svg?branch=master)](https://travis-ci.org/Jagepard/Rudra-Annotation)
[![codecov](https://codecov.io/gh/Jagepard/Rudra-Annotation/branch/master/graph/badge.svg)](https://codecov.io/gh/Jagepard/Rudra-Annotation)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/?branch=master)
[![Code Climate](https://lima.codeclimate.com/github/Jagepard/Rudra-Annotation/badges/gpa.svg)](https://lima.codeclimate.com/github/Jagepard/Rudra-Annotation)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8465b2da2a4d4f2f9276e18e88a64b5d)](https://www.codacy.com/app/Jagepard/Rudra-Annotation?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Jagepard/Rudra-Annotation&amp;utm_campaign=Badge_Grade)
-----
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Latest Stable Version](https://poser.pugx.org/rudra/annotation/v/stable)](https://packagist.org/packages/rudra/annotation)
[![Total Downloads](https://poser.pugx.org/rudra/annotation/downloads)](https://packagist.org/packages/rudra/annotation)
![GitHub](https://img.shields.io/github/license/jagepard/Rudra-Annotation.svg)

## Class & Methods Annotations Reader | [API](https://github.com/Jagepard/Rudra-Annotation/blob/master/docs.md "Documentation API")
#### Установка / Install
```composer require rudra/annotation```
#### Использование / Usage
```php
use Rudra\Container;
use Rudra\Annotation;
use Rudra\Interfaces\ContainerInterface;
```
##### Вызов из контейнера / use container
```php
$services = [
    'contracts' => [],    
    'services' => [
        // Another services
        
        'annotation' => ['Rudra\Annotation'],
        
        // Another services
    ]
];
```
```php
$rudra->setServices($services); 
```
```php
$rudra->get('annotation')->getAnnotations(PageController::class);
$rudra->get('annotation')->getAnnotations(PageController::class, 'indexAction');
```
##### Вызов при помощи метода контейнера new / instantiate use container method "new"
```php
$annotation = $rudra->new(Annotation::class);
```
```php
$annotation->getAnnotations(PageController::class);
$annotation->getAnnotations(PageController::class, 'indexAction');
```
##### Вызов не используя контейнер / raw use
```php
$annotation = new Annotation();
```
```php
$annotation->getAnnotations(PageController::class);
$annotation->getAnnotations(PageController::class, 'indexAction');
```
##### Пример класс / Sample class PageController.php

```php
/**
 * @Routing(url = '')
 * @Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
 * @assertResult(false)
 * @Validate(name = 'min:150', phone = 'max:9')
 */
class PageController
{
    /**
     * @Routing(url = '')
     * @Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
     * @assertResult(false)
     * @Validate(name = 'min:150', phone = 'max:9')
     */
    public function indexAction()
    {
        // Your code
    }        
}
```
##### Результат в обоих случаях:

```php
[
    'Routing' => [
        [
            'url' => ""
        ]
    ]
    'Defaults' => [
        [
            'name'     => "user1"
            'lastname' => "sample"
            'age'      => "0"
            'address'  => [
                'country' => "Russia"
                'state'   => "Tambov"
            ]
            'phone'    => "000-00000000"
        ]
    ]
    'assertResult' => [
        "false"
    ]
    'Validate' => [
        [
            'name'  => "min:150"
            'phone' => "max:9"
        ]
    ]
]
```
![Rudra-Annotation](https://github.com/Jagepard/Rudra-Annotation/blob/master/UML.png)
