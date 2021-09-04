<?php

/**
 * Acción para cambiar un colaborador
 *
 * @author Marcos
 * @since 20-12-2016
 *
 */
class CambiarIntegranteAction extends EditEntityAction{
	
/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::edit();
	 */
	protected function edit( $entity ){
		$this->getEntityManager()->cambio( $entity );
		$result["oid"] = $entity->getOid();		
		return $result;
	}

	protected function getEntity() {
	
		$entity =  parent::getEntity();
		
		//print_r($entity);
		
		$error = '';
		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= CYT_YEAR.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= CYT_PERIODO.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $entity->getProyecto()->getOid().'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$separarCUIL = explode('-',trim($entity->getCuil()));
		$dir .= $separarCUIL[1].'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		
		if(isset($_SESSION['archivos'])){
			$archivos = unserialize( $_SESSION['archivos'] );
			
			foreach ($archivos as $key => $archivo) {
				//CdtUtils::log("FILE: "   . $key.' - '.$archivo['name']);
				switch ($key) {
            		case 'ds_curriculum':
            		$nombre = CYT_LBL_INTEGRANTE_CURRICULUM;
            		$sigla = CYT_LBL_INTEGRANTE_CURRICULUM_SIGLA;
            		break;
            		case 'ds_actividades':
            		$nombre = CYT_LBL_INTEGRANTE_PLAN;
            		$sigla = CYT_LBL_INTEGRANTE_PLAN_SIGLA;
            		break;
            		case 'ds_resolucionBeca':
            		$nombre = CYT_LBL_INTEGRANTE_RESOLUCION_BECA;
            		$sigla = CYT_LBL_INTEGRANTE_RESOLUCION_BECA_SIGLA;
            		break;
	            }
				$explode_name = explode('.', $archivo['name']);
	            //Se valida así y no con el mime type porque este no funciona par algunos programas
	            $pos_ext = count($explode_name) - 1;
	            if (in_array(strtolower($explode_name[$pos_ext]), explode(",",CYT_EXTENSIONES_PERMITIDAS))) {
	            	//CdtUtils::log("FILE: "   . $key.' - '.$archivo['name']);
	            	if (is_file($dir.$archivo['nuevo'])){
	            		rename ($dir.$archivo['nuevo'],$dir.str_replace('TMP_'.$sigla, $sigla, $archivo['nuevo'])); 
	            	}
	            	CdtReflectionUtils::doSetter( $entity, $key, str_replace('TMP_'.$sigla, $sigla, $archivo['nuevo']) );
	            }
	            else {
	            	
	            	$error .=CYT_MSG_FORMATO_INVALIDO.$nombre.'<br />';
	            }
			}
		}
		//unset($_SESSION['archivos']);
		$handle=opendir($dir);
		while ($archivo = readdir($handle)){
	        if ((is_file($dir.$archivo))&&(strchr($archivo,'TMP_'))){
	         	unlink($dir.$archivo);
			}
		}
		closedir($handle);
		if ($error) {
			throw new GenericException( $error );
		}
	
		$separarCUIL = explode('-',trim($entity->getCuil()));

		$preCuil = $separarCUIL[0]; 
		$documento = $separarCUIL[1]; 
		$posCuil = $separarCUIL[2]; 
    	
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('nu_documento', $documento, '=');
			
		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getEntity($oCriteria);
		if (!empty($oDocente)) {
			$entity->setDocente($oDocente);
		}
		$dt_alta = CYT_YEAR.'-0'.CYT_PERIODO.'-01';
		
		if ($dt_alta<=CYTSecureUtils::formatDateToPersist($entity->getDt_cargo())) {
			$dt_alta=$entity->getDt_cargo();
		}
		if ($dt_alta<=CYTSecureUtils::formatDateToPersist($entity->getDt_beca())) {
			$dt_alta=$entity->getDt_beca();
		}
		if ($dt_alta<=CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimulo())) {
			$dt_alta=$entity->getDt_becaEstimulo();
		}
		$entity->setDt_alta($dt_alta);
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO);
		$entity->setEstado($oEstado);
		//CYTSecureUtils::logObject($entity);
	
		return $entity;
	}
	
	
	public function getNewFormInstance(){
		return new CMPIntegranteUpDateForm();
	}

	public function getNewEntityInstance(){
		$oIntegrante = new Integrante();
		
		return $oIntegrante;
	}

	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}


	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getForwardSuccess();
	 */
	protected function getForwardSuccess(){
		return 'cambio_integrante_success';
	
	}
	



}
