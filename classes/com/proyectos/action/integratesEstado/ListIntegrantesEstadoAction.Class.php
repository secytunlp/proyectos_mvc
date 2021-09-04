<?php

/**
 * Acción para listar estados.
 *
 * @author Marcos
 * @since 17-11-2016
 *
 */
class ListIntegrantesEstadoAction extends CMPEntityGridAction{


	protected function getComponent() {
		return new CMPIntegranteEstadoGrid();
	}



}
