<?php

/**
 * @Routing(url = '')
 * @Defaults(name='user1'| lastname = 'sample'| age='0'| address = {country : 'Russia', state : 'Tambov'}| phone = '000-00000000')
 * @assertResult(false)
 * @Validate(name = 'min:150'| phone = 'max:9')
 */
class Test
{

    /**
     * @Routing(url = '')
     * @Defaults(name='user1'| lastname = 'sample'| age='0'| address = {country : 'Russia', state : 'Tambov'}| phone = '000-00000000')
     * @assertResult(false)
     * @Validate(name = 'min:150'| phone = 'max:9')
     */
    public function index()
    {

    }

}