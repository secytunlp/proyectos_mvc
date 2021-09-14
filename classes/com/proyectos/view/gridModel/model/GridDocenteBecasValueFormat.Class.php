<?php

/**
 * Formato para renderizar las becas en las grillas docentes
 *
 * @author Marcos
 * @since 06-09-2021
 *
 */
class GridDocenteBecasValueFormat extends GridValueFormat {

	public function __construct() {

		parent::__construct();
	}

	public function format($value, $item=null) {

		$strBeca = '';
		$oManagerDocente = CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oManagerDocente->getObjectByCode($value);
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_docente', $oDocente->getOid(), '=');
		$oCriteria->addFilter('dt_hasta', date('Y-m-d'), '>', new CdtCriteriaFormatStringValue());
		$oBecaManager =  CYTSecureManagerFactory::getBecaManager();
		$oBeca = $oBecaManager->getEntity($oCriteria);
		if (!empty($oBeca)) {
			$strOrg = ($oBeca->getBl_unlp())?'U.N.L.P.':'';
			$strBeca = $oBeca->getDs_tipobeca().' '.$strOrg;

		}
		elseif($oDocente->getDs_tipobeca()!='' ){


			$strBeca = $oDocente->getDs_tipobeca().' '.$oDocente->getDs_orgbeca().' ('.CYTSecureUtils::formatDateToView($oDocente->getDt_beca()).' - '.CYTSecureUtils::formatDateToView($oDocente->getDt_becaHasta()).')';

		}
		elseif($oDocente->getBl_becaEstimulo() ){


			$strBeca = 'Beca de Estímulo a las Vocaciones Científicas ('.CYTSecureUtils::formatDateToView($oDocente->getDt_becaEstimulo()).' - '.CYTSecureUtils::formatDateToView($oDocente->getDt_becaEstimuloHasta()).')';

		}


		return $strBeca ;
	}

}
