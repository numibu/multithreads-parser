<?php namespace parser\base\templates;

use parser\base\Template;
use parser\models\CarModel;

class CarModelTemplate extends Template{
    
    /**
     * @var string - xpath to parse;
     */
    protected $query = ".//nav[contains(@class, 'c-makes')]//a[contains(@class, 'c-link')]";
    protected $name = 'model';
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
            $carModel = new CarModel();
            $carModel->id  = $id++;
            $carModel->parentID = $this->conf['parentID'];
            $carModel->link = $obj->getAttribute('href');
            $carModel->title = $obj->textContent;
            $storage->attach($carModel);
        }
        return $storage;
    }
    
    
    
}
