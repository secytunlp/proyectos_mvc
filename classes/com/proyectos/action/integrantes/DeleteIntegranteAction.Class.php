<?php

/**
 * Acción para eliminar integrantes.
 *
 * @author Marcos
 * @since 04-11-2013
 *
 */
class DeleteIntegranteAction extends DeleteEntityAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/DeleteEntityAction::getEntityManager()
	 */
	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}

	

}
