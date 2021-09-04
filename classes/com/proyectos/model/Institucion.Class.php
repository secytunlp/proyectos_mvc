<?php


/**
 * Institucion 
 *  
 * @author Marcos
 * @since 10-11-2016
 */

class Institucion {
    
    const ANPCyT = 'ANPCyT';
    const CIC = 'CIC';
	const CONICET = 'CONICET';
	const UNLP = 'UNLP';
    
   
										
    
    private static $items = array(  
    								   Institucion::ANPCyT=> CYT_LBL_INTEGRANTE_INSTITUCION_BECA_ANPCyT,
    								   Institucion::CIC=> CYT_LBL_INTEGRANTE_INSTITUCION_BECA_CIC,
    								   Institucion::CONICET=> CYT_LBL_INTEGRANTE_INSTITUCION_BECA_CONICET,
    								   Institucion::UNLP=> CYT_LBL_INTEGRANTE_INSTITUCION_BECA_UNLP,
    								   );
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}
					   
}
?>
