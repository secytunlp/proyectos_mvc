<?php

/**
 * componente grilla para proyectos
 *
 * @author Marcos
 * @since 12-11-2013
 *
 */
class CMPProyectoGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();

		$this->setFilter( new CMPProyectoFilter() );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new ProyectoGridModel() );
		//$this->setRenderer( );
	}

}