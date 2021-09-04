<?php
/**
 * 
 * Componente para autocomplete docentes.
 * 
 * @author Marcos
 * @since 04/11/2013
 */

class CMPDocenteAutocomplete extends CMPEntityAutocomplete{

	protected function getEntityClazz(){
		return "Docente";
	}

	protected function getFieldCode(){
		return "oid";
	}

	protected function getFieldSearch(){
		return "ds_apellido,ds_nombre,nu_documento";
	}

	protected function getEntityManager(){
		return CYTSecureManagerFactory::getDocenteManager();
	}


	public function __construct(){
		$properties = array();
		$properties[] = "ds_apellido";
		$properties[] = "ds_nombre";
		$properties[] = "nu_documento";
		$this->setPropertiesList($properties);
	}

	protected function getCriteria($text, $parent=null){
		
		$criterio = new CdtSearchCriteria();

		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		
		
		$filter = new CdtSimpleExpression( "($tDocente.ds_apellido like '$text%') OR ($tDocente.ds_nombre like '$text%') OR ($tDocente.nu_documento like '$text%')");

		$criterio->setExpresion($filter);

		return $criterio;
	}

	protected function getItemDropDown( $entity ){
		$dropdownItem = "<div id='autocomplete_item_desc'><table><tr>";
		$dropdownItem .= "<td>".  $entity->getDs_apellido()  . "</td>";
		$dropdownItem .= "<td>".  $entity->getDs_nombre()  . "</td>";
		$dropdownItem .= "<td>".  $entity->getNu_documento()  . "</td>";
		$dropdownItem .= "</tr></table></div>";
		return $dropdownItem;
	}


}
?>