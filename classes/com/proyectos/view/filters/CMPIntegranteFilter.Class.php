<?php

/**
 * componente filter para integrantes.
 *
 * @author Marcos
 * @since 29-10-2013
 *
 */
class CMPIntegranteFilter extends CMPFilter{

	
	/**
	 * proyecto 
	 * @var string
	 */
	private $proyecto;
	
	/**
	 * apellido 
	 * @var string
	 */
	private $apellido;
	
	/**
	 * cuil 
	 * @var string
	 */
	private $cuil;
	
	/**
	 * tipoIntegrante
	 * @var TipoIntegrante
	 */
	private $tipoIntegrante;
	

	private $codigo;
	
	
	/**
	 * bl_pendiente 
	 * @var string
	 */
	private $bl_pendiente;
	
	
	
	
	
	public function __construct( $id="filter_tiposIntegrante"){

		/*$this->setId($id);
		$this->setOrderBy('docente.ds_apellido, docente.ds_nombre');
		$this->setOrderType('ASC');
		$form = new CMPForm($id, CDT_UI_LBL_SEARCH );
		
		
		$fieldset = new FormFieldset( $legend );
		
		$form->addFieldset($fieldset);
		$form->addHidden( FieldBuilder::buildInputHidden ( "search","") );
		$form->addHidden( FieldBuilder::buildInputHidden ( "action","" ) );
		$form->addHidden( FieldBuilder::buildInputHidden ( "component","" ) );
		$form->addHidden( FieldBuilder::buildInputHidden ( "orderBy","" ) );
		$form->addHidden( FieldBuilder::buildInputHidden ( "orderType","" ) );
		$form->addHidden( FieldBuilder::buildInputHidden ( "page","" ) );
		$form->addHidden( FieldBuilder::buildInputHidden ( "rowPerPage",ROW_PER_PAGE ) );
		$form->addHidden( FieldBuilder::buildInputHidden ( "gridId","" ) );
		$form->addHidden( FieldBuilder::buildInputHidden ( "fCallback","" ) );
		
		//properties del form.
    	$form->addProperty("method", "POST");
    	
		$form->setAction("doAction?action=cmp_entitygrid");
		
		$form->addButton( CDT_UI_LBL_SEARCH, "resetFilterPage_$id();search_ajax( '$id', 'doAction?action=cmp_entitygrid' );" );
		
    	$form->setSubmitLabel( "");
    	$form->setCancelLabel( "");
		
		
		$form->setUseAjaxSubmit( true );
		$form->setOnSuccessCallback("showResults");
		
		
		
		$this->setSearch(1);
		$this->setPage(1);
		$this->setRowPerPage( ROW_PER_PAGE );
		$this->setAction("cmp_entitygrid");
		
		
		$this->setForm($form);
		$this->setName("filter");
		
		$this->setCd_user(CdtSecureUtils::getUserLogged()->getCd_user());*/
		
		parent::__construct($id);

		$this->setOrderBy('proyecto.ds_codigo,docente.ds_apellido, docente.ds_nombre');
		$this->setOrderType('ASC');
		$this->setComponent("CMPIntegranteGrid");
		
		$this->setProyecto( new Proyecto() );

		$this->setTipoIntegrante( new TipoIntegrante() );
		
		
		
		
		
		
		$findProyecto = CYTComponentsFactory::getFindProyecto(new Proyecto(), CYT_LBL_PROYECTO, "", "integrante_filter_proyecto_oid", "proyecto.oid", "integrante_filter_proyecto_change");
		$findProyecto->getInput()->setInputSize(5,70);
		        
        $findProyecto->getInput()->setIsEditable(false);
        
		$this->addField( $findProyecto);
		
		$fieldDocente = FieldBuilder::buildFieldText ( CYT_LBL_PROYECTO_CODIGO, "codigo"  );
		$this->addField( $fieldDocente );
		
		$fieldDocente = FieldBuilder::buildFieldText ( CYT_LBL_DOCENTE, "apellido"  );
		$this->addField( $fieldDocente);
		
		$fieldDocente = FieldBuilder::buildFieldText ( CYT_LBL_INTEGRANTE_CUIL, "cuil"  );
		$this->addField( $fieldDocente);
		
		/*$fieldTipoIntegrante = FieldBuilder::buildFieldSelect (CYT_LBL_TIPO_INTEGRANTE, "tipoIntegrante.oid", CYTSecureUtils::getTiposInvestigadorItems(), null, null, null, "--seleccionar--");
		$this->addField( $fieldTipoIntegrante);*/
		
		
		$this->addField( FieldBuilder::buildFieldCheckbox ( CYT_LBL_INTEGRANTE_PENDIENTE, "bl_pendiente", "bl_pendiente") );
		
	
		
		
		
		$this->fillForm();

	}


	/**
	 * (non-PHPdoc)
	 * @see components/CMPComponent::show()
	 */
	public function show( ){
		
		//rellenamos los valores del formulario.
		$this->fillForm();
		
		/*$oProyectoManager = ManagerFactory::getProyectoManager();
		$oProyecto = $oProyectoManager->getObjectByCode($this->getProyecto()->getOid());*/
		
		/*$inputCombo =  $this->getForm()->getInput("tipoIntegrante.oid");
		$inputCombo->setOptions( CYTSecureUtils::getTiposInvestigadorItems() );*/
		
		//mostramos el formulario.
		return $this->getForm()->show();
	}
	
	
	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);
		
		
		//filtramos por proyecto.
		$proyecto = $this->getProyecto();
		if($proyecto!=null && $proyecto->getOid()!=null){
			$criteria->addFilter("cd_proyecto", $proyecto->getOid(), "=" );
		}
		
		$ds_codigo = $this->getCodigo();
		$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
		if(!empty($ds_codigo)){
			$criteria->addFilter($tProyecto.".ds_codigo", $ds_codigo, "like", new CdtCriteriaFormatLikeValue() );
		}
		
		//filtramos por tipo de integrante.
		$tipoIntegrante = $this->getTipoIntegrante();
		if($tipoIntegrante!=null && $tipoIntegrante->getOid()!=null){
			$criteria->addFilter("cd_tipoinvestigador", $tipoIntegrante->getOid(), "=" );
		}

		$apellido = $this->getApellido();
		$cuil = $this->getCuil();
		$oUser = CdtSecureUtils::getUserLogged();
		if(!empty($apellido)){
			$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
			$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
			$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
			$filter = new CdtSimpleExpression("($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO.")) AND ($tDocente.ds_apellido like '%".$apellido."%' OR $tDocente.ds_nombre like '%".$apellido."%')");
			$criteria->setExpresion($filter);
			
			//$criteria->addFilter("apellido", $apellido, "like", new CdtCriteriaFormatLikeValue() );
		}
		elseif(!empty($cuil)){
			$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
			$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
			$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
			$filter = new CdtSimpleExpression("($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO.")) AND (CONCAT($tDocente.nu_precuil,'-',$tDocente.nu_documento,'-',$tDocente.nu_postcuil) like '%".$cuil."%')");
			$criteria->setExpresion($filter);
			
			//$criteria->addFilter("apellido", $apellido, "like", new CdtCriteriaFormatLikeValue() );
		}
		else{
			if ($oUser->getCd_usergroup()!=CYT_CD_GROUP_ADMIN_PROYECTOS) {
				$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
				$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
				$filter = new CdtSimpleExpression("($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO."))");
				$criteria->setExpresion($filter);
			}
			
		}
		
		//filtramos por bl_pendiente.
		$bl_pendiente = $this->getBl_pendiente();
		if($bl_pendiente){
			$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
			
			
			$criteria->addFilter($tIntegranteEstado.".estado_oid", CYT_ESTADO_INTEGRANTE_ADMITIDO, '<>');
		}
		
		
		
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_ADMIN_FACULTAD_PROYECTOS) {
			$userManager = CYTSecureManagerFactory::getUserManager();
			$oUsuario = $userManager->getObjectByCode($oUser->getCd_user());
			//print_r($oUsuario);
			
			$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
            $tProyecto = DAOFactory::getProyectoDAO()->getTableName();
            $filter = new CdtSimpleExpression( "$tProyecto.cd_facultad ='".$oUsuario->getFacultad()->getOid()."' AND $tProyecto.cd_estado ='".CYT_ESTADO_PROYECTO_ACREDITADO."' AND $tProyecto.dt_fin > '".((Date("Y"))-1)."-12-31' AND ($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO."))");
			$criteria->setExpresion($filter);
        }
		
		
		
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_DIRECTOR_PROYECTO) {
			$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, '=');
			$oCriteria->addFilter("$tProyecto.dt_fin", ((Date("Y"))-1).'-12-31', '>', new CdtCriteriaFormatStringValue());
			$filter = new CdtSimpleExpression("(CONCAT(docente.nu_precuil,'-',docente.nu_documento,'-',docente.nu_postcuil)='".$oUser->getDs_username()."' OR CONCAT(docente.nu_precuil,'-0',docente.nu_documento,'-',docente.nu_postcuil)='".$oUser->getDs_username()."')");
			$oCriteria->setExpresion($filter);	
			
			$oProyectoManager = ManagerFactory::getProyectoManager();
			
			$proyectos = $oProyectoManager->getEntities($oCriteria);
			$idProyectos="";
			foreach ($proyectos as $proyecto) {
				$idProyectos .=$proyecto->getOid().',';
			}
			$idProyectos = substr($idProyectos, 0, (strlen($idProyectos)-1));
			$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
             
            $filter = new CdtSimpleExpression( "$tProyecto.cd_proyecto IN (".$idProyectos.") AND ($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO."))");
			$criteria->setExpresion($filter);
        }
        
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_SECYT_PROYECTOS) {
			$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
            $criteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, "=");
            /*$filter = new CdtSimpleExpression( "dt_fin > '".((Date("Y"))-1)."-12-31'");
			$criteria->setExpresion($filter);*/
        }
		
		$criteria->addNull('fechaHasta');
		
		
		
	}




	


	public function getTipoIntegrante()
	{
	    return $this->tipoIntegrante;
	}

	public function setTipoIntegrante($tipoIntegrante)
	{
	    $this->tipoIntegrante = $tipoIntegrante;
	}

	



	public function getApellido()
	{
	    return $this->apellido;
	}

	public function setApellido($apellido)
	{
	    $this->apellido = $apellido;
	}

	

	public function getProyecto()
	{
	    return $this->proyecto;
	}

	public function setProyecto($proyecto)
	{
	    $this->proyecto = $proyecto;
	}

	public function getCodigo()
	{
	    return $this->codigo;
	}

	public function setCodigo($codigo)
	{
	    $this->codigo = $codigo;
	}

	public function getBl_pendiente()
	{
	    return $this->bl_pendiente;
	}

	public function setBl_pendiente($bl_pendiente)
	{
	    $this->bl_pendiente = $bl_pendiente;
	}

	public function getCuil()
	{
	    return $this->cuil;
	}

	public function setCuil($cuil)
	{
	    $this->cuil = $cuil;
	}
}