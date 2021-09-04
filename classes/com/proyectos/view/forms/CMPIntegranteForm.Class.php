<?php

/**
 * Formulario para Integrante
 *
 * @author Marcos
 * @since 30-10-2013
 */
class CMPIntegranteForm extends CMPForm{
	
	public function getRenderer(){
		return new CMPIntegranteFormRenderer();
	}

	/**
	 * se construye el formulario para editar el integrante
	 */
	public function __construct($action="", $id="edit_integrante") {

		parent::__construct($id);

		$fieldset = new FormFieldset( "" );
		$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CDT_ENTITIES_LBL_ENTITY_OID, "oid", ""  ) );
		
		$findProyecto = CYTComponentsFactory::getFindProyecto(new Proyecto(), CYT_LBL_PROYECTO, "", "integrante_form_proyecto_oid", "proyecto.oid", "integrante_filter_proyecto_change");
		$findProyecto->getInput()->setInputSize(5,80);
		$findProyecto->getInput()->setIsEditable(false);
		
		
		$fieldset->addField( $findProyecto );
		
		$fieldTipoIntegrante = FieldBuilder::buildFieldSelect (CYT_LBL_TIPO_INTEGRANTE, "tipoIntegrante.oid", CYTSecureUtils::getTiposInvestigadorItems(CYT_TIPO_INVESTIGADOR_MOSTRADOS), CYT_MSG_INTEGRANTE_TIPO_INTEGRANTE_REQUIRED, null, null, "--seleccionar--", "tipoIntegrante_oid" );
		$fieldTipoIntegrante->getInput()->addProperty( 'onChange', 'seleccionarTipo(this)' );
		$fieldset->addField( $fieldTipoIntegrante );
		
		//$fieldApellido = FieldBuilder::buildFieldText ( CYT_LBL_INTEGRANTE_APELLIDO, "apellido", CYT_MSG_INTEGRANTE_APELLIDO_REQUIRED  );
		$fieldApellido = FieldBuilder::buildFieldEntityAutocomplete(CYT_LBL_INTEGRANTE_APELLIDO, new CMPDocenteAutocomplete(),"ds_apellido",CYT_MSG_INTEGRANTE_APELLIDO_REQUIRED);
		
		$fieldset->addField( $fieldApellido );
		
		
		
		
		$fieldNombre = FieldBuilder::buildFieldText ( CYT_LBL_INTEGRANTE_NOMBRE, "ds_nombre", CYT_MSG_INTEGRANTE_NOMBRE_REQUIRED  );
		//$fieldNombre->getInput()->addProperty("maxlength", 100);
		$fieldset->addField( $fieldNombre );
		
		$fieldCUIL = FieldBuilder::buildFieldText ( CYT_LBL_INTEGRANTE_CUIL, "cuil", CYT_MSG_INTEGRANTE_CUIL_REQUIRED  );
		$fieldCUIL->getInput()->addProperty("maxlength", 13);
		$fieldCUIL->getInput()->addProperty("size", 13);
		$fieldset->addField( $fieldCUIL );
		

		
		$fieldset->addField( FieldBuilder::buildFieldEmail ( CYT_LBL_DOCENTE_MAIL, "ds_mail", CYT_MSG_INTEGRANTE_MAIL_REQUIRED,"",40) );
		
		$fieldCargo = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_CARGO, "cargo.oid", CYTSecureUtils::getCargosItems(CYT_CARGOS_MOSTRADOS), "", null, null, "--seleccionar--", "cargo_oid" );
		$fieldset->addField( $fieldCargo );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_FECHA_CARGO, "dt_cargo") ;
		
		$fieldset->addField( $field );
		
		
	
	  	$fieldDeddoc = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_DEDDOC, "deddoc.oid", CYTSecureUtils::getDeddocsItems(CYT_DEDDOC_MOSTRADAS), "", null, null, "--seleccionar--", "deddoc_oid" );
		//$fieldDeddoc->getInput()->setIsEditable(false);
	  	$fieldset->addField( $fieldDeddoc );
	
	  	$fieldFacultad = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_FACULTAD, "facultad.oid", CYTSecureUtils::getFacultadesItems(), "", null, null, "--seleccionar--", "facultad_oid" );
		$fieldset->addField( $fieldFacultad );
		
		$findPais = CYTSecureComponentsFactory::getFindUniversidad(new Universidad(), CYT_LBL_TITULO_UNIVERSIDAD, CYT_MSG_TITULO_UNIVERSIDAD_REQUIRED, "integrante_filter_universidad_oid", "universidad.oid", "integrante_filter_universidad_change");
		$findPais->getInput()->setInputSize(5,70);
		$fieldset->addField( $findPais );
		
		
		$fieldCategoria = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_CATEGORIA, "categoria.oid", CYTSecureUtils::getCategoriasItems(CYT_CATEGORIA_MOSTRADAS), "", null, null, "--seleccionar--", "categoria_oid" );
		$fieldCategoria->getInput()->setIsEditable(false);
		$fieldset->addField( $fieldCategoria );
		
		
		
		$fieldCarrerainv = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_CARRERAINV, "carrerainv.oid", CYTSecureUtils::getCarrerainvsItems(CYT_CARRERAINV_MOSTRADAS), "", null, null, "--seleccionar--", "carrerainv_oid" );
		$fieldset->addField( $fieldCarrerainv );
		
		$fieldOrganismo = FieldBuilder::buildFieldSelect (CYT_LBL_INTEGRANTE_ORGANISMO, "organismo.oid", CYTSecureUtils::getOrganismosItems(CYT_ORGANISMO_MOSTRADAS), "", null, null, "--seleccionar--", "organismo_oid" );
		$fieldset->addField( $fieldOrganismo );
		
		/*$fieldBeca = FieldBuilder::buildFieldText ( CYT_LBL_INTEGRANTE_INSTITUCION_BECA, "ds_orgbeca", ""  );
		//$fieldBeca->getInput()->addProperty("maxlength", 13);
		$fieldBeca->getInput()->addProperty("size", 60);
		$fieldset->addField( $fieldBeca );*/
		
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
		
	
		$findLugarTrabajo = CYTSecureComponentsFactory::getFindLugarTrabajo(new LugarTrabajo(), CYT_LBL_INTEGRANTE_LUGAR_TRABAJO, CYT_MSG_INTEGRANTE_LUGAR_TRABAJO_REQUIRED, "integrante_filter_lugarTrabajo_oid", "unidad.oid","integrante_filter_lugarTrabajo_change");
		$findLugarTrabajo->getInput()->setInputSize(5,80);
		$fieldset->addField( $findLugarTrabajo );
	
	  	$fieldBeca = FieldBuilder::buildFieldNumber ( CYT_LBL_INTEGRANTE_HORAS, "nu_horasinv", CYT_MSG_INTEGRANTE_HORAS_REQUIRED  );
		$fieldBeca->getInput()->addProperty("size", 5);
		$fieldset->addField( $fieldBeca );
		
		$fieldTitulo = CYTSecureComponentsFactory::getFindTituloWithAdd(new Titulo(), CYT_LBL_DOCENTE_TITULO_GRADO, "", "integrante_filter_titulo_oid", "titulo.oid","integrante_filter_titulo_change");
		$fieldTitulo->getInput()->setInputSize(5,70);
		$fieldset->addField( $fieldTitulo );
		
		$fieldTitulo = CYTSecureComponentsFactory::getFindTituloPosgradoWithAdd(new Titulo(), CYT_LBL_DOCENTE_TITULO_POSGRADO, "", "integrante_filter_titulopost_oid", "titulopost.oid","integrante_filter_titulopost_change");
		$fieldTitulo->getInput()->setInputSize(5,70);
		$fieldset->addField( $fieldTitulo );
		
		$field = FieldBuilder::buildFieldNumber ( CYT_LBL_INTEGRANTE_MATERIAS, "nu_materias") ;
		//$field->getInput()->setIsVisible(false);
		$fieldset->addField( $field );
		
		$fieldset->addField( FieldBuilder::buildFieldCheckbox ( CYT_LBL_INTEGRANTE_BL_BECA_ESTIMULO, "bl_becaEstimulo", "bl_becaEstimulo") );
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_FECHA_BECA, "dt_becaEstimulo") ;
		
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_INTEGRANTE_FECHA_BECA_HASTA, "dt_becaEstimuloHasta") ;
		
		$fieldset->addField( $field );
	
		//$fieldset->addField( FieldBuilder::buildFieldTextArea ( CYT_LBL_UNIDAD_OBSERVACIONES, "observaciones","","",4,100) );
		
		$this->addFieldset($fieldset);

		//$this->addHidden( FieldBuilder::buildInputHidden ( "deddoc.oid", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "categoria.oid", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "proyecto.oid", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_curriculum", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_actividades", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_resolucionBeca", "") );
		

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
