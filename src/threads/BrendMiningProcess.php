<?php namespace parser\threads;

class BrendMiningProcess extends \Thread{
    
    public $storage; 
    
    public function __construct($storage) 
    {
        $this->storage = $storage;
        $this->done = false;
    }
    public function run()
    {
        $brends = \parser\Parser::miningBrend();
        $this->setBrendsToProvider($brends);
    }
    
    public function setBrendsToProvider($brends)
    {
        $provider = $this->worker->getProvider();
        $context = $this;
        
        $provider->synchronized(function($provider) use ($brends , $context){
            $provider->addBrends($brends, $context);
        }, $provider);
    }
 
}