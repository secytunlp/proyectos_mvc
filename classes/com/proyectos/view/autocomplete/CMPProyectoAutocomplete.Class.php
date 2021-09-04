<?php
/**
 * 
 * Componente para autocomplete proyectos.
 * 
 * @author Marcos
 * @since 01/11/2016
 */

class CMPProyectoAutocomplete extends CMPEntityAutocomplete{

	protected function getEntityClazz(){
		return "Proyecto";
	}

	protected function getFieldCode(){
		return "oid";
	}

	protected function getFieldSearch(){
		return "ds_codigo,ds_titulo";
	}

	protected function getEntityManager(){
		return ManagerFactory::getProyectoManager();
	}


	public function __construct(){
		$properties = array();
		$properties[] = "ds_codigo";
		$properties[] = "ds_titulo";
		$this->setPropertiesList($properties);
	}

	protected function getCriteria($text, $parent=null){
		
		$criterio = new CdtSearchCriteria();

		$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
		
		
		$filter = new CdtSimpleExpression( "($tProyecto.ds_codigo like '$text%') OR ($tProyecto.ds_titulo like '%$text%')");

		$criterio->setExpresion($filter);

		return $criterio;
	}

	protected function getItemDropDown( $entity ){
		$dropdownItem = "<div id='autocomplete_item_desc'><table><tr>";
		$dropdownItem .= "<td>".  $entity->getDs_codigo()  . "</td>";
		$dropdownItem .= "<td>".  $entity->getDs_titulo()  . "</td>";
		$dropdownItem .= "</tr></table></div>";
		return $dropdownItem;
	}


}
?>