<?php

/**
 * Acción para visualizar un proyecto.
 *
 * @author Marcos
 * @since 18-09-2017
 *
 */
class ViewProyectoAction extends UpdateEntityInitAction {

	public function getNewFormInstance($action){
	
	}
	
	public function getSubmitAction(){
	
	}

	protected function getEntityManager(){
		return ManagerFactory::getProyectoManager();
	}

	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		return new ProyectoDirector();
	}
	

	protected function parseEntity($entity, XTemplate $xtpl) {

		$xtpl->assign ( 'lbl_codigo', CYT_LBL_PROYECTO_CODIGO);
		$xtpl->assign('codigo', $entity->getDs_codigo());
		
		$xtpl->assign ( 'lbl_titulo', CYT_LBL_PROYECTO_TITULO);
		$xtpl->assign('titulo', $entity->getDs_titulo());
		
		$xtpl->assign ( 'lbl_director', CYT_LBL_PROYECTO_DIRECTOR);
		$xtpl->assign('director', $entity->getDirector()->getDs_apellido().', '.$entity->getDirector()->getDs_nombre());
		
		$xtpl->assign ( 'lbl_inicio', CYT_LBL_PROYECTO_INICIO);
		$xtpl->assign('inicio', CYTSecureUtils::formatDateToView($entity->getDt_ini()));
		
		$xtpl->assign ( 'lbl_fin', CYT_LBL_PROYECTO_FIN);
		$xtpl->assign('fin', CYTSecureUtils::formatDateToView($entity->getDt_fin()));
		
		$xtpl->assign ( 'lbl_facultad', CYT_LBL_PROYECTO_FACULTAD);
		$xtpl->assign('facultad', $entity->getFacultad()->getDs_facultad());
		
		$xtpl->assign ( 'lbl_sigeva', CYT_LBL_PROYECTO_SIGEVA);
		$xtpl->assign('sigeva', $entity->getDs_codigoSIGEVA());
		
		$xtpl->assign ( 'lbl_estado', CYT_LBL_TIPO_ESTADO);
		$xtpl->assign('estado', $entity->getEstado()->getDs_estado());
		
		$xtpl->assign('abstract', $entity->getDs_abstract1());
		$xtpl->assign('abstracteng', $entity->getDs_abstracteng());
	
		$xtpl->assign('palabras_claves', $entity->getDs_clave1().' - '.$entity->getDs_clave2().' - '.$entity->getDs_clave3().' - '.$entity->getDs_clave4().' - '.$entity->getDs_clave5().' - '.$entity->getDs_clave6());
		$xtpl->assign('palabras_claveseng', $entity->getDs_claveeng1().' - '.$entity->getDs_claveeng2().' - '.$entity->getDs_claveeng3().' - '.$entity->getDs_claveeng4().' - '.$entity->getDs_claveeng5().' - '.$entity->getDs_claveeng6());
		
		
		if ($entity->getCd_unidad()) {
			$unidadManager = CYTSecureManagerFactory::getLugarTrabajoManager();
			$oUnidad = $unidadManager->getObjectByCode($entity->getCd_unidad());
			
		}
		
		
		$unidad = ($oUnidad)?$oUnidad:'';
		
		$xtpl->assign('unidad', $unidad);
		
		if ($entity->getDs_tipo()=='B'){		
				$ds_tipo =  "BASICA";
		}
		
		if ($entity->getDs_tipo()=='A'){		
			$ds_tipo =  "APLICADA" ;
		}
		
		if ($entity->getDs_tipo()=='D'){		
			$ds_tipo =  "DESARROLLO" ;
		}
		
		if ($entity->getDs_tipo()=='C'){		
			$ds_tipo =  "CREACION" ;
		}
		
		$xtpl->assign('linea', $entity->getDs_linea());
		
		$xtpl->assign('tipo_investigacion', $ds_tipo);
		
		if ($entity->getCd_disciplina()) {
			$disciplinaManager = CYTSecureManagerFactory::getDisciplinaManager();
			$oDisciplina = $disciplinaManager->getObjectByCode($entity->getCd_disciplina());
		}
		
		
		$disciplina = ($oDisciplina)?$oDisciplina->getDs_disciplina():'';
		
		if ($entity->getCd_especialidad()) {
			$especialidadManager = CYTSecureManagerFactory::getEspecialidadManager();
			$oEspecialidad = $especialidadManager->getObjectByCode($entity->getCd_especialidad());
		}
		
		$especialidad = ($oEspecialidad)?$oEspecialidad->getDs_especialidad():'';
		
		$xtpl->assign('especialidad', $disciplina.' - '.$especialidad);
		
		if ($entity->getCd_campo()) {
			$campoManager = CYTSecureManagerFactory::getCampoManager();
			$oCampo = $campoManager->getObjectByCode($entity->getCd_campo());
		}
		
		$campo = ($oCampo)?$oCampo->getDs_campo():'';
		
		$xtpl->assign('campo', $campo);
		
		$this->parseIntegrantes($entity->getOid(), $xtpl);
		
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtOutputAction::getLayout();
	 */
	protected function getLayout() {
		$oLayout = new CdtLayoutBasicAjax();
		return $oLayout;
	}

	private function parseIntegrantes( $proyecto_oid, XTemplate $xtpl ){
		$manager = ManagerFactory::getIntegranteManager();
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter("cd_proyecto", $proyecto_oid, "=" );
		$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
      	$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
        $filter = new CdtSimpleExpression( "($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO."))");
		$oCriteria->setExpresion($filter);
		$oCriteria->addNull('fechaHasta');
		$oCriteria->addOrder('docente.ds_apellido, docente.ds_nombre','ASC');
		$entities = $manager->getEntities($oCriteria);
		$xtpl->assign ( 'integrante_leyenda', CYT_MSG_INTEGRANTE_TITLE_LIST);
		
		$xtpl->assign ( 'lbl_tipoinvestigador', CYT_LBL_TIPO_INTEGRANTE);
		$xtpl->assign ( 'lbl_investigador', CYT_LBL_DOCENTE );
		$xtpl->assign ( 'lbl_cuil', CYT_LBL_INTEGRANTE_CUIL );
		$xtpl->assign ( 'lbl_categoria', CYT_LBL_INTEGRANTE_CATEGORIA );
		$xtpl->assign ( 'lbl_cargo', CYT_LBL_INTEGRANTE_CARGO);
		$xtpl->assign ( 'lbl_dedicacion', CYT_LBL_INTEGRANTE_DEDDOC );
		$xtpl->assign ( 'lbl_beca', CYT_LBL_INTEGRANTE_BECA );
		$xtpl->assign ( 'lbl_carrerainv', CYT_LBL_INTEGRANTE_CARRERAINV );
		$xtpl->assign ( 'lbl_alta', CYT_LBL_INTEGRANTE_ALTA );
		$xtpl->assign ( 'lbl_baja', CYT_LBL_INTEGRANTE_BAJA );
		$xtpl->assign ( 'lbl_facultadint', CYT_LBL_INTEGRANTE_FACULTAD );
		$xtpl->assign ( 'lbl_horasinv', CYT_LBL_INTEGRANTE_HORAS );
		$xtpl->assign ( 'lbl_estadoint', CYT_LBL_TIPO_ESTADO );
		
		
		
		foreach ($entities as $oEntity) {
			
			
			$xtpl->assign ( 'tipoinvestigador', $oEntity->getTipoIntegrante()->getDs_tipoinvestigador());
			$xtpl->assign ( 'investigador', $oEntity->getDocente()->getDs_apellido().', '.$oEntity->getDocente()->getDs_nombre());
			$xtpl->assign ( 'cuil', $oEntity->getDocente()->getNu_precuil().'-'.$oEntity->getDocente()->getNu_documento().'-'.$oEntity->getDocente()->getNu_postcuil());
			$xtpl->assign ( 'categoria', $oEntity->getCategoria()->getDs_categoria());
			$xtpl->assign ( 'cargo', $oEntity->getCargo()->getDs_cargo());
			$xtpl->assign ( 'dedicacion', $oEntity->getDeddoc()->getDs_deddoc());
			
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_docente', $oEntity->getDocente()->getOid(), '=');
			$oCriteria->addFilter('dt_hasta', date('Y-m-d'), '>', new CdtCriteriaFormatStringValue());
			$oBecaManager =  CYTSecureManagerFactory::getBecaManager();
			$oBeca = $oBecaManager->getEntity($oCriteria);
			$strBeca='';
			if (!empty($oBeca)) {
				$strOrg = ($oBeca->getBl_unlp())?'U.N.L.P.':'';
				$strBeca = $oBeca->getDs_tipobeca().' '.$strOrg;
				
			}
			elseif($oEntity->getDs_tipobeca()!='' ){
				
				
				$strBeca = $oEntity->getDs_tipobeca().' '.$oEntity->getDs_orgbeca();
				
			}
			$xtpl->assign ( 'beca', $strBeca);
			$xtpl->assign ( 'carrerainv', $oEntity->getCarreraInv()->getDs_carrerainv().' - '.$oEntity->getOrganismo()->getDs_codigo());
			$xtpl->assign ( 'alta', CYTSecureUtils::formatDateToView($oEntity->getDt_alta()));
			$xtpl->assign ( 'baja', CYTSecureUtils::formatDateToView($oEntity->getDt_baja()));
			
			
			$xtpl->assign('facultadint', $oEntity->getFacultad()->getDs_facultad());
			$xtpl->assign('horasinv', $oEntity->getNu_horasinv());
		
			$xtpl->assign('estadoint', $oEntity->getEstado()->getDs_estado());
			
			$xtpl->parse( 'main.integrante' );
		}
		
		
		
	}
	
	

	/**
	 * (non-PHPdoc)
	 * @see CdtOutputAction::getOutputTitle();
	 */
	protected function getOutputTitle() {
		return CYT_MSG_PROYECTO_PDF_TITLE;
	}

	/**
     * (non-PHPdoc)
     * @see CdtEditInitAction::getXTemplate();
     */
    protected function getXTemplate() {
        return new XTemplate(CYT_TEMPLATE_TEMPLATE_PROYECTO_VIEW);
    }	
}