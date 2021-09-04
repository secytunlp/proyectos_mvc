<?php

/**
 * componente grilla para integrantes
 *
 * @author Marcos
 * @since 29-10-2013
 *
 */
class CMPIntegranteGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();

		
		$filter = new CMPIntegranteFilter();
		
		$proyecto_oid = CdtUtils::getParam('id');
			
		if (!empty( $proyecto_oid )) {
			$proyecto = new Proyecto();
			$proyecto->setOid($proyecto_oid);
			$filter->setProyecto( $proyecto );
			$filter->saveProperties();
		}
		$this->setFilter( $filter );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new IntegranteGridModel() );
		
		//$this->setRenderer( );
	}

}