[![Build Status](https://travis-ci.org/Jagepard/Rudra-Annotation.svg?branch=master)](https://travis-ci.org/Jagepard/Rudra-Annotation)
[![codecov](https://codecov.io/gh/Jagepard/Rudra-Annotation/branch/master/graph/badge.svg)](https://codecov.io/gh/Jagepard/Rudra-Annotation)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/?branch=master)
[![Code Climate](https://lima.codeclimate.com/github/Jagepard/Rudra-Annotation/badges/gpa.svg)](https://lima.codeclimate.com/github/Jagepard/Rudra-Annotation)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8465b2da2a4d4f2f9276e18e88a64b5d)](https://www.codacy.com/app/Jagepard/Rudra-Annotation?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Jagepard/Rudra-Annotation&amp;utm_campaign=Badge_Grade)
-----
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Jagepard/Rudra-Annotation/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Latest Stable Version](https://poser.pugx.org/rudra/annotations/v/stable)](https://packagist.org/packages/rudra/annotations)
[![Total Downloads](https://poser.pugx.org/rudra/annotations/downloads)](https://packagist.org/packages/rudra/annotations)
[![License: GPL-3.0-or-later](https://img.shields.io/badge/license-GPL--3.0--or--later-498e7f.svg)](https://www.gnu.org/licenses/gpl-3.0)

## Class & Methods Annotations Reader

#### Установка / Install

```composer require rudra/annotation```

##### Sample class User.php

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
    function indexAction()
    {
        // Your code
    }        
}
```
##### Результат в обоих случаях:

```php
array (4) [
    'Routing' => array (1) [
        array (1) [
            'url' => string (0) ""
        ]
    ]
    'Defaults' => array (1) [
        array (5) [
            'name' => string (5) "user1"
            'lastname' => string (6) "sample"
            'age' => string (1) "0"
            'address' => array (2) [
                'country' => string (6) "Russia"
                'state' => string (6) "Tambov"
            ]
            'phone' => string (12) "000-00000000"
        ]
    ]
    'assertResult' => array (1) [
        string (5) "false"
    ]
    'Validate' => array (1) [
        array (2) [
            'name' => string (7) "min:150"
            'phone' => string (5) "max:9"
        ]
    ]
]
```   
