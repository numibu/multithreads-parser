<?php namespace parser\threads;

use parser\threads\CommonProvider;

class Worker extends \Worker {
    
    public function __construct(CommonProvider $provider) 
    {
        $this->provider = $provider;
    }
    
    public function run()
    {
        spl_autoload_register( 'parserAutoload' );
        //\parser\view\View::render("Worker is run \n");
    }
    
    public function getProvider()
    {
        return $this->provider;
    }
    
}
