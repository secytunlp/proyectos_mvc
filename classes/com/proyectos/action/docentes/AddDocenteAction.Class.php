<?php

/**
 * AcciÃ³n para dar de alta un Docente
 *
 * @author Marcos
 * @since 10-06-2022
 *
 */
class AddDocenteAction extends AddEntityAction{

    protected function getEntity() {

        $entity =  parent::getEntity();

        //print_r($entity);

        $error = '';


        $separarCUIL = explode('-',trim($entity->getCuil1()));

        //print_r($separarCUIL);

        $preCuil = $separarCUIL[0];
        $documento = $separarCUIL[1];
        $posCuil = $separarCUIL[2];

        if (!$documento) {
            throw new GenericException( CYT_MSG_INTEGRANTE_CUIL_FORMAT );
        }




        $entity->setNu_precuil($preCuil);
        $entity->setNu_documento($documento);
        $entity->setNu_postcuil($posCuil);

        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addOrder('cd_docente','DESC');
        $oCriteria->setPage(1);
        $oCriteria->setRowPerPage(1);
        // $docentesManager = CYTSecureManagerFactory::getDocenteManager();
        $docentes = $this->getEntityManager()->getEntities($oCriteria);
        $cd_docente = $docentes->getObjectByIndex(0)->getOid()+1;
        $entity->setOid($cd_docente);

        //CYTSecureUtils::logObject($entity);

        return $entity;
    }


    /**
     * (non-PHPdoc)
     * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
     */
    public function getNewFormInstance(){

        return new CMPDocenteForm();
    }

    /**
     * (non-PHPdoc)
     * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
     */
    public function getNewEntityInstance(){
        $oDocente = new Docente();

        return $oDocente;
    }

    protected function getEntityManager(){
        return CYTSecureManagerFactory::getDocenteManager();
    }

    /**
     * (non-PHPdoc)
     * @see CdtEditAction::getForwardSuccess();
     */
    protected function getForwardSuccess(){
        return 'add_docente_success';

    }



}
