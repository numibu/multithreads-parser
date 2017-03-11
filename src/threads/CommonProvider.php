<?php namespace parser\threads;

class CommonProvider extends \Threaded{
    
    public $brendComplete = false;
    public $carModelIsCompleted = false;
    public $carGenModelIsCompleted = false;

    public $lastBrendIndex = 0; 
    public $endBrendIndex = 0;
    
    public $lastCarModelIndex = 0;
    public $endCarModeIndex = 0;
    
    public $brendStorage;
    public $modelStorage;
    public $genStorage;
    
    private $genLimit;
    private $modelLimit;


    public function __construct( $limit = ['modelLimit'=>100, 'genLimit'=>100] )
    {
        $this->modelLimit = $limit['modelLimit'];
        $this->genLimit = $limit['genLimit'];

        $this['brendStorage'] = [];
        $this['modelStorage'] = [];
        $this['genStorage'] = [];
    }
    
    public function run(){ }
    
    public function addBrends($brends)
    {
        $this['brendStorage'][] = $brends;
        $this->endBrendIndex = count($brends);
        $this->brendComplete = true;
    }
    
    public function getNextBrend($context) 
    {
        if ( $this->endBrendIndex < ($this->lastBrendIndex +1))
                { $this->carModelIsCompleted = true;}
                
        if($this->lastBrendIndex <= $this->endBrendIndex ){
            if ($this->endBrendIndex !== 0) {
                $this->lastBrendIndex++;
                return $this['brendStorage'][0][$this->lastBrendIndex];
            }
        }
        
        if ($this->endBrendIndex === 0 ) {
            $context->synchronized(function($thread){
                $thread->endFlag = true;
                $thread->notify();
            },$context);
        }
        
        return NULL;
    }
    
    public function getNextCarModel($context) 
    {
        if ( $this->endCarModeIndex < ($this->lastCarModelIndex +1) )
                { $this->carGenModelIsCompleted = true;}
                
        if ( $this->lastCarModelIndex <= $this->endCarModeIndex ) {
            
            if ( $this->endCarModeIndex !== 0 ) {
                $this->lastCarModelIndex++;
                //var_dump($this['modelStorage'][0]);
                return $this['modelStorage'][$this->lastCarModelIndex];
            }
        }
        
        if ( $this->endCarModeIndex === 0 ) {
            $context->synchronized(function($thread){
                $thread->endFlag = true;
                $thread->notify();
            },$context);
        }
        
        return NULL;
    }
    
    public function addCarModel($storage, $context)
    { 
        $storage->rewind();
        while ($storage->valid()) {
            $this['modelStorage'][] = $storage->current();
            $storage->next();
        }
        
        $count = $this['modelStorage']->count();
        if ( $count > $this->modelLimit || $this->carModelIsCompleted ) {
            $this->carModelIsCompleted = true;
            $this->endCarModeIndex = $count;
            echo "\n CommonProvider->modelStorage = " . $count . "\n";
            $context->synchronized(function($thread){
                $thread->endFlag = true;
                $thread->notify();
            },$context);
        }
    }
    
    public function addCarGenModel($storage, $context)
    { 
        $storage->rewind();
        while ($storage->valid()) {
            $this['genStorage'][] = $storage->current();
            $storage->next();
        }
        
        $count = $this['genStorage']->count();
        if ( $count > $this->genLimit || $this->carGenModelIsCompleted ) {
            $this->carGenModelIsCompleted = true;
            $this->endCarModeIndex = $count;
            echo "\n CommonProvider->genStorage = " . $count . "\n";
            $context->synchronized(function($thread){
                $thread->endFlag = true;
                $thread->notify();
            },$context);
        }
    }
}

