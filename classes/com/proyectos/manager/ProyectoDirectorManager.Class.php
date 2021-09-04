<?php

/**
 * Manager para Proyecto
 *  
 * @author Marcos
 * @since 12-11-2013
 */
class ProyectoDirectorManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getProyectoDAO();
	}

}
?>
