<?php
/**
 * 
 * Componente para autocomplete integrantes.
 * 
 * @author Marcos
 * @since 17/11/2016
 */

class CMPIntegranteAutocomplete extends CMPEntityAutocomplete{

	protected function getEntityClazz(){
		return "Integrante";
	}

	protected function getFieldCode(){
		return "oid";
	}

	protected function getFieldSearch(){
		return "ds_codigo,ds_apellido";
	}

	protected function getEntityManager(){
		return CYTSecureManagerFactory::getDocenteManager();
	}


	public function __construct(){
		$properties = array();
		$properties[] = "ds_codigo";
		$properties[] = "ds_apellido";
		
		$this->setPropertiesList($properties);
	}

	protected function getCriteria($text, $parent=null){
		
		$criterio = new CdtSearchCriteria();

		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		
		$tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
		$filter = new CdtSimpleExpression( "($tDocente.ds_apellido like '$text%') OR ($tDocente.ds_nombre like '$text%') OR ($tProyecto.ds_codigo like '$text%')");

		$criterio->setExpresion($filter);

		return $criterio;
	}

	protected function getItemDropDown( $entity ){
		$dropdownItem = "<div id='autocomplete_item_desc'><table><tr>";
		$dropdownItem .= "<td>".  $entity->getDs_codigo()  . "</td>";
		$dropdownItem .= "<td>".  $entity->getDs_apellido()  . "</td>";
		
		$dropdownItem .= "</tr></table></div>";
		return $dropdownItem;
	}


}
?>