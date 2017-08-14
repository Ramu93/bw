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
        //file_put_contents("testlog.log", "\n".$query."\nOutput : ".print_r($output, true), FILE_APPEND | LOCK_EX);
    	
        return $output;
    }

    public function updateOperation($tablename, $inputdata, $whereclause){
        $wherequery = array(); $wherepart = '';
        $query = "UPDATE $tablename SET ";
        foreach ($inputdata as $key => $value) {
            $inputdata[$key] = mysqli_real_escape_string($this->db, $value);
            $query .= $key." = '".$inputdata[$key]."',"; 
        }
        $query = substr($query, 0, -1); //removing the last comma

        foreach ($whereclause as $key => $value) {
            $whereclause[$key] = mysqli_real_escape_string($this->db, $value);
            $wherequery[] = $key." = '".$whereclause[$key]."'"; 
        }

        if($wherequery)
            $wherepart = implode(" AND ", $wherequery); //Only AND for now TODO for other types

        $query .= "  WHERE ".$wherepart;
        
        if(mysqli_query($this->db, $query)){
            //$last_insert_id = mysqli_insert_id($this->db);
            $output = array("status" => "success", "affected_rows" => mysqli_affected_rows($this->db));
        }else{
            $output = array("status" => "failed", "error_details" => mysqli_error($this->db), "affected_rows" => mysqli_affected_rows($this->db));
        }
        //file_put_contents("testlog.log", "\n".$query."\nOutput : ".print_r($output, true), FILE_APPEND | LOCK_EX);
        
        return $output;
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