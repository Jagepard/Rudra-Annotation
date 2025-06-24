<?php

namespace Rudra\Annotation\Tests\Stub;

/**
 * @Routing(url = '')
 * @Defaults(name = 'user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
 * @assertResult(false)
 * @Validate(name = 'min:150', phone = 'max:9')
 * @Middleware('Middleware', params = {int1 : '123'})
 * @Annotation(param1, param2 = 'param2', param3={param1;param2:'param2'})
 */
#[Routing(url:'')]
#[Defaults(name:'user1', lastname:'sample', age:'0', address:['country' => 'Russia', 'state' => 'Tambov'], phone:'000-00000000')]
#[assertResult('false')]
#[Validate(name:'min:150', phone:'max:9')]
#[Middleware("'Middleware'", params:['int1' => '123'])]
#[Annotation("param1", param2:'param2', param3:['param1', 'param2' => 'param2'])]
class PageController
{
    /**
     * @Routing(url = '')
     * @Defaults(name='user1', lastname = 'sample', age='0', address={country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
     * @assertResult(false)
     * @Validate(name = 'min:150', phone = 'max:9')
     * @Middleware('Middleware', params = {int1 : '123'})
     * @Annotation(param1, param2 = 'param2', param3={param1;param2:'param2'})
     */
    public function indexAction(): void
    {
    }

    #[Routing(url:'')]
    #[Defaults(name:'user1', lastname:'sample', age:'0', address:['country' => 'Russia', 'state' => 'Tambov'], phone:'000-00000000')]
    #[assertResult('false')]
    #[Validate(name:'min:150', phone:'max:9')]
    #[Middleware("'Middleware'", params:['int1' => '123'])]
    #[Annotation("param1", param2:'param2', param3:['param1', 'param2' => 'param2'])]
    public function secondAction()
    {
    }

    public function withoutDocblock(): void {}
}
