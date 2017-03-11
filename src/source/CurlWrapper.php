<?php namespace parser\source;

class CurlWrapper{
    
    public $conn;
    
    private static $instance = null;
    
    protected function __construct(){}
    
    protected function __clone(){}
    
    protected function __wakeup(){}
    
    public function __destruct() {
        curl_close($this->conn);
    }


    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }
    
    public function connect( $link )
    {
        $this->conn = curl_init( $link );
        $this->setUserAgent();
        $this->setHeader();
        curl_setopt($this->conn, CURLOPT_RETURNTRANSFER, '1');
        $result = curl_exec($this->conn);
        if ($result){
            return $result;
        }else{
            throw new Exception('Error get content in CurlWrapper.');
        }
    }
    
    public function setUserAgent( $agent = 'IE20' )
    {
        curl_setopt( $this->conn, CURLOPT_USERAGENT, $agent );
    }
    
    public function setHeader( $header = false )
    {
        curl_setopt( $this->conn, CURLOPT_HEADER, $header );
    }
    
    public function setHttpHesder($arrayHeaders)
    {/*
        [
            'X-Apple-Tz: 0',
            'X-Apple-Store-Front: 143444,12'
        ]*/
        curl_setopt( $this->conn, CURLOPT_HTTPHEADER, $arrayHeaders );
    }
}
