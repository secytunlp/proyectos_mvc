<?php
class FacultadComparator implements IItemComparator{
	
	function equals( $oObjeto1, $oObjeto2){
		return ($oObjeto1->getFacultad()->getOid() == $oObjeto2->getFacultad()->getOid());
	
	}
	
}