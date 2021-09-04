<?php

/**
 * componente filter para unidades tipos estados.
 *
 * @author Marcos
 * @since 07-11-2013
 *
 */
class CMPUnidadTipoEstadoFilter extends CMPFilter{

	
	
	
	
	/**
	 * registro 
	 * @var string
	 */
	private $unidad;
	
	/**
	 * tipoEstado
	 * @var TipoEstado
	 */
	private $tipoEstado;
	
	/**
	 * inicio  desde.
	 * @var string
	 */
	private $inicioDesde;
	
	/**
	 * inicio  hasta.
	 * @var string
	 */
	private $inicioHasta;
	
	/**
	 * fin  desde.
	 * @var string
	 */
	private $finDesde;
	
	/**
	 * fin  hasta.
	 * @var string
	 */
	private $finHasta;
	
	
	
	
	
	public function __construct( $id="filter_unidadesTipoEstado"){

		parent::__construct($id);


		$this->setComponent("CMPUnidadTipoEstadoGrid");

		
		
		$this->setUnidad( new Unidad() );
		$this->setTipoEstado( new TipoEstado() );
		
		//formamos el form de búsqueda.
		
		
		
		
		$findUnidad = CYTComponentsFactory::getFindUnidad(new Unidad(), CYT_LBL_UNIDAD, "", "unidadTipoEstado_filter_unidad_oid", "unidad.oid", "");
		$findUnidad->setMinWidth("372px;");
		$this->addField( $findUnidad );
		
		$fieldTipoEstado = FieldBuilder::buildFieldSelect (CYT_LBL_TIPO_ESTADO, "tipoEstado.oid", CYTUtils::getTiposEstadoItems(), null, null, null, "--Seleccionar--" );
		$this->addField( $fieldTipoEstado );
		
		$fieldInicioDesde = FieldBuilder::buildFieldDate ( CYT_LBL_UNIDAD_TIPO_ESTADO_FECHA_DESDE_DESDE, "inicioDesde"  );
		$this->addField( $fieldInicioDesde,2 );
		
		$fieldInicioHasta = FieldBuilder::buildFieldDate ( CYT_LBL_UNIDAD_TIPO_ESTADO_FECHA_DESDE_HASTA, "inicioHasta"  );
		$this->addField( $fieldInicioHasta,2 );
		
		$fieldFinDesde = FieldBuilder::buildFieldDate ( CYT_LBL_UNIDAD_TIPO_ESTADO_FECHA_HASTA_DESDE, "finDesde"  );
		$this->addField( $fieldFinDesde,2 );
		
		$fieldFinHasta = FieldBuilder::buildFieldDate ( CYT_LBL_UNIDAD_TIPO_ESTADO_FECHA_HASTA_HASTA, "finHasta"  );
		$this->addField( $fieldFinHasta,2 );
		
		
		
		
		
		$this->fillForm();

	}


	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);
		
		
		
		//filtramos por unidad.
		$unidad = $this->getUnidad();
		if($unidad!=null && $unidad->getOid()!=null){
			$criteria->addFilter("unidad_oid", $unidad->getOid(), "=" );
		}
		
		//filtramos por estado de unidad.
		$tipoEstado = $this->getTipoEstado();
		if($tipoEstado!=null && $tipoEstado->getOid()!=null){
			$criteria->addFilter("tipoEstado_oid", $tipoEstado->getOid(), "=" );
		}
		
		//filtramos por rango de fechas.
		$inicioDesde = $this->getInicioDesde();
		if(!empty($inicioDesde)){
			$criteria->addFilter("fechaDesde", $inicioDesde, ">=", new CdtCriteriaFormatMysqlDateValue("d/m/y", DB_DEFAULT_DATETIME_FORMAT) );
		}
		
		$inicioHasta = $this->getInicioHasta();
		if(!empty($inicioHasta)){
			$criteria->addFilter("fechaDesde", CYTUtils::addDays(CYTSecureUtils::formatDateToPersist($inicioHasta), DB_DEFAULT_DATETIME_FORMAT, 1), "<=", new CdtCriteriaFormatStringValue());
		}
		
		$finDesde = $this->getFinDesde();
		if(!empty($finDesde)){
			$criteria->addFilter("fechaHasta", $finDesde, ">=", new CdtCriteriaFormatMysqlDateValue("d/m/y",DB_DEFAULT_DATETIME_FORMAT) );
		}
		
		$finHasta = $this->getFinHasta();
		if(!empty($finHasta)){
			$criteria->addFilter("fechaDesde", CYTUtils::addDays(CYTSecureUtils::formatDateToPersist($finHasta), DB_DEFAULT_DATETIME_FORMAT, 1), "<=", new CdtCriteriaFormatStringValue());
		}
		
	}




	

	

	

	public function getUnidad()
	{
	    return $this->unidad;
	}

	public function setUnidad($unidad)
	{
	    $this->unidad = $unidad;
	}

	public function getTipoEstado()
	{
	    return $this->tipoEstado;
	}

	public function setTipoEstado($tipoEstado)
	{
	    $this->tipoEstado = $tipoEstado;
	}

	

	public function getInicioDesde()
	{
	    return $this->inicioDesde;
	}

	public function setInicioDesde($inicioDesde)
	{
	    $this->inicioDesde = $inicioDesde;
	}

	public function getInicioHasta()
	{
	    return $this->inicioHasta;
	}

	public function setInicioHasta($inicioHasta)
	{
	    $this->inicioHasta = $inicioHasta;
	}

	public function getFinDesde()
	{
	    return $this->finDesde;
	}

	public function setFinDesde($finDesde)
	{
	    $this->finDesde = $finDesde;
	}

	public function getFinHasta()
	{
	    return $this->finHasta;
	}

	public function setFinHasta($finHasta)
	{
	    $this->finHasta = $finHasta;
	}
}