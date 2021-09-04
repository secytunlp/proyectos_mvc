<?php

/**
 * Tipo de estado 
 *  
 * @author Marcos
 * @since 21-10-2013
 */


class Estado extends Entity{

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