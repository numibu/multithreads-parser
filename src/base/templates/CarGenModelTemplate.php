<?php namespace parser\base\templates;

use parser\base\Template;
use parser\models\CarGenModel;

class CarGenModelTemplate extends Template{
    
    /**
     * @var string - xpath to parse;
     */
    protected $query = ".//div[contains(@class, 'c-gen-card__caption')]//a[contains(@class, 'c-link')]";
    protected $name = 'modelGen';
    protected $url = '';//'https://www.drive2.ru/cars';
    
    public function __construct(array $conf) {
        parent::__construct($conf);
    }
    
    public function afterParse($html) {
        return $html;
    }
    
    public function filterCreateModels($data){
        $storage = new \SplObjectStorage();
        $id = 1;
        foreach ($data as $obj) {
            $CarGenModel = new CarGenModel();
            $CarGenModel->id = $id++;
            $CarGenModel->parentID = $this->conf['parentID'];
            $CarGenModel->link = $obj->getAttribute('href');
            $CarGenModel->title = $obj->textContent;
            $storage->attach($CarGenModel);
        }
        return $storage;
    }
    
    
    
}
