<?php

/**
 * DAO para TipoIntegrante
 *  
 * @author Marcos
 * @since 30-10-2013
 */
class TipoIntegranteDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_TIPO_INTEGRANTE;
	}
	
	public function getEntityFactory(){
		return new TipoIntegranteFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		$fieldsValues = array();
		
		
		
		return $fieldsValues;
	}
	
	
	
}
?>