<?php

/**
 * DAO para Estado
 *  
 * @author Marcos
 * @since 21-10-2013
 */
class EstadoIntegranteDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_ESTADOINTEGRANTE;
	}
	
	public function getEntityFactory(){
		return new EstadoFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		$fieldsValues = array();
		
		 
		
		return $fieldsValues;
	}
	
	public function getIdFieldName(){
		return "cd_estado";
	}
	
}
?>