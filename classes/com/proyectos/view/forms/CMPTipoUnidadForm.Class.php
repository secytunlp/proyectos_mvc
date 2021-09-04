<?php

/**
 * Formulario para TipoUnidad
 *
 * @author Marcos
 * @since 17-10-2013
 */
class CMPTipoUnidadForm extends CMPForm{

	/**
	 * se construye el formulario para editar el tipo de título
	 */
	public function __construct($action="", $id="edit_tipoUnidad") {

		parent::__construct($id);

		$fieldset = new FormFieldset( "" );
		$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CDT_ENTITIES_LBL_ENTITY_OID, "oid", ""  ) );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_TIPO_Unidad_NOMBRE, "nombre", CYT_MSG_TIPO_Unidad_NOMBRE_REQUIRED ) );

		$this->addFieldset($fieldset);

		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );

		//properties del form.
		$this->addProperty("method", "POST");
		$this->setAction("doAction?action=$action");
		$this->setOnCancel("window.location.href = 'doAction?action=list_tiposUnidad';");
		$this->setUseAjaxSubmit( true );
		//$this->setOnSuccessCallback("successTest");
		//$this->setUseAjaxCallback( true );
		//$this->setIdAjaxCallback( "content-left" );
	}

}
?>
