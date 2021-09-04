<?php

/**
 * Implementación para renderizar un formulario de baja de integrante 
 *
 * @author Marcos
 * @since 22-11-2016
 *
 */
class CMPIntegranteBajaFormRenderer extends DefaultFormRenderer {

	 protected function getXTemplate() {
    	return new XTemplate( CYT_TEMPLATE_INTEGRANTE_BAJA_FORM );
    }
	
	
	protected function renderFieldset(CMPForm $form, XTemplate $xtpl){
		
		foreach ($form->getFieldsets() as $fieldset) {
			//legend
			$legend = $fieldset->getLegend();
			if(!empty($legend)){
				$xtpl->assign("value", $legend);
				$xtpl->parse("main.legend");
			}
			
			
			$fields = $fieldset->getFields();

			
			$field = $fields['oid'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.oid");
			
			$field = $fields['integrante_form_proyecto_oid'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.integrante_form_proyecto_oid");
			
			$field = $fields['ds_apellido'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_apellido");
			
			$field = $fields['dt_baja'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.dt_baja");
			
			$field = $fields['ds_consecuencias'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_consecuencias");
			
			$field = $fields['ds_motivos'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_motivos");
			
			$field = $fields['bl_mincategorizados'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.bl_mincategorizados");
			
			$field = $fields['bl_minmayordedicacion'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.bl_minmayordedicacion");
			
			
			
			
		} 
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
	
	


	
	
	
	
	
}