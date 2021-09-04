<?php

/**
 * Acción para exportar integrantes a xls
 *
 * @author Marcos
 * @since 13-06-2019
 *
 */
class ExportIntegranteXLSAction extends CdtAction{


     public function execute(){
          //CdtDbManager::begin_tran();

         $layout =  new CdtLayoutXls();
         $nombre = date(CYT_DATETIME_FORMAT_STRING).'_Integrantes';
         $layout->setFilename($nombre);

         try{
			$html .= "<table border=1'><tr><th>".CYT_LBL_PROYECTO."</th><th>".CYT_LBL_INTEGRANTE_TIPO_INTEGRANTE."</th><th>".CYT_LBL_DOCENTE."</th><th>".CYT_LBL_INTEGRANTE_CUIL."</th><th>".CYT_LBL_INTEGRANTE_CATEGORIA."</th><th>".CYT_LBL_INTEGRANTE_CARGO."</th><th>".CYT_LBL_INTEGRANTE_DEDDOC."</th><th>".CYT_LBL_INTEGRANTE_BECA."</th><th>".CYT_LBL_INTEGRANTE_CARRERAINV."</th><th>".CYT_LBL_INTEGRANTE_ALTA."</th><th>".CYT_LBL_INTEGRANTE_BAJA."</th><th>".CYT_LBL_INTEGRANTE_FACULTAD."</th><th>".CYT_LBL_INTEGRANTE_HORAS."</th><th>".CYT_LBL_TIPO_ESTADO."</th></tr>";
			
		$filtro = new CMPIntegranteFilter();
		$filtro->fillSavedProperties();			
	
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addOrder($filtro->getOrderBy(),$filtro->getOrderType());
		$oCriteria->setPage(1);
		$oCriteria->setRowPerPage(300000);
			
        //filtramos por proyecto.
		$proyecto = $filtro->getProyecto();
		if($proyecto!=null && $proyecto->getOid()!=null){
			$oCriteria->addFilter("cd_proyecto", $proyecto->getOid(), "=" );
		}
		
		$ds_codigo = $filtro->getCodigo();
		$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
		if(!empty($ds_codigo)){
			$oCriteria->addFilter($tProyecto.".ds_codigo", $ds_codigo, "like", new CdtCriteriaFormatLikeValue() );
		}
		
		//filtramos por tipo de integrante.
		$tipoIntegrante = $filtro->getTipoIntegrante();
		if($tipoIntegrante!=null && $tipoIntegrante->getOid()!=null){
			$oCriteria->addFilter("cd_tipoinvestigador", $tipoIntegrante->getOid(), "=" );
		}

		$apellido = $filtro->getApellido();
		$cuil = $filtro->getCuil();
		$oUser = CdtSecureUtils::getUserLogged();
		if(!empty($apellido)){
			$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
			$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
			$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
			$filter = new CdtSimpleExpression("($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO.")) AND ($tDocente.ds_apellido like '%".$apellido."%' OR $tDocente.ds_nombre like '%".$apellido."%')");
			$oCriteria->setExpresion($filter);
			
			//$oCriteria->addFilter("apellido", $apellido, "like", new CdtCriteriaFormatLikeValue() );
		}
		elseif(!empty($cuil)){
			$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
			$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
			$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
			$filter = new CdtSimpleExpression("($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO.")) AND (CONCAT($tDocente.nu_precuil,'-',$tDocente.nu_documento,'-',$tDocente.nu_postcuil) like '%".$cuil."%')");
			$oCriteria->setExpresion($filter);
			
			//$oCriteria->addFilter("apellido", $apellido, "like", new CdtCriteriaFormatLikeValue() );
		}
		else{
			if ($oUser->getCd_usergroup()!=CYT_CD_GROUP_ADMIN_PROYECTOS) {
				$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
				$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
				$filter = new CdtSimpleExpression("($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO."))");
				$oCriteria->setExpresion($filter);
			}
			
		}
		
		//filtramos por bl_pendiente.
		$bl_pendiente = $filtro->getBl_pendiente();
		if($bl_pendiente){
			$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
			
			
			$oCriteria->addFilter($tIntegranteEstado.".estado_oid", CYT_ESTADO_INTEGRANTE_ADMITIDO, '<>');
		}
		
		
		
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_ADMIN_FACULTAD_PROYECTOS) {
			$userManager = CYTSecureManagerFactory::getUserManager();
			$oUsuario = $userManager->getObjectByCode($oUser->getCd_user());
			//print_r($oUsuario);
			
			$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
            $tProyecto = DAOFactory::getProyectoDAO()->getTableName();
            $filter = new CdtSimpleExpression( "$tProyecto.cd_facultad ='".$oUsuario->getFacultad()->getOid()."' AND $tProyecto.cd_estado ='".CYT_ESTADO_PROYECTO_ACREDITADO."' AND $tProyecto.dt_fin > '".((Date("Y"))-1)."-12-31' AND ($tIntegrante.dt_baja is null OR $tIntegrante.dt_baja = '0000-00-00' OR $tIntegrante.dt_baja > $tIntegrante.dt_alta OR ($tIntegrante.dt_baja = $tIntegrante.dt_alta AND $tIntegranteEstado.estado_oid != ".CYT_ESTADO_INTEGRANTE_ADMITIDO."))");
			$oCriteria->setExpresion($filter);
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
			$oCriteria->setExpresion($filter);
        }
        
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_SECYT_PROYECTOS) {
			$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
            $oCriteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, "=");
            /*$filter = new CdtSimpleExpression( "dt_fin > '".((Date("Y"))-1)."-12-31'");
			$oCriteria->setExpresion($filter);*/
        }
		
		$oCriteria->addNull('fechaHasta');
			
			$managerIntegrante =  ManagerFactory::getIntegranteManager();
			$integrantes = $managerIntegrante->getEntities($oCriteria);
			$cant=0;
			
			foreach ($integrantes as $oIntegrante) {
				
				
				
				
		
			
		
				$carrera =($oIntegrante->getOrganismo()->getDs_codigo())?(($oIntegrante->getCarrerainv()->getDs_carrerainv())?utf8_decode($oIntegrante->getCarrerainv()->getDs_carrerainv().' - '.$oIntegrante->getOrganismo()->getDs_codigo()):$oIntegrante->getOrganismo()->getDs_codigo()):'';
				
				$strBeca = '';
				$oCriteria = new CdtSearchCriteria();
				$oCriteria->addFilter('cd_docente', $oIntegrante->getDocente()->getOid(), '=');
				$oCriteria->addFilter('dt_hasta', date('Y-m-d'), '>', new CdtCriteriaFormatStringValue());
				$oBecaManager =  CYTSecureManagerFactory::getBecaManager();
				$oBeca = $oBecaManager->getEntity($oCriteria);
				if (!empty($oBeca)) {
					$strOrg = ($oBeca->getBl_unlp())?'U.N.L.P.':'';
					$strBeca = utf8_decode($oBeca->getDs_tipobeca()).' '.$strOrg;
					
				}
				elseif($oIntegrante->getDs_tipobeca()!='' ){
					
					
					$strBeca = utf8_decode($oIntegrante->getDs_tipobeca()).' '.utf8_decode($oIntegrante->getDs_orgbeca());
					
				}
				elseif($oIntegrante->getBl_becaEstimulo() ){
					
					
					$strBeca = 'Beca de Estímulo a las Vocaciones Científicas';
					
				}
		
				
				$html .= "<tr><td>".$oIntegrante->getProyecto()->getDs_codigo()."</td><td>".$oIntegrante->getTipoIntegrante()->getDs_tipoinvestigador()."</td><td>".utf8_decode($oIntegrante->getDocente()->getDs_apellido()).', '.utf8_decode($oIntegrante->getDocente()->getDs_nombre())."</td><td>".$oIntegrante->getDocente()->getNu_precuil().'-'.$oIntegrante->getDocente()->getNu_documento().'-'.$oIntegrante->getDocente()->getNu_postcuil()."</td><td>".$oIntegrante->getCategoria()->getDs_categoria()."</td><td>".utf8_decode($oIntegrante->getCargo()->getDs_cargo())."</td><td>".$oIntegrante->getDeddoc()->getDs_deddoc()."</td><td>".$strBeca."</td><td>".$carrera."</td><td>".CYTSecureUtils::formatDateToView($oIntegrante->getDt_alta())."</td><td>".CYTSecureUtils::formatDateToView($oIntegrante->getDt_baja())."</td><td>".$oIntegrante->getFacultad()->getDs_facultad()."</td><td>".$oIntegrante->getNu_horasinv()."</td><td>".$oIntegrante->getEstado()->getDs_estado()."</td></tr>";
				
				
				$cant++;

				
			}
            $html .= "</table>"; 
             

             //armamos el layout.

             $layout->setContent(CdtUIUtils::encodeCharactersXls($html));
             $layout->setTitle("Integrantes");

             CdtDbManager::save();

         }catch(GenericException $ex){
             //capturamos la excepción y la parseamos en el layout.
             $layout->setException( $ex );
             CdtDbManager::undo();
         }

         //mostramos la salida formada por el layout.
         echo $layout->show();

         //no hay forward.
         $forward = null;

         return $forward;
     }

}
