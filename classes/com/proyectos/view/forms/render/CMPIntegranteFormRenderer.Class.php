<?php

/**
 * Implementación para renderizar un formulario de integrante 
 *
 * @author Marcos
 * @since 11-10-2016
 *
 */
class CMPIntegranteFormRenderer extends DefaultFormRenderer {

	 protected function getXTemplate() {
    	return new XTemplate( CYT_TEMPLATE_INTEGRANTE_FORM );
    }
	
	
	protected function renderFieldset(CMPForm $form, XTemplate $xtpl){
		$xtpl->assign("apellido_requerido", CYT_MSG_INTEGRANTE_APELLIDO_CV_REQUIRED);
		
		foreach ($form->getFieldsets() as $fieldset) {
			
			//legend
			$legend = $fieldset->getLegend();
			if(!empty($legend)){
				$xtpl->assign("value", $legend);
				$xtpl->parse("main.fieldset.legend");
			}
			
			//fields
			/*
			foreach ($fieldset->getFields() as $formField) {
				$input = $formField->getInput();
				$label = $formField->getLabel();
				
				if( $input->getIsVisible() ){
					$this->renderLabel( $label, $input, $xtpl );
					$this->renderInput( $input, $xtpl );
				
					$xtpl->parse("main.fieldset.column.field");
				}
				
			}
			$xtpl->parse("main.fieldset.column");
			 */
			foreach ($fieldset->getFieldsColumns() as $column => $fields) {
				
				foreach ($fields as $formField) {
					
					$input = $formField->getInput();
					$label = $formField->getLabel();
					
					$this->renderLabel( $label, $input, $xtpl );
					//print_r($input->getProperty("name"));
					if ($input->getProperty("name")=='nu_horasinv') {
						$nu_horasInv = $input->getInputValue();
					}
					 
					if ($input->getProperty("name")=='dt_cambioHS') {
						
						$sinCV = $input->getIsVisible();
					}
					
					if ($input->getProperty("name")=='ds_reduccionHS') {
						$this->renderInputArea( $input, $xtpl );
						
					}
					else{
						$this->renderInput( $input, $xtpl );
					}
					$xtpl->assign("minWidth", $formField->getMinWidth());
					
					if( $input->getIsVisible() ){
						$xtpl->assign("display", 'block');
						
					}
					else $xtpl->assign("display", 'none');
					
					$xtpl->parse("main.fieldset.column.field");
				}
				$xtpl->parse("main.fieldset.column");
			}
			
			$xtpl->parse("main.fieldset");
			$hiddens = $form->getHiddens();
			$hiddenNu_horasinvAnt = $hiddens['nu_horasinvAnt'];
			if ($sinCV==0) {
				$nu_horasInv = 0;
				$xtpl->assign("label_size_archivos", CYT_MSG_SIZE_ARCHIVOS);
				$xtpl->assign("value", CYT_LBL_INTEGRANTE_CURRICULUM );
				$xtpl->assign("required", "*" );
				$xtpl->parse("main.curriculum.label");
				$xtpl->assign("actionFile", "doAction?action=add_file_session" );
				
			$hiddenDs_curriculum = $hiddens['ds_curriculum'];
				$cv_cargado = 0;
				if ($hiddenDs_curriculum->getInputValue()) {
					$ds_cvArray =  explode("_", $hiddenDs_curriculum->getInputValue());	
					foreach ($ds_cvArray as $ds_cv) {
						//CdtUtils::log("cvArray: "   . $ds_cv);
						if (strstr($ds_cv,'P'.CYT_PERIODO.CYT_YEAR)) {
							$cv_cargado = 1;
							break;
						}
					}
				}
				 
				if (!$cv_cargado) {
					$xtpl->assign("curriculum_requerido", 'jval="{valid:function (val) { return required(val,\'Curriculum es requerido\'); }}"');
				}
				$xtpl->parse("main.curriculum.input");
				$xtpl->assign("display", 'block');
				$xtpl->assign("label_curriculum", CYT_LBL_INTEGRANTE_CURRICULUM_SIGEVA);
				
					
				if ($cv_cargado) {
					$xtpl->assign("curriculum_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_curriculum->getInputValue().'</span>');
				}
				
				$xtpl->parse("main.curriculum");
				$xtpl->assign("value", CYT_LBL_INTEGRANTE_PLAN );
				$xtpl->assign("required", "*" );
				$xtpl->parse("main.ds_actividades.label");
				$xtpl->assign("actionFile", "doAction?action=add_file_session" );
				$hiddens = $form->getHiddens();
				$hiddenDs_actividades = $hiddens['ds_actividades'];
				$plan_cargado = 0;	
				if ($hiddenDs_actividades->getInputValue()) {
					$ds_planArray =  explode("_", $hiddenDs_actividades->getInputValue());	
					foreach ($ds_planArray as $ds_plan) {
						if (strstr($ds_plan,'P'.CYT_PERIODO.CYT_YEAR)) {
							$plan_cargado = 1;
							break;
						}
					}
				}
				if (!$plan_cargado) {
					$xtpl->assign("ds_actividades_requerido", 'jval="{valid:function (val) { return required(val,\'Curriculum es requerido\'); }}"');
				}
				$xtpl->parse("main.ds_actividades.input");
				$xtpl->assign("display", 'block');
				
				
					
				if ($plan_cargado) {
					$xtpl->assign("ds_actividades_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_actividades->getInputValue().'</span>');
				}
				
				$xtpl->parse("main.ds_actividades");
				$xtpl->assign("value", CYT_LBL_INTEGRANTE_RESOLUCION_BECA );
				$xtpl->parse("main.ds_resolucionBeca.label");
				$xtpl->assign("actionFile", "doAction?action=add_file_session" );
				$hiddens = $form->getHiddens();
				$hiddenDs_resolucionBeca = $hiddens['ds_resolucionBeca'];
				$plan_cargado = 0;	
				if ($hiddenDs_resolucionBeca->getInputValue()) {
					$ds_planArray =  explode("_", $hiddenDs_resolucionBeca->getInputValue());	
					foreach ($ds_planArray as $ds_plan) {
						if (strstr($ds_plan,'P'.CYT_PERIODO.CYT_YEAR)) {
							$plan_cargado = 1;
							break;
						}
					}
				}
				if (!$plan_cargado) {
					$xtpl->assign("ds_resolucionBeca_requerido", 'jval="{valid:function (val) { return required(val,\'Curriculum es requerido\'); }}"');
				}
				$xtpl->parse("main.ds_resolucionBeca.input");
				$xtpl->assign("display", 'block');
				
				
					
				if ($plan_cargado) {
					$xtpl->assign("ds_resolucionBeca_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_resolucionBeca->getInputValue().'</span>');
				}
				
				$xtpl->parse("main.ds_resolucionBeca");
			}
			else{
				$nu_horasInv = $hiddenNu_horasinvAnt->getInputValue();
			}
				
			$xtpl->assign("nu_horasinv_control", $nu_horasInv);
		} 
	}
	
	protected function renderInputArea( CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("input", "<br>".$input->show() );
		
		$xtpl->parse("main.fieldset.column.field.input");
		
	}
	
	


	
	
	
	
	
}