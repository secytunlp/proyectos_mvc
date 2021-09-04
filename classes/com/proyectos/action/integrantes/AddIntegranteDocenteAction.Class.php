<?php

/**
 * Se trae el docente
 * 
 * @author Marcos
 * @since 05-11-2013
 *
 */
class AddIntegranteDocenteAction extends CdtAction{


	/**
	 * (non-PHPdoc)
	 * @see CdtAction::execute();
	 */
	public function execute(){

		
		$result = "";
		
		try{
			
			$cd_docente = CdtUtils::getParam("cd_docente");
			
			
			$docente = array();
			
			$docenteManager = CYTSecureManagerFactory::getDocenteManager();
			$oDocente = $docenteManager->getObjectByCode($cd_docente);
			
			$result['apellido']=$oDocente->getDs_apellido();
			$result['nombre']=$oDocente->getDs_nombre();
			$result['mail']=$oDocente->getDs_mail();
			$result['cuil']=$oDocente->getNu_precuil().'-'.str_pad($oDocente->getNu_documento(), 8, "0", STR_PAD_LEFT).'-'.$oDocente->getNu_postcuil();
			$result['categoria_oid']=$oDocente->getCategoria()->getOid();
			$result['carrerainv_oid']=$oDocente->getCarreraInv()->getOid();
			$result['organismo_oid']=$oDocente->getOrganismo()->getOid();
			$result['cargo_oid']=$oDocente->getCargo()->getOid();
			$result['dt_cargo']=($oDocente->getDt_cargo()!='0000-00-00')?CYTSecureUtils::formatDateToView($oDocente->getDt_cargo()):'';
			$result['deddoc_oid']=$oDocente->getDedDoc()->getOid();
			$result['facultad_oid']=$oDocente->getFacultad()->getOid();
			$result['lugarTrabajo_oid']=$oDocente->getLugarTrabajo()->getOid();
			$result['universidad_oid']=$oDocente->getUniversidad()->getOid();
			$result['titulo_oid']=$oDocente->getTitulo()->getOid();
			$result['titulopost_oid']=$oDocente->getTitulopost()->getOid();
			
			$result['ds_orgbeca']=$oDocente->getDs_orgbeca();
			$result['ds_tipobeca']=$oDocente->getDs_tipobeca();
			$result['dt_beca']=(($oDocente->getDt_beca()!='0000-00-00'))?CYTSecureUtils::formatDateToView($oDocente->getDt_beca()):'';
			$result['dt_becaHasta']=(($oDocente->getDt_becaHasta()!='0000-00-00'))?CYTSecureUtils::formatDateToView($oDocente->getDt_becaHasta()):'';
	
			$result['dt_becaEstimulo']=(($oDocente->getDt_becaEstimulo()!='0000-00-00'))?CYTSecureUtils::formatDateToView($oDocente->getDt_becaEstimulo()):'';
			$result['dt_becaEstimuloHasta']=(($oDocente->getDt_becaEstimuloHasta()!='0000-00-00'))?CYTSecureUtils::formatDateToView($oDocente->getDt_becaEstimuloHasta()):'';
			
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_docente', $cd_docente, '=');
			$oCriteria->addFilter('dt_hasta', date('Y-m-d'), '>', new CdtCriteriaFormatStringValue());
			$oBecaManager =  CYTSecureManagerFactory::getBecaManager();
			$oBeca = $oBecaManager->getEntity($oCriteria);
			if (!empty($oBeca)) {
				
				$ds_orgbeca =($oBeca->getBl_unlp())?'UNLP':'';
				
				$result['ds_orgbeca']= $ds_orgbeca;
				$result['ds_tipobeca']= $oBeca->getDs_tipobeca();
				$result['dt_beca']=CYTSecureUtils::formatDateToView($oBeca->getDt_desde());
				$result['dt_becaHasta']=CYTSecureUtils::formatDateToView($oBeca->getDt_hasta());
				
			}
			
			
		}catch(Exception $ex){
			
			$result['error'] = $ex->getMessage();
			
		}

		echo json_encode( $result ); 
		return null;
	}
	
	
	
}