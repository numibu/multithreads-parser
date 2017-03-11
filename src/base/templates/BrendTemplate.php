<?php namespace parser\base\templates;

use parser\base\Template;
use parser\models\Brend;

class BrendTemplate extends Template{
    
    /**
     * @var string $query - xpath to parse;
     */
    protected $query = ".//nav[contains(@class, 'c-makes')]//a[contains(@class, 'c-link')]";
    protected $name = 'brend';
    protected $url = 'https://www.drive2.ru/cars';
    
    public function __construct(array $conf) {
        parent::__construct($conf);
    }
    
    public function afterParse($html) {
        return $html;
    }
    
    /**
     * 
     * @param array $data
     * @return array $storage
     */
    public function filterCreateModels($data)
    {
        $storage = [];//new \SplObjectStorage();
        $id = 1;
        foreach ($data as $obj) {
            $brend = new Brend();
            $brend->id = $id++;
            $brend->link = $obj->getAttribute('href');
            $brend->title = $obj->textContent;
            $storage[] = $brend;
        }
        /*foreach ($data as $obj) {
            $brend = [];//new Brend();
            $brend['id'] = $id++;
            $brend['link'] = $obj->getAttribute('href');
            $brend['title'] = $obj->textContent;
            $storage[] = $brend;
        }*/
        return $storage;
    }
}
