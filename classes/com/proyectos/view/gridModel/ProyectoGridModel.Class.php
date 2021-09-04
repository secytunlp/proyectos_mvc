<?php

/**
 * GridModel para Proyecto
 *
 * @author Marcos
 * @since 12-11-2013
 */
class ProyectoGridModel extends GridModel {

	public function __construct() {

		parent::__construct();
		$this->initModel();
	}

	protected function initModel() {

		
		
		$column = GridModelBuilder::buildColumn( "oid", CYT_LBL_ENTITY_OID, 20, CDT_CMP_GRID_TEXTALIGN_RIGHT );
		$this->addColumn( $column );
		$this->addFilter( GridModelBuilder::buildFilterModelFromColumn( $column ) );		
		
		$column = GridModelBuilder::buildColumn( "ds_codigo", CYT_LBL_PROYECTO_CODIGO, 20, CDT_CMP_GRID_TEXTALIGN_LEFT, "ds_codigo" );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "ds_titulo", CYT_LBL_PROYECTO_TITULO, 80, CDT_CMP_GRID_TEXTALIGN_LEFT, "ds_titulo" );
		$this->addColumn( $column );
		
		
		$tDirector = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
        $column = GridModelBuilder::buildColumn( "director.ds_apellido,director.ds_nombre", CYT_LBL_PROYECTO_DIRECTOR, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tDirector.ds_apellido,$tDirector.ds_nombre" );
		$this->addColumn( $column );
		

		
		$column = GridModelBuilder::buildColumn( "dt_ini", CYT_LBL_PROYECTO_INICIO, 30, CDT_CMP_GRID_TEXTALIGN_CENTER, null, new GridDateValueFormat(CYT_DATE_FORMAT) ); 
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "dt_fin", CYT_LBL_PROYECTO_FIN, 30, CDT_CMP_GRID_TEXTALIGN_CENTER, null, new GridDateValueFormat(CYT_DATE_FORMAT) ); 
		$this->addColumn( $column );
		
		
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
        $column = GridModelBuilder::buildColumn( "facultad.ds_facultad", CYT_LBL_PROYECTO_FACULTAD, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tFacultad.ds_facultad" );
		$this->addColumn( $column );
		
		$tEstado = DAOFactory::getEstadoDAO()->getTableName();
        $column = GridModelBuilder::buildColumn( "estado.ds_estado", CYT_LBL_TIPO_ESTADO, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tEstado.ds_estado" );
		$this->addColumn( $column );
		
		//acciones sobre la lista
		
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getTitle();
	 */
	function getTitle() {
		return CYT_MSG_PROYECTO_TITLE_LIST;
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getEntityManager();
	 */
	public function getEntityManager() {
		return ManagerFactory::getProyectoManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getRowActionsModel( $item );
	 */
	public function getRowActionsModel($item) {
		//return $this->getDefaultRowActions($item, "unidad", CYT_LBL_UNIDAD, true, true, true, false, 500, 750);
		$actions = new ItemCollection();
	

		
		$action = $this->buildRowAction("list_integrantes", "list_integrantes", CYT_MSG_INTEGRANTE_TITLE_LIST, CDT_CMP_GRID_MSG_VIEW, "attach" ) ;
		$actions->addItem( $action );
		
				
		$action = $this->buildRowAction( "view_proyecto", "view_proyecto", CYT_MSG_PROYECTO_PDF_TITLE, CDT_UI_IMG_SEARCH, "view", "", false, "", true, 850, 1050 ) ;
		$actions->addItem( $action );
		
		return $actions;
	}


}
?>