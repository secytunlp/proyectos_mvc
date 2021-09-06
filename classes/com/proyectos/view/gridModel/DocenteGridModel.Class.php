<?php

/**
 * GridModel para Docente
 *
 * @author Marcos
 * @since 06-09-2021
 */
class DocenteGridModel extends GridModel {

	public function __construct() {

		parent::__construct();
		$this->initModel();
	}

	protected function initModel() {



		$column = GridModelBuilder::buildColumn( "oid", CYT_LBL_ENTITY_OID, 20, CDT_CMP_GRID_TEXTALIGN_RIGHT );
		$this->addColumn( $column );
		$this->addFilter( GridModelBuilder::buildFilterModelFromColumn( $column ) );


		$column = GridModelBuilder::buildColumn( "ds_apellido", CYT_LBL_DOCENTE, 50, CDT_CMP_GRID_TEXTALIGN_LEFT, "ds_apellido" ) ;
		$this->addColumn( $column );

        $column = GridModelBuilder::buildColumn( "ds_nombre", CYT_LBL_DOCENTE, 50, CDT_CMP_GRID_TEXTALIGN_LEFT, "ds_nombre" ) ;
        $this->addColumn( $column );

		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$column = GridModelBuilder::buildColumn( "cuil", CYT_LBL_INTEGRANTE_CUIL, 20, CDT_CMP_GRID_TEXTALIGN_CENTER, "cuil" );
		$this->addColumn( $column );



		$tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
		$column = GridModelBuilder::buildColumn( "categoria.ds_categoria", CYT_LBL_INTEGRANTE_CATEGORIA, 20, CDT_CMP_GRID_TEXTALIGN_CENTER, "$tCategoria.ds_categoria" );
		$this->addColumn( $column );

		$tCargo = CYTSecureDAOFactory::getCargoDAO()->getTableName();
		$column = GridModelBuilder::buildColumn( "cargo.ds_cargo", CYT_LBL_INTEGRANTE_CARGO, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tCargo.ds_cargo" );
		$this->addColumn( $column );

		$tDeddoc = CYTSecureDAOFactory::getDeddocDAO()->getTableName();
		$column = GridModelBuilder::buildColumn( "deddoc.ds_deddoc", CYT_LBL_INTEGRANTE_DEDDOC, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tDeddoc.ds_deddoc" );
		$this->addColumn( $column );


		$column = GridModelBuilder::buildColumn( "oid", CYT_LBL_INTEGRANTE_BECA, 20, CDT_CMP_GRID_TEXTALIGN_LEFT,"",new GridDocenteBecasValueFormat() ) ;
		$this->addColumn( $column );


		$tCarrerainv = CYTSecureDAOFactory::getCarrerainvDAO()->getTableName();
		$tOrganismo = CYTSecureDAOFactory::getOrganismoDAO()->getTableName();
		$column = GridModelBuilder::buildColumn( "carrerainv.ds_carrerainv,organismo.ds_codigo", CYT_LBL_INTEGRANTE_CARRERAINV, 60, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tCarrerainv.ds_categoria,$tOrganismo.ds_codigo" );
		$this->addColumn( $column );





		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		$column = GridModelBuilder::buildColumn( "facultad.ds_facultad", CYT_LBL_INTEGRANTE_FACULTAD, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tFacultad.ds_facultad" );
		$this->addColumn( $column );


	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getTitle();
	 */
	function getTitle() {
		return CYT_MSG_DOCENTE_TITLE_LIST;
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getEntityManager();
	 */
	public function getEntityManager() {
		return CYTSecureManagerFactory::getDocenteManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getRowActionsModel( $item );
	 */
	public function getRowActionsModel($item) {

		$actions = new ItemCollection();




		return $actions;
	}



}
?>
