<?php

/**
 * Formato para renderizar las becas en las grillas
 *
 * @author Marcos
 * @since 11-07-2017
 *
 */
class GridIntegranteEstadoBecasValueFormat extends GridValueFormat {

	public function __construct() {

		parent::__construct();
	}

	public function format($value, $item=null) {

		$strBeca = '';
		$oManagerIntegranteEstado = ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $oManagerIntegranteEstado->getObjectByCode($value);
		
		if($oIntegranteEstado->getDs_tipobeca()!='' ){
			
			
			$strBeca = $oIntegranteEstado->getDs_tipobeca().' '.$oIntegranteEstado->getDs_orgbeca();
			
		}
		elseif($oIntegranteEstado->getBl_becaEstimulo() ){
			
			
			$strBeca = 'Beca de Estímulo a las Vocaciones Científicas';
			
		}
		
		 
		return $strBeca ;
	}

}