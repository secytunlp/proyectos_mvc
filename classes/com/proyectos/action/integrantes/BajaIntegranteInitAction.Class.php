<?php

/**
 * Acción para inicializar el contexto
 * para bajar un integrante.
 *
 * @author Marcos
 * @since 22-11-2016
 *
 */

class BajaIntegranteInitAction extends UpdateEntityInitAction {

	protected function getEntity(){

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
		$managerIntegrateEstado =  ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $managerIntegrateEstado->getEntity($oCriteria);
		
		
		if (($oIntegranteEstado->getTipointegrante()->getOid()==CYT_INTEGRANTE_DIRECTOR)||($oIntegranteEstado->getTipointegrante()->getOid()==CYT_INTEGRANTE_CODIRECTOR)) {
			
			throw new GenericException( CYT_MSG_INTEGRANTE_BAJA_PROHIBIDO2);
		}

		if ($oIntegranteEstado->getDt_baja()&&($oIntegranteEstado->getDt_baja()!='0000-00-00')&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_BAJA_CREADA)) {
			throw new GenericException( CYT_MSG_INTEGRANTE_BAJA_PROHIBIDO3);
		}

		if (($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_ADMITIDO)||($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_BAJA_CREADA)) {
			
			$docenteManager = CYTSecureManagerFactory::getDocenteManager();
			$oDocente = $docenteManager->getObjectByCode($entity->getDocente()->getOid());
			
			$entity->setDs_apellido($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre());
			
			$entity->setDt_baja($oIntegranteEstado->getDt_baja());
			return $entity;
			
			
		}
		else throw new GenericException( CYT_MSG_INTEGRANTE_BAJA_PROHIBIDO);
		
		
	}
	
	
	
	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		
		return new CMPIntegranteBajaForm($action);
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
		return CYT_MSG_INTEGRANTE_TITLE_BAJA;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "baja_integrante";
	}


}
