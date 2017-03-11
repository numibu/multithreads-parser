<?php

require './autoload.php';

use parser\threads\BrendMiningProcess;
use parser\threads\CarModelMiningProcess;
use parser\threads\CarGenModelMiningProcess;
use parser\threads\CommonProvider;
use parser\threads\Worker;
use parser\view\View;

class MainWrapper {
    
    public $worker;
    public $commonProvider;
    public $brendMiningThread;
    public $arrayCarModelMiningThreads = [];
    public $arrayCarGenModelMiningThreads = [];
    
    public function __construct() 
    {
        View::start();
        $this->commonProvider = new CommonProvider();
        $this->worker = new Worker($this->commonProvider);
    }
    
    public function processing()
    {
        $this->processBrend();
        
        do{ 
            sleep(3); 
            if ( $this->commonProvider->brendComplete ){
                $this->processCarModel();
            }
            if ( $this->commonProvider->carModelIsCompleted ){
                $this->processCarGenModel();
            }
        
        }while( !$this->commonProvider->carGenModelIsCompleted );  
        
        View::render("Completed, exit... \n");
    }

    public function processBrend()
    {
        $this->brendMiningThread = new BrendMiningProcess([]);
        $this->worker->stack($this->brendMiningThread);
        $this->worker->start();
    }
    
    /**
     * @param intager $k - number of threads
     */
    public function processCarModel($k=2)
    {
        for ($index = 0; $index != (integer)$k; $index++) {
            $this->arrayCarModelMiningThreads[] = new CarModelMiningProcess([]);} 
            
        $carModelPool = new Pool($k, Worker::class, [$this->commonProvider]);    
            
        foreach ($this->arrayCarModelMiningThreads as $thread) {
            
            $carModelPool->submit($thread);
        }
    }
    
    /**
     * @param intager $k - number of threads
     */
    public function processCarGenModel($k=2)
    {
        for ($index = 0; $index != (integer)$k; $index++) {
            $this->arrayCarGenModelMiningThreads[] = new CarGenModelMiningProcess([]);} 
            
        $carGenModelPool = new Pool($k, Worker::class, [$this->commonProvider]);    
            
        foreach ($this->arrayCarGenModelMiningThreads as $thread) {
            
            $carGenModelPool->submit($thread);
        }
    }

}

$main = new MainWrapper();
$main->processing();
$main->worker->shutdown();