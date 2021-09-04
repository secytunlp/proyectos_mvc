<?php

/**
 * GridModel para TipoUnidad
 *
 * @author Marcos
 * @since 17-10-2013
 */
class TipoUnidadGridModel extends GridModel {

	public function __construct() {

		parent::__construct();
		$this->initModel();
	}

	protected function initModel() {

		$column = GridModelBuilder::buildColumn( "oid", CYT_LBL_ENTITY_OID, 20, CDT_CMP_GRID_TEXTALIGN_RIGHT );
		$this->addColumn( $column );
		$this->addFilter( GridModelBuilder::buildFilterModelFromColumn( $column ) );

		$column = GridModelBuilder::buildColumn( "nombre", CYT_LBL_TIPO_Unidad_NOMBRE, 50 ) ;
		$this->addColumn( $column );
		$this->addFilter( GridModelBuilder::buildFilterModelFromColumn( $column ) );

		//acciones sobre la lista
		$this->buildAction("add_tipoUnidad_init", "add_tipoUnidad_init", CYT_MSG_TIPO_Unidad_TITLE_ADD, "image", "add");
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getTitle();
	 */
	function getTitle() {
		return CYT_MSG_TIPO_Unidad_TITLE_LIST;
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getEntityManager();
	 */
	public function getEntityManager() {
		return ManagerFactory::getTipoUnidadManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getRowActionsModel( $item );
	 */
	public function getRowActionsModel($item) {

		return $this->getDefaultRowActions($item, "tipoUnidad", CYT_LBL_TIPO_Unidad, true, true, true, false, 500, 750);
	}


}
?>