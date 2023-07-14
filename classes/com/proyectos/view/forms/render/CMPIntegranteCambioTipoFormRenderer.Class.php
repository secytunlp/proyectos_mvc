<?php

/**
 * Implementación para renderizar un formulario de integrante 
 *
 * @author Marcos
 * @since 31-03-2022
 *
 */
class CMPIntegranteCambioTipoFormRenderer extends DefaultFormRenderer {

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

                    if ($input->getProperty("name")=='tipoIntegrante.oid') {
                        //$nu_horasInv = $input->getInputValue();
                        //echo $input->getInputValue();
                        $options = $input->getOptions();

                        unset($options[$input->getInputValue()]);

                        $input->setOptions($options);
                        $input->setInputValue(0);
                    }

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
            //if ($sinCV==0) {
                $nu_horasInv = 0;
                $xtpl->assign("label_size_archivos", CYT_MSG_SIZE_ARCHIVOS);

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

                $nu_horasInv = $hiddenNu_horasinvAnt->getInputValue();


            $xtpl->assign("nu_horasinv_control", $nu_horasInv);

		} 
	}
	
	protected function renderInputArea( CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("input", "<br>".$input->show() );
		
		$xtpl->parse("main.fieldset.column.field.input");
		
	}
	
	


	
	
	
	
	
}