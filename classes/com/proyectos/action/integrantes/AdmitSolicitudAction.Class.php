<?php

/**
 * Acción para admitir una solicitud.
 *
 * @author Marcos
 * @since 18-11-2016
 *
 */
class AdmitSolicitudAction extends CdtEditAsyncAction {

	
    protected function getEntity() {
        $entity = null;

		//recuperamos dado su identifidor.
		$oid = CdtUtils::getParam('id');
			
		if (!empty( $oid )) {
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('oid', $oid, '=');
			$oCriteria->addNull('fechaHasta');			
			$manager = $this->getEntityManager();
			$entity = $manager->getEntity($oCriteria);
		}else{
		
			$entity = parent::getEntity();
		
		}
		
    	$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $managerIntegranteEstado->getEntity($oCriteria);
		if (($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_ALTA_RECIBIDA)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_RECIBIDO)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_HS_RECIBIDO)) {
			
			throw new GenericException( CYT_MSG_INTEGRANTE_ADMITIR_PROHIBIDO);
		}
		
		return $entity;
    }

    /**
     * (non-PHPdoc)
     * @see CdtEditAsyncAction::edit();
     */
    protected function edit($entity) {
        $this->getEntityManager()->confirm($entity);
    }
    
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/DeleteEntityAction::getEntityManager()
	 */
	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}


}