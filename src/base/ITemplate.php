<?php namespace parser\base;

interface ITemplate {
    
    /**
     * @return string name (use for save db)
     */
    public function getName();
    
    /*
     * $return string 
     */
    public function getUrl();
    
    /**
     * @return string xPath query
     */
    public function getQuery();
    
}
