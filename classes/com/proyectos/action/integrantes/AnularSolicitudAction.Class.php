<?php

/**
 * Acción para rechazar la solicitud
 *
 * @author Marcos
 * @since 29-12-2016
 *
 */
class AnularSolicitudAction extends AddEntityAction{

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::edit();
	 */
	protected function edit( $entity ){
		
		$manager = $this->getEntityManager();
		$oIntegrante = $manager->getEntityById($entity->getIntegrante()->getOid());
		
		$this->getEntityManager()->anular($oIntegrante );
		$result["oid"] = $entity->getOid();		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		return new CMPDenySolicitudForm();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		
		return new DenySolicitud();
	}

	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}



	


}
