<?php namespace parser\base;

use parser\base\ITemplate;

class Template implements ITemplate{
    
    /**
     * @var string 
     */
    protected $name;
    
    /**
     * @var string 
     */
    protected $url;
    
    /**
     * @var array of string items 
     */
    protected $query;
    
    protected $conf;
    /**
     * @var array - strings names of methods like filter.
     */
    protected $filters;

    public function __construct( Array $conf) {
        if ( !isset($conf) || !is_array($conf) ){
            throw new Exception('not found an array in argument of constructor');
        }
        
        (isset($conf['name']))? $this->name = $conf['name']: null;
        (isset($conf['url']))? $this->url = $conf['url']: null;
        (isset($conf))? $this->conf = $conf : null;
        
        $this->setFilter();
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function getQuery()
    {
        return $this->query;
    }
    
    public function applyFilters()
    {
        foreach ($this->filters as $filter) {
            $this->$filter();
        }
    }
    
    public function applyFilter($filterName, $data=NULL)
    {
        $method = 'filter' . $filterName;
        return $this->$method($data);
    }
    
    protected function setFilter()
    {
        $class = new \ReflectionClass($this);
        $methods = $class->getMethods( \ReflectionMethod::IS_PUBLIC );
        foreach ($methods as $methodsOBJ){
            $publicMethods[] =  $methodsOBJ->name;
        }
        $filters = preg_grep('/filter\w+/', $publicMethods);
        $this->filters = $filters;      
    }
}
