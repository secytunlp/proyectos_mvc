<?php

/**
 * Manager para EstadoIntegrante
 *  
 * @author Marcos
 * @since 18-11-2016
 */
class EstadoIntegranteManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getEstadoIntegranteDAO();
	}

}
?>
