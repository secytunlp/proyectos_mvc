<?php

/**
 * GridModel para Unidad TIpo Estado
 *
 * @author Marcos
 * @since 07-11-2013
 */
class UnidadTipoEstadoGridModel extends GridModel {

	public function __construct() {

		parent::__construct();
		$this->initModel();
	}

	protected function initModel() {

		
		
		$column = GridModelBuilder::buildColumn( "oid", CYT_LBL_ENTITY_OID, 20, CDT_CMP_GRID_TEXTALIGN_RIGHT );
		$this->addColumn( $column );
		$this->addFilter( GridModelBuilder::buildFilterModelFromColumn( $column ) );

		$tUnidad = DAOFactory::getUnidadDAO()->getTableName();
		$column = GridModelBuilder::buildColumn( "unidad.denominacion", CYT_LBL_UNIDAD, 80, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tUnidad.denominacion" ) ;
		$this->addColumn( $column );
		$this->addFilter( GridModelBuilder::buildFilterModelFromColumn( $column ) );

		$tTipoEstado = DAOFactory::getTipoEstadoDAO()->getTableName();
        $column = GridModelBuilder::buildColumn( "tipoEstado.nombre", CYT_LBL_TIPO_ESTADO, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tTipoEstado.nombre" );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fechaDesde", CYT_LBL_UNIDAD_TIPO_ESTADO_FECHA_DESDE, 30, CDT_CMP_GRID_TEXTALIGN_CENTER, null, new GridDateValueFormat(CYT_DATETIME_FORMAT) ); 
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fechaHasta", CYT_LBL_UNIDAD_TIPO_ESTADO_FECHA_HASTA, 30, CDT_CMP_GRID_TEXTALIGN_CENTER, null, new GridDateValueFormat(CYT_DATETIME_FORMAT) ); 
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "motivo", CYT_LBL_UNIDAD_TIPO_ESTADO_MOTIVO, 40 );
		$this->addColumn( $column );
		
		$tUser = CYT_TABLE_CDT_USER;
        $column = GridModelBuilder::buildColumn( "user.ds_username", CYT_LBL_INTEGRANTE_USUARIO_ULTIMA_MODIFICACION, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tUser.ds_username" );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fechaUltModificacion", CYT_LBL_INTEGRANTE_FECHA_ULTIMA_MODIFICACION, 30, CDT_CMP_GRID_TEXTALIGN_CENTER, null, new GridDateValueFormat(CYT_DATETIME_FORMAT) ); 
		$this->addColumn( $column );
		
		//acciones sobre la lista
		$this->buildAction("cambiarEstadoUnidad_init", "cambiarEstadoUnidad_init", CYT_MSG_UNIDAD_TIPO_ESTADO_CAMBIAR, "image", "edit");
		
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getTitle();
	 */
	function getTitle() {
		return CYT_MSG_UNIDAD_TIPO_ESTADO_TITLE_LIST;
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getEntityManager();
	 */
	public function getEntityManager() {
		return ManagerFactory::getUnidadTipoEstadoManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getRowActionsModel( $item );
	 */
	public function getRowActionsModel($item) {

		
		
		//$actions = $this->getDefaultRowActions($item, "matriculado", CPIQ_LBL_MATRICULADO, false, true, true, false, 500, 750);
		
		$actions = new ItemCollection();
		
		
		
		return $actions;
	}


}
?>