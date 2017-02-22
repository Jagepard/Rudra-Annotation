README
=========================

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/af16eedc760948a8b0458e7cce92aed3)](https://www.codacy.com/app/Jagepard/Rudra-Annotations?utm_source=github.com&utm_medium=referral&utm_content=Jagepard/Rudra-Annotations&utm_campaign=badger)

Class & Methods Annotations Reader
===

Sample class User.php

    class PageController
    {
    
    /**
     * @Routing(url = '')
     * @Defaults(name='user1'| lastname = 'sample'| age='0'| address = {country : 'Russia', state : 'Tambov'}| phone = '000-00000000')
     * @assertResult(false)
     * @Validate(name = 'min:150'| phone = 'max:9')
     */
        function load()
        {
            // Your code
        }
        
    }

Result:

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
    
