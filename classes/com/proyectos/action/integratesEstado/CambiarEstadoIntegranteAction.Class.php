<?php

/**
 * Acción para cambiar el estado de la integrante
 *
 * @author Marcos
 * @since 18-11-2016
 *
 */
class CambiarEstadoIntegranteAction extends AddEntityAction{

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::edit();
	 */
	protected function edit( $entity ){
		
		$integranteManager = ManagerFactory::getIntegranteManager();
		$oIntegrante = $integranteManager->getObjectByCode($entity->getIntegrante()->getOid());
		/*$oIntegrante->setEstado($entity->getEstado());
		$oIntegrante->setTipointegrante($entity->getTipointegrante());
		$oIntegrante->setDt_alta($entity->getDt_alta());
		$oIntegrante->setDt_baja($entity->getDt_baja());*/
		//$oIntegrante->setDt_cambio($entity->getDt_cambio());
		$integranteManager->updatesinvalidar($oIntegrante);
		$oIntegranteEstado = new IntegranteEstado();
		$oIntegranteEstado->setIntegrante($entity->getIntegrante());
		$oIntegranteEstado->setEstado($entity->getEstado());
		$oIntegranteEstado->setTipointegrante($entity->getTipointegrante());
		$oIntegranteEstado->setCargo($entity->getCargo());
		$oIntegranteEstado->setDeddoc($entity->getDeddoc());
		$oIntegranteEstado->setCategoria($entity->getCategoria());
		$oIntegranteEstado->setFacultad($entity->getFacultad());
		$oIntegranteEstado->setCarreraInv($entity->getCarreraInv());
		$oIntegranteEstado->setOrganismo($entity->getOrganismo());
		$oIntegranteEstado->setDt_alta($entity->getDt_alta());
		$oIntegranteEstado->setDs_orgbeca($entity->getDs_orgbeca());
		$oIntegranteEstado->setDs_tipobeca($entity->getDs_tipobeca());
		$oIntegranteEstado->setDt_beca($entity->getDt_beca());
		$oIntegranteEstado->setDt_becaHasta($entity->getDt_becaHasta());
		$oIntegranteEstado->setBl_becaEstimulo($entity->getBl_becaEstimulo());
		$oIntegranteEstado->setDt_becaEstimulo($entity->getDt_becaEstimulo());
		$oIntegranteEstado->setDt_becaEstimuloHasta($entity->getDt_becaEstimuloHasta());
		$oIntegranteEstado->setDt_alta($entity->getDt_alta());
		$oIntegranteEstado->setDt_baja($entity->getDt_baja());
		$oIntegranteEstado->setDt_cambio($entity->getDt_cambio());
		$oIntegranteEstado->setNu_horasinv($entity->getNu_horasinv());
		$oIntegranteEstado->setMotivo($entity->getMotivo());
		$oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
		$oUser = CdtSecureUtils::getUserLogged();
		$oIntegranteEstado->setUser($oUser);
		$oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
		$this->getEntityManager()->cambiarEstado($oIntegrante,$oIntegranteEstado,1 );
		$result["oid"] = $entity->getOid();		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		return new CMPCambiarEstadoIntegranteForm();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		
		return new CambiarEstadoIntegrante();
	}

	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}



	


}
