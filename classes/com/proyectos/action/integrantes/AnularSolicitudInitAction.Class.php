<?php

/**
 * Acción para inicializar el contexto
 * para anular una solicitud
 *
 * @author Marcos
 * @since 29-12-2016
 *
 */

	class AnularSolicitudInitAction extends EditEntityInitAction {
	
	

	
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		return new CMPDenySolicitudForm($action);
		
	}

	
	protected function parseEntity($entity, XTemplate $xtpl) {

        $entity = CdtFormatUtils::ifEmpty($entity, $this->getNewEntityInstance());

        $this->getForm()->fillInputValues($entity);
        
		$inputCombo =  $this->getForm()->getInput("observaciones");
		
		$inputCombo->setIsVisible(false);
		
		
		
		//$this->getForm()->addHidden(FieldBuilder::buildInputHidden ( "hiddenApellido", ""));
        $xtpl->assign('formulario', $this->getForm()->show() );
        
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
			
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('integrante_oid', $integrante_oid, '=');
			$oCriteria->addNull('fechaHasta');
			$managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
			$oIntegranteEstado = $managerIntegranteEstado->getEntity($oCriteria);
			if (($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_BAJA_CREADA)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO)&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO)) {
				
				throw new GenericException( CYT_MSG_INTEGRANTE_ANULAR_PROHIBIDO);
			}
		}
		
		
		return $denySolicitud;
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_INTEGRANTE_SOLICITUD_ANULAR;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "anular_solicitud_integrante";
	}


}
