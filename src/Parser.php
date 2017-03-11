<?php namespace parser;

use parser\view\View;
use parser\base\DomParser;
use parser\models\Brend;
use parser\models\CarModel;
use parser\base\templates\BrendTemplate;
use parser\base\templates\CarModelTemplate;
use parser\base\templates\CarGenModelTemplate;

class Parser{
    
    /** @var View */
    public $view;
    
   // public static test; 
    
    public function __construct() {
        $view = new View();    
        $view->start();
    }
    
    public static function miningBrend()
    {
        $brend = new BrendTemplate([]);
        $domParser = new DomParser($brend);
        View::render('Parser->miningBrend: searcher (' . count($domParser->result) . ') brends' . "\n");
        return $domParser->result;//['storage'];
    }
    
    public static function miningCarModel(Brend $obj)
    {
        $conf = [   "url" => 'https://www.drive2.ru' . $obj->link,
                    "parentID" => $obj->id ];

        $model = new CarModelTemplate($conf);
        $domParser = new DomParser($model);
        View::render( 'Found (' . $domParser->result->count() . ') cars, in ' . $obj->title );
        return $domParser->result;
        
    }
    
    public static function miningCarGenModel(CarModel $obj)
    {
        
        $conf = [   "url" => 'https://www.drive2.ru' . $obj->link,
                    "parentID" => $obj->id
                ];

        $model = new CarGenModelTemplate($conf);
        $domParser = new DomParser($model);
        View::render( 'Found (' . $domParser->result->count() . ') generations in model: ' . $obj->title );
        return $domParser->result;
    }
     
}
