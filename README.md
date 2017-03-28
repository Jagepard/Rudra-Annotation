[![Build Status](https://travis-ci.org/Jagepard/Rudra-Annotations.svg?branch=master)](https://travis-ci.org/Jagepard/Rudra-Annotations)
[![Coverage Status](https://coveralls.io/repos/github/Jagepard/Rudra-Annotations/badge.svg?branch=master)](https://coveralls.io/github/Jagepard/Rudra-Annotations?branch=master)
[![Code Climate](https://lima.codeclimate.com/github/Jagepard/Rudra-Annotations/badges/gpa.svg)](https://lima.codeclimate.com/github/Jagepard/Rudra-Annotations)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/af16eedc760948a8b0458e7cce92aed3)](https://www.codacy.com/app/Jagepard/Rudra-Annotations?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Jagepard/Rudra-Annotations&amp;utm_campaign=Badge_Grade)


## Class & Methods Annotations Reader

##### Sample class User.php

```php
class PageController
{

    /**
     * @Routing(url = '')
     * @Defaults(name='user1'| lastname = 'sample'| age='0'| address = {country : 'Russia', state : 'Tambov'}| phone = '000-00000000')
     * @assertResult(false)
     * @Validate(name = 'min:150'| phone = 'max:9')
     */
    function indexAction()
    {
        // Your code
    }        
}
```
##### Result:

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
