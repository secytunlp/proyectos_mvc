<?php

/**
 * DAO para Estado
 *  
 * @author Marcos
 * @since 21-10-2013
 */
class EstadoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_ESTADOPROYECTO;
	}
	
	public function getEntityFactory(){
		return new EstadoFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		$fieldsValues = array();
		
		 
		
		return $fieldsValues;
	}
	
}
?>