<?php
class DB_MySQL {
  private $connection = NULL;
  private $result = NULL;
  private $counter=NULL;
 
 
  public function __construct($host=NULL, $database=NULL, $user=NULL, $pass=NULL){
	$this->connection = mysql_connect($host,$user,$pass,TRUE);
  	mysql_select_db($database, $this->connection);
  }
 
  public function disconnect() {
    if (is_resource($this->connection))				
        mysql_close($this->connection);
  }
 
public function query($query) {
  	$this->result=mysql_query($query,$this->connection);
  	$this->counter=NULL;
  }
  
  public function fetchRow() {
  	return mysql_fetch_assoc($this->result);
  }
  
public function fetcharray() {
	return  mysql_fetch_array($this->result);
  }
  
   public function fetchnumrows() {
    return  mysql_num_rows($this->result); 
  }

 
  public function count() {
  	if($this->counter==NULL && is_resource($this->result)) {
  		$this->counter=mysql_num_rows($this->result);
  	}
 
	return $this->counter;
  }
}
?>