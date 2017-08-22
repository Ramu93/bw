<?php

class FormWrapper {
	
	public function getFormValues($formarray, $postvalues, $multiple='no')
	{
		$outputarray = array();
		if($multiple == 'no'){
			foreach ($formarray as $key => $value) {
				$outputarray[$value] = $postvalues[$key];
			}
		}else{
			foreach ($formarray as $key => $value) {
				$c = 0;
				foreach( $postvalues[$key] as $key2 => $value2){
					$outputarray[$c][$value] = $value2;
					$c++;
				}
			}
		}
		return $outputarray;
	}

	public function getFormValuesFromJSON($formarray, $postvalues, $multiple='no')
	{
		$outputarray = array();
		if($multiple == 'no'){
			foreach ($formarray as $key => $value) {
				$outputarray[$value] = $postvalues[$key];
			}
		}else{
			foreach ($formarray as $key => $value) {
				$c = 0;
				foreach( $postvalues as $key2 => $value2){
					$outputarray[$c][$value] = $value2->$key;
					$c++;
				}
			}
		}
		return $outputarray;
	}
        
}

?>