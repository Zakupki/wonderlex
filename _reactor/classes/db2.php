<?php

/**
* PDO SINGLETON CLASS
*/
class db2
{
    /**
* The singleton instance
*
*/
    static private $PDOInstance;
	static private $Instance;
	static private $statement;
     
   /**
* Creates a PDO instance representing a connection to a database and makes the instance available as a singleton
*
* @param string $dsn The full DSN, eg: mysql:host=localhost;dbname=testdb
* @param string $username The user name for the DSN string. This parameter is optional for some PDO drivers.
* @param string $password The password for the DSN string. This parameter is optional for some PDO drivers.
* @param array $driver_options A key=>value array of driver-specific connection options
*
* @return PDO
*/
    static function init()
    {
    	
	   if(!self::$Instance) {
			try {
			$ini_array = parse_ini_file("config/config.ini");
			$driver_options=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
			self::$PDOInstance = new PDO("mysql:host=".$ini_array['host'].";dbname=".$ini_array['dbname']."", $ini_array['username'], $ini_array['password'], $driver_options);
			self::$Instance=new db2;
			} catch (PDOException $e) {
			die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
			}
	   }
       return self::$Instance;
    }
    /**
* Prepares a statement for execution and returns a statement object
*
* @param string $statement A valid SQL statement for the target database server
* @param array $driver_options Array of one or more key=>value pairs to set attribute values for the PDOStatement obj
returned
* @return PDOStatement
*/
    public function prepare ($statement, $driver_options=false) {
     if(!$driver_options) $driver_options=array();
     return self::$PDOInstance->prepare($statement, $driver_options);
    }
	
    /**
* Execute an SQL statement and return the number of affected rows
*
* @param string $statement
*/	
	public function exec($statement) {
    	 $Q=self::$PDOInstance->exec($statement);
		 $E=self::$PDOInstance->errorInfo();
		 if($E[1]){
		 	 $E[]=$statement;
		 	 tools::print_r($E);
		 }else
			 return $Q;
	}
	
/**
* Fetch the SQLSTATE associated with the last operation on the database handle
*
* @return string
*/
    public function errorCode() {
     return self::$PDOInstance->errorCode();
    }
    
    /**
* Fetch extended error information associated with the last operation on the database handle
*
* @return array
*/
    public function errorInfo() {
     return self::$PDOInstance->errorInfo();
    }
}

?>