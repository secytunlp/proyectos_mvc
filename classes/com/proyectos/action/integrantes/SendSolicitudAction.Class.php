<?php

/**
 * Acción para enviar una solicitud.
 *
 * @author Marcos
 * @since 24-02-2014
 *
 */
class SendSolicitudAction extends CdtEditAsyncAction {

	
    protected function getEntity() {
    	//recuperamos dado su identifidor.
		$oid = CdtUtils::getParam('id');
			
		if (!empty( $oid )) {
						
			$manager = $this->getEntityManager();
			$entity = $manager->getEntityById($oid);
		}else{
		
			$entity = parent::getEntity();
		
		}
    	
    	$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $managerIntegranteEstado->getEntity($oCriteria);
		if (($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_ALTA_CREADA)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_BAJA_CREADA)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO)) {
			
			throw new GenericException( CYT_MSG_INTEGRANTE_ENVIAR_PROHIBIDO);
		}
		
		
    	if ((($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_ALTA_CREADA)||($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO))&&(date('Y-m-d H:i:s')>CYT_FECHA_CIERRE)) {
			throw new GenericException( CYT_MSG_FIN_PERIODO_ALTAS );
		}
        
		
		return $entity;
    }

    /**
     * (non-PHPdoc)
     * @see CdtEditAsyncAction::edit();
     */
    protected function edit($entity) {
        $this->getEntityManager()->send($entity);
    }
    
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/DeleteEntityAction::getEntityManager()
	 */
	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}


}