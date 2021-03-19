<?php
include 'clases/connection.class.php';
class admin extends connectdb{
    function logeo($usuario, $clave){
        $data = array();
        $query = "CALL sp_adminiciarsesion('$usuario', '$clave')";
        $result=parent::query($query);  
		if(!isset($result['error'])){
			foreach ($result as $row){
                            $data[] = $row;
			}
                } else {
        	$this->setMsgErr($result['error']);
		}
        return $data;
    }        
}