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
        $output = array();
    	$query = "INSERT INTO $tablename ";
    	$ipdata_copy = array_keys($inputdata);

    	$tablecolumns = implode(',', $ipdata_copy);
        //array_walk($inputdata, array($this, 'escapeinjection'));
        foreach ($inputdata as $key => $value) {
            $inputdata[$key] = mysqli_real_escape_string($this->db, $value);
        }
    	$tablevalues = implode("','", $inputdata);
        //array_walk($ipdata_copy, 'addcolon');
    	$query .= "( ".$tablecolumns." ) VALUES ( '".$tablevalues."')";
    	
        if(mysqli_query($this->db, $query)){
            $last_insert_id = mysqli_insert_id($this->db);
            $output = array("status" => "success", "last_insert_id" => $last_insert_id, "affected_rows" => mysqli_affected_rows($this->db));
        }else{
            $output = array("status" => "failed", "error_details" => mysqli_error($this->db), "affected_rows" => mysqli_affected_rows($this->db));
        }
        file_put_contents("testlog.log", "\n".$query."\nOutput : ".print_r($output, true), FILE_APPEND | LOCK_EX);
    	
        return $output;
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

    private function escapeinjection(&$item, $key){
        $item = mysqli_real_escape_string($this->db, $item);
    }
        
}

function addcolon(&$item, $key){
	$item = ":".$item;
}

function update_addcolon(&$item, $key){
	$item = $item." = :".$item;
}


?>