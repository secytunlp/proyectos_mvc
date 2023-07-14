<?php

/**
 * Acción para inicializar el contexto
 * para cambiar un colaborador.
 *
 * @author Marcos
 * @since 20-12-2016
 *
 */

class CambiarTipoInitAction extends UpdateEntityInitAction {

	
	protected function getEntity(){

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

		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerIntegrateEstado =  ManagerFactory::getIntegranteEstadoManager();
		$oIntegranteEstado = $managerIntegrateEstado->getEntity($oCriteria);
		if ((($oIntegranteEstado->getTipointegrante()->getOid()==CYT_TIPO_INTEGRANTE_DIRECTOR)||($oIntegranteEstado->getTipointegrante()->getOid()==CYT_TIPO_INTEGRANTE_CODIRECTOR)||($oIntegranteEstado->getTipointegrante()->getOid()==CYT_TIPO_INTEGRANTE_COLABORADOR))&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO)) {
			
			throw new GenericException( CYT_MSG_INTEGRANTE_CAMBIO_TIPO_PROHIBIDO);
		}

		if ($oIntegranteEstado->getDt_baja()&&($oIntegranteEstado->getDt_baja()!='0000-00-00')&&($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_BAJA_CREADA)) {
			throw new GenericException( CYT_MSG_INTEGRANTE_CAMBIO_PROHIBIDO3);
		}

        if ($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO) {
            throw new GenericException( CYT_MSG_INTEGRANTE_CAMBIO_TIPO_PROHIBIDO2);
        }
		
		
		if (($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_ADMITIDO)||($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO)) {
			
			$docenteManager = CYTSecureManagerFactory::getDocenteManager();
			$oDocente = $docenteManager->getObjectByCode($entity->getDocente()->getOid());
			
			$entity->setDs_apellido($oDocente->getDs_apellido());
			$entity->setDs_nombre($oDocente->getDs_nombre());
			$entity->setCuil($oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil());
            $entity->setNu_horasinvAnt(($entity->getNu_horasinvAnt())?$entity->getNu_horasinvAnt():$oIntegranteEstado->getNu_horasinv());
			return $entity;
			
			
		}
		else throw new GenericException( CYT_MSG_INTEGRANTE_CAMBIO_PROHIBIDO);
	}
	
	
	
	protected function getEntityManager(){
		return ManagerFactory::getIntegranteManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		
		return new CMPIntegranteCambioTipoForm($action);
	}
	
	protected function parseEntity($entity, XTemplate $xtpl) {

        $entity = CdtFormatUtils::ifEmpty($entity, $this->getNewEntityInstance());

        $this->getForm()->fillInputValues($entity);
        
		$inputCombo =  $this->getForm()->getInput("tipoIntegrante.oid");
		$inputCombo->setOptions( CYTSecureUtils::getTiposInvestigadorItems(CYT_TIPO_INVESTIGADOR_MOSTRADOS_CON_COLABORADOR) );

        $inputCombo =  $this->getForm()->getInput("dt_cambioHS");

        $inputCombo->setIsVisible(true);

        $inputCombo =  $this->getForm()->getInput("nu_horasinv");
        $inputCombo->addProperty( 'onChange', 'habilitarReduccion(this)' );
		
		//$this->getForm()->addHidden(FieldBuilder::buildInputHidden ( "hiddenApellido", ""));
        $xtpl->assign('formulario', $this->getForm()->show() );
        
    }

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		return new Integrante();
	}


	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_INTEGRANTE_TITLE_CAMBIAR_TIPO;
	}

	/**
	 * retorna el action para el submit.
	 * @return string
	 */
	protected function getSubmitAction(){
		return "cambiar_tipo";
	}


}