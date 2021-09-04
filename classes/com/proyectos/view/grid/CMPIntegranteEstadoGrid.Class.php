<?php

/**
 * componente grilla para integrantes estado
 *
 * @author Marcos
 * @since 17-11-2016
 *
 */
class CMPIntegranteEstadoGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();
		
		$filter = new CMPIntegranteEstadoFilter();
		
		$solicitud_oid = CdtUtils::getParam('id');
			
		if (!empty( $solicitud_oid )) {
			$solicitud = new Integrante();
			$solicitud->setOid($solicitud_oid);
			$filter->setIntegrante( $solicitud );
			$filter->saveProperties();
		}
		$this->setFilter( $filter );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new IntegranteEstadoGridModel() );
		//$this->setRenderer( );
	}

}