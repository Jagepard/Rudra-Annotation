[![PHPunit](https://github.com/Jagepard/Rudra-Annotation/actions/workflows/php.yml/badge.svg)](https://github.com/Jagepard/Rudra-Annotation/actions/workflows/php.yml)
[![Maintainability](https://qlty.sh/badges/597f5043-9af1-4970-9eed-86f35c750a5d/maintainability.svg)](https://qlty.sh/gh/Jagepard/projects/Rudra-Annotation)
[![CodeFactor](https://www.codefactor.io/repository/github/jagepard/rudra-annotation/badge)](https://www.codefactor.io/repository/github/jagepard/rudra-annotation)
[![Coverage Status](https://coveralls.io/repos/github/Jagepard/Rudra-Annotation/badge.svg?branch=master)](https://coveralls.io/github/Jagepard/Rudra-Annotation?branch=master)
-----

## Annotations and attributes reader | [API](https://github.com/Jagepard/Rudra-Annotation/blob/master/docs.md "Documentation API")
#### Installation
```composer require rudra/annotation```

> Modern metadata reader for PHP 8+ attributes with legacy annotation support. 

#### Using
```php
$annotation = new Annotation();
```
#### 🎯 Recommended: PHP 8+ Attributes
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
#### 📜 Legacy: Annotations
> **Note:** Annotations are supported for backward compatibility with legacy projects. 
> For new projects, use PHP 8+ attributes.
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
#### 📊 Result in both cases:
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
### ⚠️ Known Limitations
>When using nested arrays (in curly braces `{}`), ensure that the values do not contain the array assignment symbol (`:`). The parser uses simple splitting by this symbol and does not escape it inside quotes. String values (with `=`) are handled correctly even if they contain multiple `=` symbols.

**✅ Works correctly:**
```php
/**
 * @Config(settings={theme:'dark'; lang:'ru'})
 * @Routing(url='http://site.com?a=1&b=2')
 */
```

**❌ Breaks array parsing:**
```php
/**
 * @Config(settings={url:'http://site.com:8080'})
 */
```
> **Note:** These limitations apply only to legacy annotations. PHP 8+ attributes do not have these restrictions.
**✅ All cases work correctly:**
```php
#[Config(settings: ['theme' => 'dark', 'lang' => 'ru'])]
#[Routing(url: 'http://site.com?a=1&b=2')]
#[Config(settings: ['url' => 'http://site.com:8080'])] // ✅ Works!
```
## License

This project is licensed under the **Mozilla Public License 2.0 (MPL-2.0)** — a free, open-source license that:

- Requires preservation of copyright and license notices,
- Allows commercial and non-commercial use,
- Requires that any modifications to the original files remain open under MPL-2.0,
- Permits combining with proprietary code in larger works.

📄 Full license text: [LICENSE](./LICENSE)  
🌐 Official MPL-2.0 page: https://mozilla.org/MPL/2.0/