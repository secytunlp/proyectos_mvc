<?php

/**
 * componente filter para proyectos.
 *
 * @author Marcos
 * @since 12-11-2013
 *
 */
class CMPProyectoFilter extends CMPFilter{

	/**
	 * ds_codigo 
	 * @var string
	 */
	private $ds_codigo;
	
	/**
	 * director
	 * @var Director
	 */
	private $director;
	
	/**
	 * facultad
	 * @var Facultad
	 */
	private $facultad;
	

	
	
	public function __construct( $id="filter_tiposProyecto"){

		parent::__construct($id);

		
		$this->setOrderBy('cd_proyecto');
	

		$this->setComponent("CMPProyectoGrid");

		$this->setFacultad( new Facultad() );
		
		//formamos el form de búsqueda.
		$fieldCodigo = FieldBuilder::buildFieldText ( CYT_LBL_PROYECTO_CODIGO, "ds_codigo"  );
		$this->addField( $fieldCodigo );
		
		$fieldDirector = FieldBuilder::buildFieldText ( CYT_LBL_PROYECTO_DIRECTOR, "director"  );
		$this->addField( $fieldDirector );
		
		$fieldFacultad = FieldBuilder::buildFieldSelect (CYT_LBL_FACULTAD, "facultad.oid", CYTSecureUtils::getFacultadesItems(), '', null, null, "--seleccionar--", "facultad_oid" );
		
		$this->addField( $fieldFacultad );
	
		

		
		
		
		
		
		
		$this->fillForm();

	}


	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);
		
		$ds_codigo = $this->getDs_codigo();

		if(!empty($ds_codigo)){
			$criteria->addFilter("ds_codigo", $ds_codigo, "like", new CdtCriteriaFormatLikeValue() );
		}
		
		//filtramos por tipo de unidad.
		$facultad = $this->getFacultad();
		if($facultad!=null && $facultad->getOid()!=null){
			$criteria->addFilter("cd_facultad", $facultad->getOid(), "=" );
		}

		
	
		$director = $this->getDirector();

		if(!empty($director)){
			//$criteria->addFilter("docente.ds_apellido", $director, "like", new CdtCriteriaFormatLikeValue() );
			$filter = new CdtSimpleExpression( "(docente.ds_apellido like '$director%') OR (docente.ds_nombre like '$director%')");
			$criteria->setExpresion($filter);
		}
		
		$oUser = CdtSecureUtils::getUserLogged();
		
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_ADMIN_FACULTAD_PROYECTOS) {
			$userManager = CYTSecureManagerFactory::getUserManager();
			$oUsuario = $userManager->getObjectByCode($oUser->getCd_user());
			//print_r($oUsuario);
			
			$tEstado = DAOFactory::getEstadoDAO()->getTableName();
            $criteria->addFilter("$tEstado.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, "=");
            $tProyecto = DAOFactory::getProyectoDAO()->getTableName();
            $filter = new CdtSimpleExpression( "$tProyecto.cd_facultad ='".$oUsuario->getFacultad()->getOid()."' AND $tProyecto.dt_fin > '".((Date("Y"))-1)."-12-31'");
			$criteria->setExpresion($filter);
        }
		
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_DIRECTOR_PROYECTO) {
			
			$tEstado = DAOFactory::getEstadoDAO()->getTableName();
            $criteria->addFilter("$tEstado.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, "=");
            $filter = new CdtSimpleExpression( "(CONCAT(docente.nu_precuil,'-',docente.nu_documento,'-',docente.nu_postcuil)='".$oUser->getDs_username()."' OR CONCAT(docente.nu_precuil,'-0',docente.nu_documento,'-',docente.nu_postcuil)='".$oUser->getDs_username()."') AND dt_fin > '".((Date("Y"))-1)."-12-31'");
			$criteria->setExpresion($filter);
        }
        
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_SECYT_PROYECTOS) {
			$tEstado = DAOFactory::getEstadoDAO()->getTableName();
            $criteria->addFilter("$tEstado.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, "=");
            /*$filter = new CdtSimpleExpression( "dt_fin > '".((Date("Y"))-1)."-12-31'");
			$criteria->setExpresion($filter);*/
        }
		
	}




	

	

	

    public function getDs_codigo()
    {
        return $this->ds_codigo;
    }

    public function setDs_codigo($ds_codigo)
    {
        $this->ds_codigo = $ds_codigo;
    }

    public function getDirector()
    {
        return $this->director;
    }

    public function setDirector($director)
    {
        $this->director = $director;
    }

    public function getFacultad()
    {
        return $this->facultad;
    }

    public function setFacultad($facultad)
    {
        $this->facultad = $facultad;
    }

}