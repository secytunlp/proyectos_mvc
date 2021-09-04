<?php

/**
 * Acción para visualizar un integrante.
 *
 * @author Marcos
 * @since 05-11-2013
 *
 */
class ViewIntegranteAction extends UpdateIntegranteInitAction {



	protected function parseEntity($entity, XTemplate $xtpl) {

		$this->getForm()->setIsEditable( false );

		parent::parseEntity($entity, $xtpl);
		
		$xtpl->assign('fechaUltModificacion_label', CYT_LBL_INTEGRANTE_FECHA_ULTIMA_MODIFICACION);
		$xtpl->assign('input_fechaUltModificacion', 'fechaUltModificacion');
		$xtpl->assign('fechaUltModificacion_value', CYTSecureUtils::formatDateTimeToView($entity->getFechaUltModificacion()));
		$xtpl->assign('usuario_label', CYT_LBL_INTEGRANTE_USUARIO_ULTIMA_MODIFICACION);
		$xtpl->assign('input_usuario', 'user_oid');
		$xtpl->assign('usuario_value', $entity->getUser()->getDs_username());
		
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtOutputAction::getLayout();
	 */
	protected function getLayout() {
		$oLayout = new CdtLayoutBasicAjax();
		return $oLayout;
	}


	/**
	 * (non-PHPdoc)
	 * @see CdtOutputAction::getOutputTitle();
	 */
	protected function getOutputTitle() {
		return CYT_MSG_INTEGRANTE_TITLE_VIEW;
	}

	/**
     * (non-PHPdoc)
     * @see CdtEditInitAction::getXTemplate();
     */
    protected function getXTemplate() {
        return new XTemplate(CYT_TEMPLATE_INTEGRANTE_VIEW);
    }	
}