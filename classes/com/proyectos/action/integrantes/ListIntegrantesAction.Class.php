<?php

/**
 * Acción para listar integrantes.
 *
 * @author Marcos
 * @since 29-10-2013
 *
 */
class ListIntegrantesAction extends CMPEntityGridAction{


	protected function getComponent() {
		return new CMPIntegranteGrid();
	}


/**
	 * (non-PHPdoc)
	 * @see CdtAction::execute();
	 */
	public function execute(){
		
		//armamos el layout.
		$this->layout = $this->getLayout();
		
		try{
			$this->layout->setContent( $this->getOutputContent() );
			$this->layout->setTitle( $this->getOutputTitle() );
			$filter = new CMPIntegranteFilter();
			$filter->fillSavedProperties();
			$proyecto_oid = $filter->getProyecto()->getOid();
			if (!empty( $proyecto_oid )) {
				$oUser = CdtSecureUtils::getUserLogged();
				if ($oUser->getCd_usergroup()==CYT_CD_GROUP_DIRECTOR_PROYECTO) {
					$oCriteria = new CdtSearchCriteria();
					$oCriteria->addFilter("cd_proyecto", $proyecto_oid, "=" );
					$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
					$oCriteria->addFilter($tIntegranteEstado.".estado_oid", CYT_ESTADO_INTEGRANTE_ADMITIDO, '<>');
					$oCriteria->addNull('fechaHasta');
					$manager = ManagerFactory::getIntegranteManager();
					$entities = $manager->getEntities($oCriteria);
					if ($entities->size()>0) {
						$this->layout->setException( new GenericException('Tiene integrantes y/o colaboradores con estado pendiente (Alta creada, Alta Recibida, Baja Creada, Baja Recibida, Cambio Creado, Cambio Recibido, Cambio Hs. Creado y/o Cambio Hs. Recibido), para que estos cambios puedan hacerse efectivos debe "Enviarlos" desde la acción "Enviar", imprimir la planilla de solicitud y presentarla firmada en la Unidad Académica') );
					}
				}
				
			}
					
		}catch(GenericException $ex){
			//capturamos la excepciï¿½n y la parseamos en el layout.
			$this->layout->setException( $ex );
		}
		
		//mostramos la salida formada por el layout.
		echo $this->layout->show();
		
		//no hay forward.
		$forward = null;
				
		return $forward;
	}

}
