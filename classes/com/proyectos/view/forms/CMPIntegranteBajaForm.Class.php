<?php

/**
 * Formulario para Baja de Integrante
 *
 * @author Marcos
 * @since 22-11-2016
 */
class CMPIntegranteBajaForm extends CMPForm{
	
	public function getRenderer(){
		return new CMPIntegranteBajaFormRenderer();
	}

	/**
	 * se construye el formulario para editar el integrante
	 */
	public function __construct($action="", $id="baja_integrante") {

		parent::__construct($id);

		$fieldset = new FormFieldset( "" );
		$fieldset->setLegend(CYT_LBL_INTEGRANTE_BAJA_LEGEND);
		$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CDT_ENTITIES_LBL_ENTITY_OID, "oid", ""  ) );
		
		$findProyecto = CYTComponentsFactory::getFindProyecto(new Proyecto(), CYT_LBL_PROYECTO, "", "integrante_form_proyecto_oid", "proyecto.oid", "integrante_filter_proyecto_change");
		$findProyecto->getInput()->setInputSize(5,80);
		$findProyecto->getInput()->setIsEditable(false);
		
		
		$fieldset->addField( $findProyecto );
		
		$fieldApellido = FieldBuilder::buildFieldText ( CYT_LBL_INTEGRANTE, "ds_apellido"  );
		$fieldApellido->getInput()->setIsEditable(false);
		
		$fieldset->addField( $fieldApellido );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_FECHA_BAJA, "dt_baja",CYT_MSG_INTEGRANTE_FECHA_BAJA_REQUIRED) ;
		
		$fieldset->addField( $field );
		
		
		
	
		$fieldset->addField( FieldBuilder::buildFieldTextArea ( CYT_LBL_INTEGRANTE_BAJA_CONSECUENCIAS, "ds_consecuencias",CYT_MSG_INTEGRANTE_CONSECUENCIAS_REQUIRED,"",4,100) );
		
		
		
		$fieldset->addField( FieldBuilder::buildFieldTextArea ( CYT_LBL_INTEGRANTE_BAJA_MOTIVOS, "ds_motivos",CYT_MSG_INTEGRANTE_MOTIVOS_REQUIRED,"",4,100) );
		
		$this->addFieldset($fieldset);
		
		$msg = CYT_LBL_INTEGRANTE_BAJA_MIN_CATEGORIZADOS;
    	$params = array (CYT_MIN_CATEGORIZADOS);			
		$fieldset->addField( FieldBuilder::buildFieldCheckbox ( CdtFormatUtils::formatMessage( $msg, $params ), "bl_mincategorizados", "bl_mincategorizados") );
		
		$msg = CYT_LBL_INTEGRANTE_BAJA_MIN_MAYOR_DEDICACION;
    	$params = array (CYT_MIN_MAYOR_DEDICACION);			
		$fieldset->addField( FieldBuilder::buildFieldCheckbox ( CdtFormatUtils::formatMessage( $msg, $params ), "bl_minmayordedicacion", "bl_minmayordedicacion") );

		
		$this->addHidden( FieldBuilder::buildInputHidden ( "proyecto.oid", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );
		
		

		//properties del form.
		$this->addProperty("method", "POST");
		$this->setAction("doAction?action=$action");
		$this->setOnCancel("window.location.href = 'doAction?action=list_integrantes';");
		$this->setUseAjaxSubmit( true );
		//$this->setOnSuccessCallback("successTest");
		//$this->setUseAjaxCallback( true );
		//$this->setIdAjaxCallback( "content-left" );
	}

}
?>
