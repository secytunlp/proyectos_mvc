<?php

/**
 * Acción para listar docentes.
 *
 * @author Marcos
 * @since 06-09-2021
 *
 */
class ListDocentesAction extends CMPEntityGridAction{


	protected function getComponent() {
		return new CMPDocenteGrid();
	}



}
