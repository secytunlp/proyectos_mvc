<?php

/**
 * Acción para inicializar el contexto
 * para cambiar el estado de un integrante
 *
 * @author Marcos
 * @since 18-11-2016
 *
 */

class CambiarEstadoIntegranteInitAction extends EditEntityInitAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		return new CMPCambiarEstadoIntegranteForm($action);
		
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$cambiarEstadoIntegrante = new CambiarEstadoIntegrante();
		
		$filter = new CMPIntegranteEstadoFilter();
		$filter->fillSavedProperties();
		$cambiarEstadoIntegrante->setIntegrante($filter->getIntegrante());
		
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('integrante_oid', $filter->getIntegrante()->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $managerIntegranteEstado->getEntity($oCriteria);
		if ($oIntegranteEstado) {
			$cambiarEstadoIntegrante->setEstado($oIntegranteEstado->getEstado());
			$cambiarEstadoIntegrante->setTipoIntegrante($oIntegranteEstado->getTipoIntegrante());
			$cambiarEstadoIntegrante->setCargo($oIntegranteEstado->getCargo());
			$cambiarEstadoIntegrante->setDeddoc($oIntegranteEstado->getDeddoc());
			$cambiarEstadoIntegrante->setFacultad($oIntegranteEstado->getFacultad());
			$cambiarEstadoIntegrante->setCategoria($oIntegranteEstado->getCategoria());
			$cambiarEstadoIntegrante->setCarreraInv($oIntegranteEstado->getCarreraInv());
			$cambiarEstadoIntegrante->setOrganismo($oIntegranteEstado->getOrganismo());
			$cambiarEstadoIntegrante->setDs_orgbeca($oIntegranteEstado->getDs_orgbeca());
			$cambiarEstadoIntegrante->setDs_tipobeca($oIntegranteEstado->getDs_tipobeca());
			$cambiarEstadoIntegrante->setDt_beca($oIntegranteEstado->getDt_beca());
			$cambiarEstadoIntegrante->setDt_becaHasta($oIntegranteEstado->getDt_becaHasta());
			$cambiarEstadoIntegrante->setBl_becaEstimulo($oIntegranteEstado->getBl_becaEstimulo());
			$cambiarEstadoIntegrante->setDt_becaEstimulo($oIntegranteEstado->getDt_becaEstimulo());
			$cambiarEstadoIntegrante->setDt_becaEstimuloHasta($oIntegranteEstado->getDt_becaEstimuloHasta());
			$cambiarEstadoIntegrante->setDt_alta($oIntegranteEstado->getDt_alta());
			$cambiarEstadoIntegrante->setDt_baja($oIntegranteEstado->getDt_baja());
			$cambiarEstadoIntegrante->setDt_cambio($oIntegranteEstado->getDt_cambio());
			$cambiarEstadoIntegrante->setNu_horasinv($oIntegranteEstado->getNu_horasinv());
		}
		
		
		
		
		return $cambiarEstadoIntegrante;
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_SOLICITUD_ESTADO_CAMBIAR;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "cambiarEstadoIntegrante";
	}


}
