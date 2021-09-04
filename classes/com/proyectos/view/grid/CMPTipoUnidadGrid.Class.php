<?php

/**
 * componente grilla para tipos de Unidad.
 *
 * @author Marcos
 * @since 17-10-2013
 *
 */
class CMPTipoUnidadGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();

		$this->setFilter( new CMPTipoUnidadFilter() );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new TipoUnidadGridModel() );
		//$this->setRenderer( );
	}

}