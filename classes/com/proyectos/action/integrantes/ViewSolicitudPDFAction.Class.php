<?php

/**
 * Acción para exportar a pdf una solicitud.
 *
 * @author Marcos
 * @since 16-11-2016
 *
 */
class ViewSolicitudPDFAction extends CdtAction{

	
	/**
	 * (non-PHPdoc)
	 * @see CdtAction::execute()
	 */
	public function execute(){
		
		
		$oid = CdtUtils::getParam('id');
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('oid', $oid, '=');
		$oCriteria->addNull('fechaHasta');
		$oIntegranteManager = ManagerFactory::getIntegranteManager();
		$oIntegrante = $oIntegranteManager->getEntity($oCriteria);
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('integrante_oid', $oIntegrante->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $managerIntegranteEstado->getEntity($oCriteria);
		$pdf = new ViewSolicitudPDF();
		
		if ($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_ADMITIDO){
			throw new GenericException( CYT_MSG_INTEGRANTE_VER_PROHIBIDO);
		}
		
		//armamos el pdf con la data necesaria.
		$pdf->setYear(CYT_YEAR);
		$pdf->setEstado_oid($oIntegranteEstado->getEstado()->getOid());
		$pdf->setMes(CYT_PERIODO);
		$ds_tipointegrante = ($oIntegrante->getTipoIntegrante()->getOid()==CYT_INTEGRANTE_COLABORADOR)?'COLABORADOR':'INTEGRANTE';
		
		$pdf->setDs_tipointegrante($ds_tipointegrante);
		
		$pdf->setDs_tipoinvestigador($oIntegrante->getTipoIntegrante()->getDs_tipoinvestigador());
		
		$oProyectoManager = ManagerFactory::getProyectoManager();
		$oProyecto = $oProyectoManager->getObjectByCode($oIntegrante->getProyecto()->getOid());
		
		$pdf->setDs_facultad($oProyecto->getFacultad()->getDs_facultad());
		
		$pdf->setDs_titulo($oProyecto->getDs_titulo());
		
		$nuevaFecha = explode ( "-", $oProyecto->getDt_ini () );
		$yini = $nuevaFecha [0];
		$nuevaFecha = explode ( "-", $oProyecto->getDt_fin () );
		$yfin = $nuevaFecha [0];
		if (($yfin-$yini)==1){
			$ds_duracion = 'BIENAL';
		}
		if (($yfin-$yini)==3){	
			$ds_duracion =  "TETRA ANUAL";
		}
		
		$pdf->setDs_duracion($ds_duracion);
	
		$pdf->setDs_codigo($oProyecto->getDs_codigo());
		
		$pdf->setDt_ini($oProyecto->getDt_ini());
		
		$pdf->setDt_fin($oProyecto->getDt_fin());
	
		$pdf->setDs_director($oProyecto->getDirector()->getDs_apellido().', '.$oProyecto->getDirector()->getDs_nombre());
		
		switch ($oIntegranteEstado->getEstado()->getOid()) {
			case CYT_ESTADO_INTEGRANTE_ALTA_CREADA:
				$ds_tipo = 'ALTA';
			break;
			case CYT_ESTADO_INTEGRANTE_ALTA_RECIBIDA:
				$ds_tipo = 'ALTA';
			break;
			case CYT_ESTADO_INTEGRANTE_BAJA_CREADA:
				$ds_tipo = 'BAJA';
			break;
			case CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA:
				$ds_tipo = 'BAJA';
			break;
			case CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO:
				$ds_tipo = 'CAMBIO';
			break;
			case CYT_ESTADO_INTEGRANTE_CAMBIO_RECIBIDO:
				$ds_tipo = 'CAMBIO';
			break;
			case CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO:
				$ds_tipo = 'CAMBIODEDHS';
			break;
			case CYT_ESTADO_INTEGRANTE_CAMBIO_HS_RECIBIDO:
				$ds_tipo = 'CAMBIODEDHS';
			break;
			
		}
		
		$pdf->setDs_tipo($ds_tipo);
		
		$pdf->setDocente_oid($oIntegrante->getDocente()->getOid());
		
		$pdf->setDs_investigador($oIntegrante->getDocente()->getDs_apellido().', '.$oIntegrante->getDocente()->getDs_nombre());
		
		$pdf->setNu_cuil($oIntegrante->getDocente()->getNu_precuil().'-'.$oIntegrante->getDocente()->getNu_documento().'-'.$oIntegrante->getDocente()->getNu_postcuil());
	
		$pdf->setDs_categoria($oIntegrante->getCategoria()->getDs_categoria());	
		
		$pdf->setDs_titulogrado($oIntegrante->getTitulo()->getDs_titulo());
		
		$pdf->setNu_materias($oIntegrante->getNu_materias());
		
		$pdf->setDs_tituloposgrado($oIntegrante->getTitulopost()->getDs_titulo());
	
		$pdf->setDs_cargo($oIntegrante->getCargo()->getDs_cargo());	
		
		$pdf->setDt_cargo($oIntegrante->getDt_cargo());	
		
		$pdf->setDs_deddoc($oIntegrante->getDeddoc()->getDs_deddoc());	

		$pdf->setDs_facultadintegrante($oIntegrante->getFacultad()->getDs_facultad());	
	
		$pdf->setDs_universidad($oIntegrante->getUniversidad()->getDs_universidad());	
	
		$pdf->setDs_carrinv($oIntegrante->getCarreraInv()->getDs_carrerainv());	

		$pdf->setDs_organismo($oIntegrante->getOrganismo()->getDs_codigo());	
		
		$pdf->setDs_tipobeca($oIntegrante->getDs_tipobeca());
		
		$pdf->setDs_orgbeca($oIntegrante->getDs_orgbeca());
		
		$pdf->setDt_beca($oIntegrante->getDt_beca());	
		$pdf->setDt_becaHasta($oIntegrante->getDt_becaHasta());	
		
		$pdf->setDs_unidad($oIntegrante->getUnidad()->getDs_unidad());	
		
		$pdf->setNu_horasinv($oIntegrante->getNu_horasinv());
	
		$pdf->setBl_becaEstimulo($oIntegrante->getBl_becaEstimulo());
		
		$pdf->setDt_becaEstimulo($oIntegrante->getDt_becaEstimulo());	
		$pdf->setDt_becaEstimuloHasta($oIntegrante->getDt_becaEstimuloHasta());	
			
	
		$oCriteria = new CdtSearchCriteria();
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
		$tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
		$oCriteria->addFilter("$tDocente.cd_docente", $oIntegrante->getDocente()->getOid(), '=');
		$oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
		//$oCriteria->addFilter("$tIntegrante.cd_tipoinvestigador", CYT_INTEGRANTE_COLABORADOR, '<>');
		$oCriteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, '=');
		$oCriteria->addFilter("$tProyecto.cd_proyecto", $oIntegrante->getProyecto()->getOid(), '<>');
		$filter = new CdtSimpleExpression("((".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." AND ".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." AND ".$tIntegrante.".dt_baja > '".date('Y-m-d')."') OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");
		$oCriteria->setExpresion($filter);
		$twoYearAgo = intval(CYT_YEAR)-1;
		$oCriteria->addFilter('dt_fin', $twoYearAgo.CYT_DIA_MES_PROYECTO_FIN, '>', new CdtCriteriaFormatStringValue());
		
		//proyectos.
		$proyectosManager = CYTSecureManagerFactory::getProyectoManager();
		$pdf->setProyectos($proyectosManager->getEntities($oCriteria));
		
		$pdf->setDt_alta($oIntegrante->getDt_alta());
		$pdf->setDt_baja($oIntegrante->getDt_baja());
		$pdf->setDs_consecuencias($oIntegrante->getDs_consecuencias());
		$pdf->setDs_motivos($oIntegrante->getDs_motivos());
		
		$pdf->setNu_horasinvAnt($oIntegrante->getNu_horasinvAnt());
		$pdf->setDt_cambioHS($oIntegrante->getDt_cambioHS());
		$pdf->setDs_reduccionHS($oIntegrante->getDs_reduccionHS());
	
	/*private $dt_baja = "";
	
	private $ds_consecuencias = "";
	
	private $ds_motivos = "";
	
	
	
	private $dt_cargo = "";
	
	private $dt_beca = "";
	
	private $nu_materias = "";
	
	private $nu_horasinvAnt = "";
	
	private $ds_reduccionHS = "";
	
	private $minhstotales = "";*/
		
    	
		$pdf->title = CYT_MSG_SOLICITUD_PDF_TITLE;
		$pdf->SetFont('Arial','', 13);
		
		// establecemos los márgenes
		$pdf->SetMargins(10, 20 , 10);
		$pdf->setMaxWidth($pdf->w - $pdf->lMargin - $pdf->rMargin);
		//$pdf->SetAutoPageBreak(true,90);
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		//imprimimos la solicitud.
		$pdf->printSolicitud();
		
		$pdf->Output();

		//para que no haga el forward.
		$forward = null;

		return $forward;
	}


}