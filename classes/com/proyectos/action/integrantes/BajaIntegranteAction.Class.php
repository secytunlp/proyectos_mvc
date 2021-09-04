<?php

/**
 * Acción para dar de baja un Integrante
 *
 * @author Marcos
 * @since 07-12-2016
 *
 */
class BajaIntegranteAction extends EditEntityAction{
	
	
	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::edit();
	 */
	protected function edit( $entity ){
		$this->getEntityManager()->baja( $entity );
		$result["oid"] = $entity->getOid();		
		return $result;
	}

	protected function getEntity() {
	
		$entity =  parent::getEntity();
	
		
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_INTEGRANTE_BAJA_CREADA);
		$entity->setEstado($oEstado);
		//CYTSecureUtils::logObject($entity);
	
		return $entity;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		
		return new CMPIntegranteBajaForm();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
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
		return 'baja_integrante_success';
	
	}
	


}
