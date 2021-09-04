<?php

/**
 * Acción para inicializar el contexto
 * para editar un integrante.
 *
 * @author Marcos
 * @since 31-10-2013
 *
 */

class UpdateIntegranteInitAction extends UpdateEntityInitAction {

	
	protected function getEntity(){

		$entity = parent::getEntity();

		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerIntegrateEstado =  ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $managerIntegrateEstado->getEntity($oCriteria);
		if (($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_ALTA_CREADA)) {
			
			throw new GenericException( CYT_MSG_INTEGRANTE_MODIFICAR_PROHIBIDO);
		}
			
		$docenteManager = CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $docenteManager->getObjectByCode($entity->getDocente()->getOid());
		
		$entity->setDs_apellido($oDocente->getDs_apellido());
		$entity->setDs_nombre($oDocente->getDs_nombre());
		$entity->setCuil($oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil());	
		//$entity->setUniversidad($oDocente->getUniversidad());
		return $entity;
	}
	
	
	
	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		
		return new CMPIntegranteUpDateForm($action);
	}
	
	protected function parseEntity($entity, XTemplate $xtpl) {

        $entity = CdtFormatUtils::ifEmpty($entity, $this->getNewEntityInstance());

        $this->getForm()->fillInputValues($entity);
        
     
		
		
		//$this->getForm()->addHidden(FieldBuilder::buildInputHidden ( "hiddenApellido", ""));
        $xtpl->assign('formulario', $this->getForm()->show() );
        
    }

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		return new Integrante();
	}


	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_INTEGRANTE_TITLE_UPDATE;
	}

	/**
	 * retorna el action para el submit.
	 * @return string
	 */
	protected function getSubmitAction(){
		return "update_integrante";
	}


}