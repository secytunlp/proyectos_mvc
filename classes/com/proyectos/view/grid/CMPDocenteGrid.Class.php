<?php

/**
 * componente grilla para docentes
 *
 * @author Marcos
 * @since 21-10-2013
 *
 */
class CMPDocenteGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();

		$this->setFilter( new CMPDocenteFilter() );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new DocenteGridModel() );
		//$this->setRenderer( );
	}

}
