<?php

/**
 * TipoAcreditacion
 *  
 * @author Marcos
 * @since 12-11-2013
 */


class TipoAcreditacion  extends Entity{

    //variables de instancia.

    private $ds_estado;
    
    
    

    public function __construct(){
    	
    	$this->ds_estado = "";
    }
    
    

    public function getDs_estado()
    {
        return $this->ds_estado;
    }

    public function setDs_estado($ds_estado)
    {
        $this->ds_estado = $ds_estado;
    }
}
?>