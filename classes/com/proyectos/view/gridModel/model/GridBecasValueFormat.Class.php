<?php

/**
 * Formato para renderizar las becas en las grillas
 *
 * @author Marcos
 * @since 11-07-2017
 *
 */
class GridBecasValueFormat extends GridValueFormat {

	public function __construct() {

		parent::__construct();
	}

	public function format($value, $item=null) {

		$strBeca = '';
		$oManagerIntegrante = ManagerFactory::getIntegranteManager();
		$oIntegrante = $oManagerIntegrante->getObjectByCode($value);
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_docente', $oIntegrante->getDocente()->getOid(), '=');
		$oCriteria->addFilter('dt_hasta', date('Y-m-d'), '>', new CdtCriteriaFormatStringValue());
		$oBecaManager =  CYTSecureManagerFactory::getBecaManager();
		$oBeca = $oBecaManager->getEntity($oCriteria);
		if (!empty($oBeca)) {
			$strOrg = ($oBeca->getBl_unlp())?'U.N.L.P.':'';
			$strBeca = $oBeca->getDs_tipobeca().' '.$strOrg;
			
		}
		elseif($oIntegrante->getDs_tipobeca()!='' ){
			
			
			$strBeca = $oIntegrante->getDs_tipobeca().' '.$oIntegrante->getDs_orgbeca().' ('.CYTSecureUtils::formatDateToView($oIntegrante->getDt_beca()).' - '.CYTSecureUtils::formatDateToView($oIntegrante->getDt_becaHasta()).')';
			
		}
		elseif($oIntegrante->getBl_becaEstimulo() ){
			
			
			$strBeca = 'Beca de Estímulo a las Vocaciones Científicas ('.CYTSecureUtils::formatDateToView($oIntegrante->getDt_becaEstimulo()).' - '.CYTSecureUtils::formatDateToView($oIntegrante->getDt_becaEstimuloHasta()).')';
			
		}
		
		 
		return $strBeca ;
	}

}