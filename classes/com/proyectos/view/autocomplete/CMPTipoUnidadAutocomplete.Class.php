<?php
class CMPTipoUnidadAutocomplete extends CMPEntityAutocomplete{

	protected function getEntityClazz(){
		return "TipoUnidad";
	}

	protected function getFieldCode(){
		return "oid";
	}

	protected function getFieldSearch(){
		return "nombre";
	}
	
	protected function getFieldSearchParent(){
		return "";
	}
	protected function getEntityManager(){
		return ManagerFactory::getTipoUnidadManager();
	}


	public function __construct(){
		$properties = array();
		$properties[] = "oid";
		$properties[] = "nombre";
		$this->setPropertiesList($properties);
	}

	

	protected function getItemDropDown( $entity ){
		$dropdownItem = "<div id='autocomplete_item_desc'><table><tr>";
		$dropdownItem .= "<td>".  $entity->getNombre() . "</td>";
		$dropdownItem .= "</tr></table></div>";
		return $dropdownItem;
	}

}
?>