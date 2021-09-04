<?php

/**
 * Acción para inicializar el contexto
 * para rechazar una solicitud
 *
 * @author Marcos
 * @since 18-11-2016
 *
 */

class DenySolicitudInitAction extends EditEntityInitAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		return new CMPDenySolicitudForm($action);
		
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$denySolicitud = new DenySolicitud();
		
		$integrante_oid = CdtUtils::getParam('id');
			
		if (!empty( $integrante_oid )) {
			
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('oid', $integrante_oid, '=');
			$oCriteria->addNull('fechaHasta');			
			
			$integranteManager = ManagerFactory::getIntegranteManager();
			$oIntegrante = $integranteManager->getEntity($oCriteria);
			
			$denySolicitud->setIntegrante($oIntegrante);
			$denySolicitud->setEstado($oIntegrante->getEstado());
			$denySolicitud->setTipoIntegrante($oIntegrante->getTipoIntegrante());
		}
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('integrante_oid', $integrante_oid, '=');
		$oCriteria->addNull('fechaHasta');
		$managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $managerIntegranteEstado->getEntity($oCriteria);
		if (($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_ALTA_RECIBIDA)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_RECIBIDO)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_HS_RECIBIDO)) {
			
			throw new GenericException( CYT_MSG_INTEGRANTE_RECHAZAR_PROHIBIDO);
		}
	
		return $denySolicitud;
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_SOLICITUD_RECHAZAR;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "deny_solicitud_integrante";
	}


}
