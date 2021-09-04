<?php

/**
 * Formulario para RechazarSolicitud
 *
 * @author Marcos
 * @since 18-11-2016
 */
class CMPDenySolicitudForm extends CMPForm{

	/**
	 * se construye el formulario para editar el registro
	 */
	public function __construct($action="", $id="edit_rechazarSolicitud") {

		parent::__construct($id);

		$fieldset = new FormFieldset( "" );
		//$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CDT_ENTITIES_LBL_ENTITY_OID, "oid", ""  ) );
		
			
		$findIntegrante = CYTComponentsFactory::getFindIntegrante(new Integrante(), CYT_LBL_INTEGRANTE, "", "integranteEstado_filter_integrante_oid", "integrante.oid", "");
		//$findIntegrante->getInput()->setInputSize(5,80);
		$findIntegrante->getInput()->setIsEditable(false);
		$fieldset->addField( $findIntegrante );
		
		$fieldEstado = FieldBuilder::buildFieldSelect (CYT_LBL_ESTADO, "estado.oid", CYTUtils::getEstadoIntegranteItems(), CYT_MSG_SOLICITUD_ESTADO_ESTADO_REQUIRED, null, null, "--seleccionar--" );
		$fieldEstado->getInput()->setIsEditable(false);
		$fieldset->addField( $fieldEstado );
		
		$fieldTipoIntegrante = FieldBuilder::buildFieldSelect (CYT_LBL_TIPO_INTEGRANTE, "tipoIntegrante.oid", CYTSecureUtils::getTiposInvestigadorItems(), CYT_MSG_INTEGRANTE_TIPO_INTEGRANTE_REQUIRED, null, null, "--seleccionar--", "tipoIntegrante_oid" );
		//$fieldTipoIntegrante->getInput()->addProperty( 'onChange', 'seleccionarTipo(this)' );
		$fieldTipoIntegrante->getInput()->setIsEditable(false);
		$fieldset->addField( $fieldTipoIntegrante );
		
		$fieldset->addField( FieldBuilder::buildFieldTextArea ( CYT_MSG_SOLICITUD_RECHAZAR_MOTIVOS, "observaciones", CYT_MSG_SOLICITUD_RECHAZAR_MOTIVOS_REQUIRED  ) );
		
		
		$this->addFieldset($fieldset);
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );

		//properties del form.
		$this->addProperty("method", "POST");
		$this->setAction("doAction?action=$action");
		
		$cancel = 'doAction?action=list_integrantes';	
		
		$this->setOnCancel("window.location.href = '$cancel';");
		$this->setUseAjaxSubmit( true );
		//$this->setOnSuccessCallback("successTest");
		//$this->setUseAjaxCallback( true );
		//$this->setIdAjaxCallback( "content-left" );
	}

}
?>
