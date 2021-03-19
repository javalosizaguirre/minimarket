<?php
include_once RUTA_MYSQL . 'connection.class.php';
class menu extends connectdb{
function consultarMenu($flag,$perfil,$menu=''){
        $data = array();
        $query = "CALL sp_menuConsultar('$flag','$perfil','$menu')";
        
        $result = parent::query($query);
        if(!isset($result['error'])){
            foreach($result as $row){
                $data[] = $row;
            }        
        }else{
            $this->setMsgErr($result['error']);
        }
        return $data;
    }
}