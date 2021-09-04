<?php

/**
 * componente filter para tipos de Unidad.
 *
 * @author Marcos
 * @since 17-10-2013
 *
 */
class CMPTipoUnidadFilter extends CMPFilter{

	/**
	 * nombre del tipo de título
	 * @var string
	 */
	private $nombre;



	public function __construct( $id="filter_tiposUnidad"){

		parent::__construct($id);


		$this->setComponent("CMPTipoUnidadGrid");

		//formamos el form de búsqueda.
		$this->addField( FieldBuilder::buildFieldText ( CYT_LBL_TIPO_Unidad_NOMBRE, "nombre"  ) );

		$this->fillForm();

	}


	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);
		
		$nombre = $this->getNombre();

		if(!empty($nombre)){
			$criteria->addFilter("nombre", $nombre, "like", new CdtCriteriaFormatLikeValue() );
		}

		

	}


	public function getNombre()
	{
		return $this->nombre;
	}

	public function setNombre($nombre)
	{
		$this->nombre = $nombre;
	}

}