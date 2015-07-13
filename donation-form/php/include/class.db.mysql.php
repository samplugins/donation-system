<?php
/**
 * MySQL Database Handler
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class MySql
{

    /*** Declare instance ***/
    private static $instance;
    
    public $qCount;
    public $linkConnect;
    public $results;
    
    public $pageSize; 
    public $page; 
    public $row;
    public $count_rows;
    
    /**
    * The constructor for the DB class, notice that this is private because you cannot instantiate it
    * Instantiation is done with the getInstance() function, use that to get an instance of this class
    */
    private function __construct($config){         
        $this->connect($config);                       
    }
    
    private function __clone(){
        //enforce singleton
    }
        
    public function connect($config=array())
    {        
        $this->linkConnect = @mysql_connect($config['host'], $config['user'], $config['password']); 
        if(!$this->linkConnect)
            throw new Exception("Unable to connect - " . mysql_error());

         $dbResponse =  mysql_select_db($config['db'], $this->linkConnect) or  trigger_error("Unable to connect to MySql Database: ".mysql_error());   
         if($dbResponse == false)
         {
             throw new Exception("Unable to select to MySql Database: ".mysql_error()) ;
         }
          
    }
 
    /**
    * Get instance returns the currently instantiated object of this DB class.  
    * This forces only one connection to the MySQL server
    * @return DB object
    */
    public static function Instance()
    {
        global $config;
        if(!self::$instance) 
            self::$instance = new self($config['database']);
        
        return self::$instance; 
    }
    

    function query($sql){
        $q = mysql_query($sql);
        
        if(!$q){                                                                     
             throw new Exception("Query can't be executed".mysql_error()) ;    
        }
        return $q;
    }
    

    /**
    * 
    * @returns the QuickArray    
    */
    function QuickArray($sql) { 
        return mysql_fetch_array($this->query($sql)); 
    }
    

    function getOne($sql) { 
        $r = mysql_fetch_array($this->query($sql)); 
        return $r[0];
    }//  fetchArray() ends
    
     /**
    * 
    * @returns the QuickArray    
    */
    function QuickCount($sql) { 
        return mysql_num_rows($this->query($sql)); 
    }//  fetchArray() ends
    
    /**
    * 
    * @returns the ARRAY    
    */
    function myArray($queryHandler) { 
        return  $this->stripslashes_deep(mysql_fetch_assoc($queryHandler)); 
    }//
    
     
    function stripslashes_deep($value){
        $value = is_array($value) ?
                    array_map(array($this, __FUNCTION__), $value) :
                    stripslashes($value);

        return $value;
    }
    
    /**
    * 
    * @returns the ARRAY    
    */
    function myObject($queryHandler) { 
        return mysql_fetch_object($queryHandler); 
    }//  fetchArray() ends
    
    
    /**
    * Get the number of rows count
    * @return the number of rows    
    */
    function NumRows($result){
        return mysql_num_rows($result); 
    }

    /**
    *GET LAST Insert ID
    */
    function getInsertID(){
        return mysql_insert_id( $this->linkConnect );
    }
    
    /**
    *GET LAST Insert ID
    */
    function getAffectedRows(){
        return mysql_affected_rows( $this->linkConnect );
    }

    public function close(){
        mysql_close($this->linkConnect );
    }
    
    function dataset($sql){
        $q = $this->query($sql);
        
        $dataset =array();
        while($r = $this->myArray($q)){
            $dataset[] = $r;
        }
        return $dataset;
    }
} /*** end of class ***/  
?>
