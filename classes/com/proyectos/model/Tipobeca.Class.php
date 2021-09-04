<?php


/**
 * Tipobeca 
 *  
 * @author Marcos
 * @since 10-11-2016
 */

class Tipobeca {
    
 
	const AGENCIA1 = 'Beca incial';
	const AGENCIA2 = 'Beca superior';
	const CIC1 = 'Beca de entrenamiento';
	const CIC2 = 'Beca doctoral';
	const CIC3 = 'Beca posdoctoral';
	const CONICET1 = 'Beca doctoral';
	const CONICET2 = 'Beca finalizacion del doctorado';
	const CONICET3 = 'Beca posdoctoral';
	const UNLP1 = "TIPO A";
	const UNLP2 = 'TIPO B-MAESTRIA';
	const UNLP3 = 'TIPO B-DOCTORADO';
	const UNLP4 = 'RETENCION DE POSTGRADUADO';
	const UNLP5 = 'Beca Cofinanciada (UNLP-CIC)';
	const UNLP6 = "Beca doctoral";
	const UNLP7 = 'Beca maestria';
	const UNLP8 = 'Beca posdoctoral';
	const UNLP9 = 'Programa de retencion de Doctores';

    
   
										
    
    private static $itemsAgencia = array(  
    								   Tipobeca::AGENCIA1=> CYT_LBL_INTEGRANTE_TIPO_BECA_AGENCIA1,
    								   Tipobeca::AGENCIA2=> CYT_LBL_INTEGRANTE_TIPO_BECA_AGENCIA2,
    								  
    								   );
    								   
    private static $itemsCIC = array(  
    								   Tipobeca::CIC1=> CYT_LBL_INTEGRANTE_TIPO_BECA_CIC1,
    								   Tipobeca::CIC2=> CYT_LBL_INTEGRANTE_TIPO_BECA_CIC2,
    								   Tipobeca::CIC3=> CYT_LBL_INTEGRANTE_TIPO_BECA_CIC3,
    								  
    								   );
    private static $itemsCONICET = array(  
    								   Tipobeca::CONICET1=> CYT_LBL_INTEGRANTE_TIPO_BECA_CONICET1,
    								   Tipobeca::CONICET2=> CYT_LBL_INTEGRANTE_TIPO_BECA_CONICET2,
    								   Tipobeca::CONICET3=> CYT_LBL_INTEGRANTE_TIPO_BECA_CONICET3,
    								  
    								   );								   
    
    private static $itemsUNLP = array(  
    								   Tipobeca::UNLP1=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP1,
    								   Tipobeca::UNLP2=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP2,
    								   Tipobeca::UNLP3=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP3,
    								   Tipobeca::UNLP4=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP4,
    								   Tipobeca::UNLP5=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP5,	
    								   Tipobeca::UNLP6=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP6,	
    								   Tipobeca::UNLP7=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP7,	
    								   Tipobeca::UNLP8=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP8,	
    								   Tipobeca::UNLP9=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9,	
    								   );	
   	private static $items = array(  
    								   
    								''=> "--seleccionar--",
   									Tipobeca::AGENCIA1=> CYT_LBL_INTEGRANTE_TIPO_BECA_AGENCIA1,
    								   Tipobeca::AGENCIA2=> CYT_LBL_INTEGRANTE_TIPO_BECA_AGENCIA2,
    								  
    								  
    								   Tipobeca::CIC1=> CYT_LBL_INTEGRANTE_TIPO_BECA_CIC1,
    								   Tipobeca::CIC2=> CYT_LBL_INTEGRANTE_TIPO_BECA_CIC2,
    								  Tipobeca::CIC3=> CYT_LBL_INTEGRANTE_TIPO_BECA_CIC3,
    								  
    								   Tipobeca::CONICET1=> CYT_LBL_INTEGRANTE_TIPO_BECA_CONICET1,
    								   Tipobeca::CONICET2=> CYT_LBL_INTEGRANTE_TIPO_BECA_CONICET2,
    								  Tipobeca::CONICET3=> CYT_LBL_INTEGRANTE_TIPO_BECA_CONICET3,
    								
    								   Tipobeca::UNLP1=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP1,
    								   Tipobeca::UNLP2=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP2,
    								   Tipobeca::UNLP3=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP3,
    								   Tipobeca::UNLP4=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP4,
    								   Tipobeca::UNLP5=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP5,
    								   Tipobeca::UNLP6=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP6,	
    								   Tipobeca::UNLP7=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP7,	
    								   Tipobeca::UNLP8=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP8,	
    								   Tipobeca::UNLP9=> CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9,
    								   );									   
	public static function getItems($institucion=''){
		switch ($institucion) {
			case 'ANPCyT':
				return self::$itemsAgencia;
			break;
			case 'CIC':
				return self::$itemsCIC;
			break;
			case 'CONICET':
				return self::$itemsCONICET;
			break;
			case 'UNLP':
				return self::$itemsUNLP;
			break;
			default:
				return self::$items;
			break;
		}
		
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}
					   
}
?>
