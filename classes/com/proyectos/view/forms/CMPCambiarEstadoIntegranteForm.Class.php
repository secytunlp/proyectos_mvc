<?php

/**
 * Formulario para CambiarEstadoIntegrante
 *
 * @author Marcos
 * @since 18-11-2016
 */
class CMPCambiarEstadoIntegranteForm extends CMPForm{

	/**
	 * se construye el formulario para editar el registro
	 */
	public function __construct($action="", $id="edit_cambiarEstadoIntegrante") {

		parent::__construct($id);

		$fieldset = new FormFieldset( "" );
		//$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CDT_ENTITIES_LBL_ENTITY_OID, "oid", ""  ) );
		
			
		$findIntegrante = CYTComponentsFactory::getFindIntegrante(new Integrante(), CYT_LBL_INTEGRANTE, "", "integranteEstado_filter_integrante_oid", "integrante.oid", "");
		//$findIntegrante->getInput()->setInputSize(5,80);
		$fieldset->addField( $findIntegrante );
		
		$fieldEstado = FieldBuilder::buildFieldSelect (CYT_LBL_ESTADO, "estado.oid", CYTUtils::getEstadoIntegranteItems(), CYT_MSG_SOLICITUD_ESTADO_ESTADO_REQUIRED, null, null, "--seleccionar--" );
		$fieldset->addField( $fieldEstado );
		
		$fieldTipoIntegrante = FieldBuilder::buildFieldSelect (CYT_LBL_TIPO_INTEGRANTE, "tipoIntegrante.oid", CYTSecureUtils::getTiposInvestigadorItems(), CYT_MSG_INTEGRANTE_TIPO_INTEGRANTE_REQUIRED, null, null, "--seleccionar--", "tipoIntegrante_oid" );
		//$fieldTipoIntegrante->getInput()->addProperty( 'onChange', 'seleccionarTipo(this)' );
		$fieldset->addField( $fieldTipoIntegrante );
		
		$fieldCargo = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_CARGO, "cargo.oid", CYTSecureUtils::getCargosItems(CYT_CARGOS_MOSTRADOS), "", null, null, "--seleccionar--", "cargo_oid" );
		$fieldset->addField( $fieldCargo );
		
		$fieldDeddoc = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_DEDDOC, "deddoc.oid", CYTSecureUtils::getDeddocsItems(CYT_DEDDOC_MOSTRADAS), "", null, null, "--seleccionar--", "deddoc_oid" );
		//$fieldDeddoc->getInput()->setIsEditable(false);
	  	$fieldset->addField( $fieldDeddoc );
	  	
	  	$fieldFacultad = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_FACULTAD, "facultad.oid", CYTSecureUtils::getFacultadesItems(), "", null, null, "--seleccionar--", "facultad_oid" );
		$fieldset->addField( $fieldFacultad );
		
		$fieldCategoria = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_CATEGORIA, "categoria.oid", CYTSecureUtils::getCategoriasItems(CYT_CATEGORIA_MOSTRADAS), "", null, null, "--seleccionar--", "categoria_oid" );
		//$fieldCategoria->getInput()->setIsEditable(false);
		$fieldset->addField( $fieldCategoria );
		
		
		
	
		
		
		
		$fieldCarrerainv = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_CARRERAINV, "carrerainv.oid", CYTSecureUtils::getCarrerainvsItems(CYT_CARRERAINV_MOSTRADAS), "", null, null, "--seleccionar--", "carrerainv_oid" );
		$fieldset->addField( $fieldCarrerainv );
		
		$fieldOrganismo = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_ORGANISMO, "organismo.oid", CYTSecureUtils::getOrganismosItems(CYT_ORGANISMO_MOSTRADAS), "", null, null, "--seleccionar--", "organismo_oid" );
		$fieldset->addField( $fieldOrganismo );
		
		
		
	
		$fieldBeca = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_INSTITUCION_BECA, "ds_orgbeca", Institucion::getItems(), "", null, null, "--seleccionar--" );
		$fieldBeca->getInput()->addProperty( 'onChange', 'seleccionarInstitucion(this)' );
		$fieldset->addField( $fieldBeca );
		
		$fieldBeca = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_TIPO_BECA, "ds_tipobeca", Tipobeca::getItems(), "", null, null);
		//print_r($fieldBeca);
		$fieldset->addField( $fieldBeca );
		
	
		
	
		
		
		
		
		
		
		
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_FECHA_BECA, "dt_beca") ;
		
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_FECHA_BECA_HASTA, "dt_becaHasta") ;
		
		$fieldset->addField( $field );
		
	
		
		
		$fieldset->addField( FieldBuilder::buildFieldCheckbox ( CYT_LBL_INTEGRANTE_BL_BECA_ESTIMULO, "bl_becaEstimulo", "bl_becaEstimulo") );
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_FECHA_BECA, "dt_becaEstimulo") ;
		
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_FECHA_BECA_HASTA, "dt_becaEstimuloHasta") ;
		
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_ALTA, "dt_alta") ;
		
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_BAJA, "dt_baja") ;
		
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_DT_CAMBIO, "dt_cambio") ;
		
		$fieldset->addField( $field );
		
		$fieldBeca = FieldBuilder::buildFieldNumber ( CYT_LBL_INTEGRANTE_HORAS, "nu_horasinv"  );
		$fieldBeca->getInput()->addProperty("size", 5);
		$fieldset->addField( $fieldBeca );
		
		$fieldset->addField( FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_ESTADO_MOTIVO, "motivo"  ) );
		
		
		$this->addFieldset($fieldset);
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );

		//properties del form.
		$this->addProperty("method", "POST");
		$this->setAction("doAction?action=$action");
		
		$cancel = 'doAction?action=list_integrantesEstado';	
		
		$this->setOnCancel("window.location.href = '$cancel';");
		$this->setUseAjaxSubmit( true );
		//$this->setOnSuccessCallback("successTest");
		//$this->setUseAjaxCallback( true );
		//$this->setIdAjaxCallback( "content-left" );
	}

}
?>
