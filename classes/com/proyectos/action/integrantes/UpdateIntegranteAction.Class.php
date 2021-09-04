<?php

/**
 * Acción para actualizar un integrante
 *
 * @author Marcos
 * @since 31-10-2013
 *
 */
class UpdateIntegranteAction extends UpdateEntityAction{

	protected function getEntity() {
	
		$entity = null;

		//recuperamos dado su identifidor.
		$oid = CdtUtils::getParam('id');
			
		if (!empty( $oid )) {
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('oid', $oid, '=');
			$oCriteria->addNull('fechaHasta');			
			$manager = $this->getEntityManager();
			$entity = $manager->getEntity($oCriteria);
		}else{
		
			$entity = parent::getEntity();
		
		}
		
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
    	
		if ($documento) {
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('nu_documento', $documento, '=');
				
			$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
			$oDocente = $oDocenteManager->getEntity($oCriteria);
			if (!empty($oDocente)) {
				$entity->setDocente($oDocente);
			}
		}
		else throw new GenericException( CYT_MSG_INTEGRANTE_CUIL_FORMAT );
		
		$dt_alta = CYT_YEAR.'-0'.CYT_PERIODO.'-01';
		if ($dt_alta<=CYTSecureUtils::formatDateToPersist($entity->getDt_cargo())) {
			$dt_alta=CYTSecureUtils::formatDateToPersist($entity->getDt_cargo());
		}
		if ($dt_alta<=CYTSecureUtils::formatDateToPersist($entity->getDt_beca())) {
			$dt_alta=CYTSecureUtils::formatDateToPersist($entity->getDt_beca());
		}
		if ($dt_alta<=CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimulo())) {
			$dt_alta=CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimulo());
		}
		$entity->setDt_alta($dt_alta);
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_INTEGRANTE_ALTA_CREADA);
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



	



}
