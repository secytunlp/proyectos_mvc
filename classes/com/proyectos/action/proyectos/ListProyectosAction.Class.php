<?php

/**
 * Acción para listar proyectos.
 *
 * @author Marcos
 * @since 12-11-2013
 *
 */
class ListProyectosAction extends CMPEntityGridAction{


	protected function getComponent() {
		return new CMPProyectoGrid();
	}



}
