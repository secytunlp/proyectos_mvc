<?php

/**
 * Acción para inicializar el contexto
 * para editar un integrante.
 *
 * @author Marcos
 * @since 10-06-2022
 *
 */

class AddDocenteInitAction extends EditEntityInitAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		
		
		

		return new CMPDocenteForm($action);
		
	}
	
	/**
     * (non-PHPdoc)
     * @see CdtEditInitAction::parseEntity();
     */
    protected function parseEntity($entity, XTemplate $xtpl) {

        $entity = CdtFormatUtils::ifEmpty($entity, $this->getNewEntityInstance());

        $this->getForm()->fillInputValues($entity);
        

        $xtpl->assign('formulario', $this->getForm()->show() );
        
    }

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$oUser = CdtSecureUtils::getUserLogged();
		if (!CdtSecureUtils::hasPermission ( $oUser, CYT_FUNCTION_LISTAR_ESTADO )) {
			throw new GenericException( CYT_MSG_FIN_PERIODO_ALTAS );
		}
		$oDocente = new Docente();
		
		$filter = new CMPDocenteFilter();
		$filter->fillSavedProperties();
		
		return $oDocente;
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_DOCENTE_TITLE_ADD;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "add_docente";
	}


}
