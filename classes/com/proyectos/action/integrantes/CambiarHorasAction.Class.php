<?php

/**
 * Acción para cambiar horas
 *
 * @author Marcos
 * @since 22-12-2016
 *
 */
class CambiarHorasAction extends EditEntityAction{
	
/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::edit();
	 */
	protected function edit( $entity ){
		$this->getEntityManager()->cambioHS( $entity );
		$result["oid"] = $entity->getOid();		
		return $result;
	}

	protected function getEntity() {
	
		$entity =  parent::getEntity();
		
		$separarCUIL = explode('-',trim($entity->getCuil()));

		$preCuil = $separarCUIL[0]; 
		$documento = $separarCUIL[1]; 
		$posCuil = $separarCUIL[2]; 
    	
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('nu_documento', $documento, '=');
			
		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getEntity($oCriteria);
		if (!empty($oDocente)) {
			$entity->setDocente($oDocente);
		}
		
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO);
		$entity->setEstado($oEstado);
		//CYTSecureUtils::logObject($entity);
	
		return $entity;
	}
	
	
	public function getNewFormInstance(){
		return new CMPIntegranteUpDateForm();
	}

	public function getNewEntityInstance(){
		$oIntegrante = new Integrante();
		
		return $oIntegrante;
	}

	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}


	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getForwardSuccess();
	 */
	protected function getForwardSuccess(){
		return 'cambio_horas_success';
	
	}
	



}
