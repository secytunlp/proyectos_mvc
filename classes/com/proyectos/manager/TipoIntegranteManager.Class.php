<?php

/**
 * Manager para TipoIntegrante
 *  
 * @author Marcos
 * @since 30-10-2013
 */
class TipoIntegranteManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getTipoIntegranteDAO();
	}

}
?>
