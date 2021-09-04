<?php

/**
 * Utilidades para el sistema.
 *
 * @author Marcos
 * @since 19-10-2013
 */
class CYTUtils {
	

	


	public static function getFilterOptionItems($oManager, $valueProperty, $labelProperty, $ds_field="", $labelFilter="", $valueFilter="", $order="", $criteria="") {

		$oCriteria = ($criteria)?$criteria:new CdtSearchCriteria();
		$order = ($order)?$order:$labelProperty;
		$oCriteria->addOrder($order, "ASC");
		if ($labelFilter!="") {
			$oCriteria->addFilter($labelFilter, $valueFilter, '=');
		}
		$entities = $oManager->getEntities($oCriteria);
		
		$items = array();
		foreach ($entities as $oEntity) {
			$value = CdtReflectionUtils::doGetter($oEntity, $valueProperty);
			if ($ds_field!="") {
				$labelProperty = $ds_field;
			}
			$label = CdtReflectionUtils::doGetter($oEntity, $labelProperty);
			$items[$value] = $label;
		}
		return $items;
	}
	
	

	
	
	
	
	public static function getEstadoIntegranteItems() {

		return self::getFilterOptionItems( ManagerFactory::getEstadoIntegranteManager(), "oid", "ds_estado");

	}
	
	
	
	
	
	
}
