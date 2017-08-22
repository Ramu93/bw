<?php

class DBWrapper {
	
	private $db;
	
	function __construct($dbobj)
	{
		$this->db = $dbobj;
	}
	
	public function runQuery($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$result=$stmt->fetchall(PDO::FETCH_ASSOC);
		return $result;
	}
        
    public function insertOperation($tablename, $inputdata, $spl = ''){
    	$query = "INSERT INTO $tablename ";
    	$ipdata_copy = array_keys($inputdata);

    	$tablecolumns = implode(',', $ipdata_copy);
    	array_walk($ipdata_copy, 'addcolon');
    	$tablevalues = implode(',', $ipdata_copy);
    	$query .= "( ".$tablecolumns." ) VALUES ( ".$tablevalues." )";
    	$stmt = $this->db->prepare($query);
    	foreach ($inputdata as $key => $value) {
    		$stmt->bindparam(":{$key}", $inputdata[$key]);	
    		//echo ":{$key} , $inputdata[$key] ";
    	}
        //file_put_contents("testlog.log", $query, FILE_APPEND | LOCK_EX);
    	
    	$stmt->execute();
        //file_put_contents("testlog.log","\n {$tablename} Autoid : ". $this->db->lastInsertId(), FILE_APPEND | LOCK_EX);
        //file_put_contents("testlog.log", print_r( $stmt, true ), FILE_APPEND | LOCK_EX);
        return $stmt;
    }

    public function updateOperation($tablename, $inputdata, $whereclause){
    	$query = "UPDATE $tablename SET ";
    	$ipdata_copy = array_keys($inputdata);
		array_walk($ipdata_copy, 'update_addcolon');
    	$tablevalues = implode(',', $ipdata_copy);
    	
    	$query .= $tablevalues." WHERE ".$whereclause['condition'];
    	$stmt = $this->db->prepare($query);
    	foreach ($inputdata as $key => $value) {
    		$stmt->bindparam(":{$key}", $inputdata[$key]);
    	}
        if($whereclause['param']!=''){
    	   $stmt->bindparam($whereclause['param'], $whereclause['value']);
        }
    	//file_put_contents("testlogupdate.log", "\n".$query, FILE_APPEND | LOCK_EX);
    	$stmt->execute();
        //file_put_contents("testlog.log", print_r( $stmt, true ), FILE_APPEND | LOCK_EX);
        return $stmt;
    }

    
	
        public function getSingleRow($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM visit WHERE school_id=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
                 if($stmt->rowCount()==0){
                    $editRow = array();
                }
		return $editRow;
	}
	
          public function getCompetitorInfo($schoolDetailsId)
	{
		$stmt = $this->db->prepare("SELECT * FROM competitor_info WHERE school_details_id=:id");
		$stmt->execute(array(":id"=>$schoolDetailsId));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);               
		return $editRow;
	}
        
        
        
}

function addcolon(&$item, $key){
	$item = ":".$item;
}

function update_addcolon(&$item, $key){
	$item = $item." = :".$item;
}
?>