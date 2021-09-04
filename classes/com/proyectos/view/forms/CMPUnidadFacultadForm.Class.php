<?php

/**
 * Formulario para facultad de unidad
 *  
 * @author Marcos
 * @since 21-10-2013
 */
class CMPUnidadFacultadForm extends CMPForm{


	public function getLegend(){
		return CYT_MSG_UNIDAD_FACULTAD_ASIGNAR;
		
	}
	
	/**
	 * se construye el formulario para editar un registro de encomienda
	 */
	public function __construct($action="add_unidad_facultad_session",$id="edit_unidadfacultad") {

		parent::__construct($id, CYT_MSG_ASIGNAR);
		
		$this->setCancelLabel( null );
		
		//properties del form.
    	$this->addProperty("method", "POST");
		$this->setAction("doAction?action=$action");
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );
		
		$this->setUseAjaxSubmit( true );
		
		$this->getRenderer()->setTemplateName( CDT_CMP_TEMPLATE_FORM_INLINE );
		
		$this->setOnSuccessCallback("add_facultad");
		$this->setBeforeSubmit("before_submit_facultad");
		

		$fieldset = new FormFieldset( $this->getLegend() );
		
		
		$fieldFacultad = FieldBuilder::buildFieldSelect (CYT_LBL_FACULTAD, "facultad.oid", CYTSecureUtils::getFacultadesItems(), CYT_MSG_UNIDAD_FACULTAD_FACULTAD_REQUIRED, null, null, "--seleccionar--" );
		
		$fieldset->addField( $fieldFacultad );
		
		$this->addFieldset($fieldset);
		
    }
    
}
?>
