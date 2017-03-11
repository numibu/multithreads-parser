<?php namespace parser\base;

use \parser\base\Template;
use \parser\source\CurlWrapper;

class DomParser {
    
    public $template;
    public $result;
    private $curl;
    private $dom;
           
    public function __construct(Template $template) 
    {
        $this->dom = new \DOMDocument();
        $this->template = $template;
        $this->curl = CurlWrapper::getInstance();
        $this->parse();
    }
    
    private function parse()
    {
        $html = $this->curl->connect( $this->template->getUrl() );
        @$this->dom->loadHTML($html);
        $xpathOBJ = new \DOMXPath($this->dom);
        $result = $xpathOBJ->query($this->template->getQuery());
        $this->result = $this->template->applyFilter('CreateModels', $result);
        unset($this->curl);
    }
    
    
}

