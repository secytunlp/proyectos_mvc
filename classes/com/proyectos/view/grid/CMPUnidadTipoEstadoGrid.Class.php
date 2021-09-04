<?php

/**
 * componente grilla para unidades tipo estado
 *
 * @author Marcos
 * @since 07-11-2013
 *
 */
class CMPUnidadTipoEstadoGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();
		
		$filter = new CMPUnidadTipoEstadoFilter();
		
		$unidad_oid = CdtUtils::getParam('id');
			
		if (!empty( $unidad_oid )) {
			$unidad = new Unidad();
			$unidad->setOid($unidad_oid);
			$filter->setUnidad( $unidad );
			$filter->saveProperties();
		}
		$this->setFilter( $filter );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new UnidadTipoEstadoGridModel() );
		//$this->setRenderer( );
	}

}