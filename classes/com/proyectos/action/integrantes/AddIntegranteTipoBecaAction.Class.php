<?php

/**
 * Se trae los tipos de beca
 * 
 * @author Marcos
 * @since 11-11-2016
 *
 */
class AddIntegranteTipoBecaAction extends CdtAction{


	/**
	 * (non-PHPdoc)
	 * @see CdtAction::execute();
	 */
	public function execute(){

		
		$result = "";
		
		try{
			
			$ds_institucion = CdtUtils::getParam("ds_institucion");
			
			
			$result = Tipobeca::getItems($ds_institucion);
			
			
		}catch(Exception $ex){
			
			$result['error'] = $ex->getMessage();
			
		}

		echo json_encode( $result ); 
		return null;
	}
	
	
	
}