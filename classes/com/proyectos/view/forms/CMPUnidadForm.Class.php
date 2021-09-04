<?php

/**
 * Formulario para Unidad
 *
 * @author Marcos
 * @since 21-10-2013
 */
class CMPUnidadForm extends CMPForm{

	
	public function getRenderer(){
		return new CMPUnidadFormRenderer();
	}
	
	/**
	 * se construye el formulario para editar el encomienda
	 */
	public function __construct($action="", $id="edit_unidad") {

		parent::__construct($id);

		$fieldset = new FormFieldset( "" );
		$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CDT_ENTITIES_LBL_ENTITY_OID, "oid", ""  ) );
		
		
		
		
		$fieldTipoUnidad = FieldBuilder::buildFieldSelect (CYT_LBL_TIPO_UNIDAD, "tipoUnidad.oid", CYTUtils::getTiposUnidadItems(), CYT_MSG_UNIDAD_TIPO_UNIDAD_REQUIRED, null, null, "--seleccionar--", "tipoUnidad_oid" );
		
		$fieldset->addField( $fieldTipoUnidad );
		
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_UNIDAD_DENOMINACION, "denominacion", CYT_MSG_UNIDAD_DENOMINACION_REQUIRED,"",80) );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_UNIDAD_ESPECIALIDAD, "especialidad", CYT_MSG_UNIDAD_ESPECIALIDAD_REQUIRED,"",80) );
		
		$fieldset->addField( FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_OBSERVACIONES, "observaciones","","",4,80) );
		
		
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_OBJETIVOS, "objetivos", CYT_MSG_UNIDAD_OBJETIVOS_REQUIRED);
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_LINEAS, "lineas", CYT_MSG_UNIDAD_LINEAS_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_JUSTIFICACION, "justificacion", CYT_MSG_UNIDAD_JUSTIFICACION_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_PRODUCCION, "produccion", CYT_MSG_UNIDAD_PRODUCCION_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_PROYECTOS, "proyectos", CYT_MSG_UNIDAD_PROYECTOS_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_RRHH, "rrhh", CYT_MSG_UNIDAD_RRHH_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_FUNCIONES, "funciones", CYT_MSG_UNIDAD_FUNCIONES_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_REGLAMENTO, "reglamento", CYT_MSG_UNIDAD_REGLAMENTO_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_INFRAESTRUCTURA, "infraestructura", CYT_MSG_UNIDAD_INFRAESTRUCTURA_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_EQUIPAMIENTO, "equipamiento", CYT_MSG_UNIDAD_EQUIPAMIENTO_REQUIRED) ;
		$input->getInput()->setIsFilter(false);
		$fieldset->addField( $input );
		
		$this->addFieldset($fieldset);
	
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );

		//properties del form.
		$this->addProperty("method", "POST");
		$this->setAction("doAction?action=$action");
		$this->setOnCancel("window.location.href = 'doAction?action=list_unidades';");
		$this->setUseAjaxSubmit( true );
		//$this->setOnSuccessCallback("successTest");
		//$this->setUseAjaxCallback( true );
		//$this->setIdAjaxCallback( "content-left" );
	}

}
?>
