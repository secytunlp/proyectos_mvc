<?php

/**
 * Acción para inicializar el contexto
 * para editar un integrante.
 *
 * @author Marcos
 * @since 30-10-2013
 *
 */

class AddIntegranteInitAction extends EditEntityInitAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		
		
		

		return new CMPIntegranteForm($action);
		
	}
	
	/**
     * (non-PHPdoc)
     * @see CdtEditInitAction::parseEntity();
     */
    protected function parseEntity($entity, XTemplate $xtpl) {

        $entity = CdtFormatUtils::ifEmpty($entity, $this->getNewEntityInstance());

        $this->getForm()->fillInputValues($entity);
        
     
        if($entity->getProyecto()->getOid()){
        	$oProyectoManager = ManagerFactory::getProyectoManager();
			$oProyecto = $oProyectoManager->getObjectByCode($entity->getProyecto()->getOid());
        }
		else throw new GenericException( CYT_MSG_PROYECTO_NO_SELECCIONADO );
		

		/*$inputCombo =  $this->getForm()->getInput("tipoIntegrante.oid");
		$inputCombo->setOptions( CYTSecureUtils::getTiposInvestigadorItems(CYT_TIPO_INVESTIGADOR_MOSTRADOS) );*/
        
		
		$this->getForm()->addHidden(FieldBuilder::buildInputHidden ( "hiddenApellido", ""));
        $xtpl->assign('formulario', $this->getForm()->show() );
        
    }

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$oUser = CdtSecureUtils::getUserLogged();
		if ((date('Y-m-d H:i:s')>CYT_FECHA_CIERRE)&&(!CdtSecureUtils::hasPermission ( $oUser, CYT_FUNCTION_LISTAR_ESTADO ))) {
			throw new GenericException( CYT_MSG_FIN_PERIODO_ALTAS );
		}
		$oIntegrante = new Integrante();
		
		$filter = new CMPIntegranteFilter();
		$filter->fillSavedProperties();
		$oIntegrante->setProyecto($filter->getProyecto());
		
		return $oIntegrante;
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_INTEGRANTE_TITLE_ADD;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "add_integrante";
	}


}
