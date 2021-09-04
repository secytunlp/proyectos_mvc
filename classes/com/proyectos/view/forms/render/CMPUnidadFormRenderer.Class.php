<?php

/**
 * Implementación para renderizar un formulario de unidad 
 *
 * @author Marcos
 * @since 21-10-2013
 *
 */
class CMPUnidadFormRenderer extends DefaultFormRenderer {

	 protected function getXTemplate() {
    	return new XTemplate( CYT_TEMPLATE_UNIDAD_FORM );
    }
	
	
	protected function renderFieldset(CMPForm $form, XTemplate $xtpl){

		foreach ($form->getFieldsets() as $fieldset) {
			
			//legend
			$legend = $fieldset->getLegend();
			if(!empty($legend)){
				$xtpl->assign("value", $legend);
				$xtpl->parse("main.fieldset.legend");
			}
			
			
			$fields = $fieldset->getFields();
			$fieldOid = $fields['oid'];		
			$input = $fieldOid->getInput();
			$label = $fieldOid->getLabel();	
			$this->renderLabel( $label, $input, $xtpl );
			$this->renderInput( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldOid->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.fieldset.column.oid");
			$fieldTipoUnidad = $fields['tipoUnidad_oid'];		
			$input = $fieldTipoUnidad->getInput();
			$label = $fieldTipoUnidad->getLabel();	
			$this->renderLabel( $label, $input, $xtpl );
			$this->renderInput( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldTipoUnidad->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.fieldset.column.tipoUnidad_oid");
			$fieldDenominacion = $fields['denominacion'];		
			$input = $fieldDenominacion->getInput();
			$label = $fieldDenominacion->getLabel();	
			$this->renderLabel( $label, $input, $xtpl );
			$this->renderInput( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldDenominacion->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.fieldset.column.denominacion");
			
			$fieldEspecialidad = $fields['especialidad'];		
			$input = $fieldEspecialidad->getInput();
			$label = $fieldEspecialidad->getLabel();	
			$this->renderLabel( $label, $input, $xtpl );
			$this->renderInput( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldEspecialidad->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.fieldset.column.especialidad");
			
			$fieldObservaciones = $fields['observaciones'];		
			$input = $fieldObservaciones->getInput();
			$label = $fieldObservaciones->getLabel();	
			$this->renderLabel( $label, $input, $xtpl );
			$this->renderInput( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObservaciones->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.fieldset.column.observaciones");
			
			$xtpl->parse("main.fieldset.column");
			
			
			
			$xtpl->parse("main.fieldset");
			$xtpl->assign("finalidad_tab", CYT_MSG_UNIDAD_FINALIDAD);
			$fieldObjetivos = $fields['objetivos'];		
			$input = $fieldObjetivos->getInput();
			$label = $fieldObjetivos->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivos->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.objetivos");
			$fieldLineas = $fields['lineas'];		
			$input = $fieldLineas->getInput();
			$label = $fieldLineas->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldLineas->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.lineas");
			$fieldJustificacion = $fields['justificacion'];		
			$input = $fieldJustificacion->getInput();
			$label = $fieldJustificacion->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldJustificacion->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.justificacion");
			$xtpl->assign("antecedentes_tab", CYT_MSG_UNIDAD_ANTECEDENTES);
			$fieldProduccion = $fields['produccion'];		
			$input = $fieldProduccion->getInput();
			$label = $fieldProduccion->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldProduccion->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.produccion");
			$fieldProyectos = $fields['proyectos'];		
			$input = $fieldProyectos->getInput();
			$label = $fieldProyectos->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldProyectos->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.proyectos");
			$fieldRrhh = $fields['rrhh'];		
			$input = $fieldRrhh->getInput();
			$label = $fieldRrhh->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldRrhh->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.rrhh");
			$xtpl->assign("funciones_tab", CYT_MSG_UNIDAD_FUNCIONES);
			$fieldFunciones = $fields['funciones'];		
			$input = $fieldFunciones->getInput();
			$label = $fieldFunciones->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldFunciones->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.funciones");
			$fieldReglamento = $fields['reglamento'];		
			$input = $fieldReglamento->getInput();
			$label = $fieldReglamento->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldReglamento->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.reglamento");
			$fieldInfraestructura = $fields['infraestructura'];		
			$input = $fieldInfraestructura->getInput();
			$label = $fieldInfraestructura->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldInfraestructura->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.infraestructura");
			$fieldEquipamiento = $fields['equipamiento'];		
			$input = $fieldEquipamiento->getInput();
			$label = $fieldEquipamiento->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldEquipamiento->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.equipamiento");
			
			
		} 
	}

	
	protected function renderLabel( $label, CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("value", $label );
		
		if( $input->getIsRequired() && $input->getIsEditable() ){
			$xtpl->assign("required", $input->getRequiredLabel() );
		}else{
			$xtpl->assign("required", "" );
		}
		
		$xtpl->assign("input_name", $input->getId() );
		$xtpl->parse("main.fieldset.column.".$input->getId().".label");
	}
	
	protected function renderInput( CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("input", $input->show() );
		
		$xtpl->parse("main.fieldset.column.".$input->getId().".input");
		
	}
	
	protected function renderLabelTab( $label, CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("value", $label );
		
		if( $input->getIsRequired() && $input->getIsEditable() ){
			$xtpl->assign("required", $input->getRequiredLabel() );
		}else{
			$xtpl->assign("required", "" );
		}
		
		$xtpl->assign("input_name", $input->getId() );
		$xtpl->parse("main.".$input->getId().".label");
	}
	
	protected function renderInputTab( CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("input", $input->show() );
		
		$xtpl->parse("main.".$input->getId().".input");
		
	}
	
	protected function renderCustom(CMPForm $form, XTemplate $xtpl){
		
		
		//renderizamos las relaciones con sus formularios de alta
		
		$xtpl_relaciones = new XTemplate( CYT_TEMPLATE_UNIDAD_EDIT_UNIDAD_RELACIONES );
		
		//facultades
		$facultadesHTML = $this->getHTMLFacultades($form);
		$xtpl_relaciones->assign( "facultades_tab", CYT_LBL_UNIDAD_FACULTADES );
		$xtpl_relaciones->assign( "facultades", $facultadesHTML );
		
		
		
		$xtpl_relaciones->parse("main");
		
		
		
		$xtpl->assign( "customHTML", $xtpl_relaciones->text("main"));
	}	
	
	

	
	/**
	 * renderizamos en el formulario de unidad las facultades que tiene asignados.
	 * También agregamos un formulario para asignar nuevos registros.
	 *
	 * @param CMPForm $form
	 * @param XTemplate $xtpl
	 */
	protected function getHTMLFacultades(CMPForm $form){
	
		$xtpl_facultades = new XTemplate( CYT_TEMPLATE_UNIDAD_EDIT_FACULTADES );
	
		//mostrar las facultades actuales.
		$xtpl_facultades->assign('facultades_title', CYT_MSG_UNIDAD_FACULTAD );
	
		//TODO parsear labels.
		$this->parseFacultadesLabels($xtpl_facultades);
		 
		//recuperamos las facultades de la unidad desde la sesión.
		$manager = new UnidadFacultadSessionManager();
		$facultades = $manager->getEntities( new CdtSearchCriteria() );
		 
		//parseamos los facultades.
		$this->parseFacultades($facultades, $form, $xtpl_facultades);
		 
		//formulario para agregar un nuevo registro a la unidad.
		if( $form->getIsEditable() ){
			$facultadForm = new CMPUnidadFacultadForm();
			$xtpl_facultades->assign('formulario', $facultadForm->show() );
		}
		$xtpl_facultades->parse("main");
	
		return $xtpl_facultades->text("main");
	
	}
	
	/**
	 * armamos un array con los datos de la facultad.
	 * @param UnidadFacultad $facultad
	 */
	public function buildArrayFacultad(UnidadFacultad $unidadFacultad){
	
		$array_facultad = array();
	
		$array_facultad["item_oid"] = $unidadFacultad->getFacultad()->getOid();
		
		
		$managerFacultad =  CYTSecureManagerFactory::getFacultadManager();
		$oFacultad = $managerFacultad->getObjectByCode($unidadFacultad->getFacultad()->getOid());
		
		
		$array_facultad["facultad"] = $oFacultad->getDs_facultad();
	
		return $array_facultad;
	
	}
	/**
	 * columnas para el listado de facultades
	 * @return multitype:string
	 */
	public function getFacultadColumns(){
		return array( "facultad");
	}
	
	/**
	 * labels para el listado de facultades
	 * @return multitype:string
	 */
	public function getFacultadColumnsLabels(){
		return array( CYT_LBL_UNIDAD_FACULTADES_FACULTAD);
	}
	
	/**
	 * aligns para las columnas del listado de facultades.
	 * @return multitype:string
	 */
	public function getFacultadColumnsAlign(){
		return array( "left");
	}
		
	/**
	 * parseamos los labels para el listado de facultades.
	 * @param XTemplate $xtpl_facultades
	 */
	protected function parseFacultadesLabels(XTemplate $xtpl_facultades){
	
		$aligns = $this->getFacultadColumnsAlign();
	
		$index=0;
		foreach ( $this->getFacultadColumnsLabels() as $label) {
	
			$xtpl_facultades->assign('facultad_label', $label );
			$xtpl_facultades->assign('align', $aligns[$index]);
			$xtpl_facultades->parse('main.facultad_th');
	
			$index++;
		}
	}
	
	
	/**
	 * parseamos el listado de facultades.
	 * @param ItemCollection $facultades
	 * @param CMPForm $form
	 * @param XTemplate $xtpl_facultades
	 */
	protected function parseFacultades(ItemCollection $facultades=null, CMPForm $form, XTemplate $xtpl_facultades){
	
		if( $facultades!= null ){
			foreach ($facultades as $facultad) {
				 
				$this->parseFacultad($facultad, $xtpl_facultades);
				 
				if( $form->getIsEditable() ){
					$xtpl_facultades->assign('item_oid', $facultad->getFacultad()->getOid() );
					$xtpl_facultades->parse("main.facultad.editar_facultad");
				}
				 
				$xtpl_facultades->parse("main.facultad");
			}
		}
	}
	
	/**
	 * parseamos un facultad.
	 * @param UnidadFacultad $facultad
	 * @param XTemplate $xtpl_facultades
	 */
	protected function parseFacultad(UnidadFacultad $unidadFacultad, XTemplate $xtpl_facultades){
	
		$columns = $this->getFacultadColumns();
		$aligns = $this->getFacultadColumnsAlign();
		$array_facultad = $this->buildArrayFacultad($unidadFacultad);
	
		$index=0;
		foreach ($columns as $column) {
	
			$xtpl_facultades->assign('data', $array_facultad[$column] );
			$xtpl_facultades->assign('align', $aligns[$index]);
			$xtpl_facultades->parse('main.facultad.facultad_data');
	
			$index++;
		}
	
	}
	


	
	
	
	
	
}