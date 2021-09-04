<?php

/**
 * Factory para componentes
 *
 * @author Marcos
 * @since 21-10-2013
 */

class CYTComponentsFactory {


	


	
	
	
	public static function getFindProyecto(Proyecto $proyecto, $label, $required_msg="", $inputId='proyecto_oid', $inputName='proyecto.oid', $fCallback="proyecto_change") {

		$findEntityInput = FieldBuilder::buildFieldFindEntity ($proyecto->getOid(), $label, $inputId, $inputName, self::getAutocompleteProyecto($proyecto), get_class(ManagerFactory::getProyectoManager()), "CMPProyectoPopupGrid" , $required_msg );
		$findEntityInput->getInput()->setFunctionCallback($fCallback);		
		$findEntityInput->getInput()->setItemAttributesCallback('oid,ds_codigo,ds_titulo');

		$findEntityInput->getInput()->setInputSize(5,25);
		
		return $findEntityInput;
		
	}

	
	
	public static function getAutocompleteProyecto(Proyecto $proyecto, $required_msg="", $inputId='autocomplete_proyecto', $inputName='autocomplete_proyecto', $fCallback="autocomplete_proyecto_change") {

		$autocomplete = new CMPProyectoAutocomplete();

		$autocomplete->setFunctionCallback( $fCallback );
		$autocomplete->setInputSize( $inputSize );
		$autocomplete->setInputName( $inputName );
		$autocomplete->setInputId(  $inputId );
			
		return $autocomplete;
	}
	
	public static function getFindIntegrante(Integrante $integrante, $label, $required_msg="", $inputId='integrante_oid', $inputName='integrante.oid', $fCallback="integrante_change") {

		$findEntityInput = FieldBuilder::buildFieldFindEntity ($integrante->getOid(), $label, $inputId, $inputName, self::getAutocompleteIntegrante($integrante), get_class(ManagerFactory::getIntegranteManager()), "CMPIntegrantePopupGrid" , $required_msg );
		$findEntityInput->getInput()->setFunctionCallback($fCallback);		
		$findEntityInput->getInput()->setItemAttributesCallback('oid,proyecto.ds_codigo,docente.ds_apellido');

		$findEntityInput->getInput()->setInputSize(5,25);
		
		return $findEntityInput;
		
	}

	
	
	public static function getAutocompleteIntegrante(Integrante $integrante, $required_msg="", $inputId='autocomplete_integrante', $inputName='autocomplete_integrante', $fCallback="autocomplete_integrante_change") {

		$autocomplete = new CMPIntegranteAutocomplete();

		$autocomplete->setFunctionCallback( $fCallback );
		$autocomplete->setInputSize( $inputSize );
		$autocomplete->setInputName( $inputName );
		$autocomplete->setInputId(  $inputId );
			
		return $autocomplete;
	}
	
	
	
}
?>