<?php

/**
 * componente grilla para unidades
 *
 * @author Marcos
 * @since 21-10-2013
 *
 */
class CMPUnidadGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();

		$this->setFilter( new CMPUnidadFilter() );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new UnidadGridModel() );
		//$this->setRenderer( );
	}

}