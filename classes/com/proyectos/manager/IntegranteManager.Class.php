<?php

/**
 * Manager para Integrante
 *
 * @author Marcos
 * @since 30-10-2013
 */
class IntegranteManager extends EntityManager{

    public function getDAO(){
        return DAOFactory::getIntegranteDAO();
    }

    public function add(Entity $entity) {
        if (!$entity->getDocente()->getOid()) {
            $oDocente = new Docente();
            $oDocente->setDs_nombre($entity->getDs_nombre());
            $oDocente->setDs_apellido($entity->getDs_apellido());

            $separarCUIL = explode('-',trim($entity->getCuil()));
            $preCuil = $separarCUIL[0];
            $documento = $separarCUIL[1];
            $posCuil = $separarCUIL[2];

            $oDocente->setNu_precuil($preCuil);
            $oDocente->setNu_documento($documento);
            $oDocente->setNu_postcuil($posCuil);

            if ($entity->getCarrerainv()) {
                $oDocente->setCarreraInv($entity->getCarrerainv());
            }

            if ($entity->getOrganismo()) {
                $oDocente->setOrganismo($entity->getOrganismo());
            }

            if ($entity->getCargo()) {
                $oDocente->setCargo($entity->getCargo());
            }

            $oDocente->setDt_cargo($entity->getDt_cargo());

            if ($entity->getDeddoc()) {
                $oDocente->setDeddoc($entity->getDeddoc());
            }

            if ($entity->getFacultad()) {
                $oDocente->setFacultad($entity->getFacultad());
            }

            if ($entity->getUnidad()) {
                $oDocente->setLugarTrabajo($entity->getUnidad());
            }

            if ($entity->getDs_tipobeca()) {
                $oDocente->setBl_becario(1);
                $oDocente->setDs_tipobeca($entity->getDs_tipobeca());
            }

            if ($entity->getDs_orgbeca()) {
                $oDocente->setBl_becario(1);
                $oDocente->setDs_orgbeca($entity->getDs_orgbeca());
                $oDocente->setDt_beca($entity->getDt_beca());
                $oDocente->setDt_becaHasta($entity->getDt_becaHasta());
            }

            $oDocente->setDs_mail($entity->getDs_mail());

            if ($entity->getTitulo()) {
                $oDocente->setTitulo($entity->getTitulo());
            }

            if ($entity->getTitulopost()) {
                $oDocente->setTitulopost($entity->getTitulopost());
            }

            if ($entity->getUniversidad()) {
                $oDocente->setUniversidad($entity->getUniversidad());
            }

            if ($entity->getBl_becaEstimulo()) {
                $oDocente->setBl_becaEstimulo(1);
                $oDocente->setDt_becaEstimulo($entity->getDt_becaEstimulo());
                $oDocente->setDt_becaEstimuloHasta($entity->getDt_becaEstimuloHasta());
            }

            $oCriteria = new CdtSearchCriteria();
            $oCriteria->addOrder('cd_docente','DESC');
            $oCriteria->setPage(1);
            $oCriteria->setRowPerPage(1);
            $docentesManager = CYTSecureManagerFactory::getDocenteManager();
            $docentes = $docentesManager->getEntities($oCriteria);
            $cd_docente = $docentes->getObjectByIndex(0)->getOid()+1;
            $oDocente->setOid($cd_docente);
            //print_r($oDocente);

            $docentesManager->add($oDocente);
            $entity->setDocente($oDocente);
            $categoria = new Categoria();
            $categoria->setOid(CYT_CD_SIN_CATEGORIA);
            $entity->setCategoria($categoria);

        }
        try{
            parent::add($entity);
            $oIntegranteEstado = new IntegranteEstado();
            $oIntegranteEstado->setIntegrante($entity);
            $oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
            $oIntegranteEstado->setEstado($entity->getEstado());
            $oIntegranteEstado->setTipoIntegrante($entity->getTipoIntegrante());
            $oIntegranteEstado->setCargo($entity->getCargo());
            $oIntegranteEstado->setDeddoc($entity->getDeddoc());
            $oIntegranteEstado->setCategoria($entity->getCategoria());
            $oIntegranteEstado->setFacultad($entity->getFacultad());

            $oIntegranteEstado->setCarreraInv($entity->getCarreraInv());
            $oIntegranteEstado->setOrganismo($entity->getOrganismo());
            $oIntegranteEstado->setDt_alta($entity->getDt_alta());
            $oIntegranteEstado->setDs_orgbeca($entity->getDs_orgbeca());
            $oIntegranteEstado->setDs_tipobeca($entity->getDs_tipobeca());
            $oIntegranteEstado->setDt_beca($entity->getDt_beca());
            $oIntegranteEstado->setDt_becaHasta($entity->getDt_becaHasta());
            $oIntegranteEstado->setBl_becaEstimulo($entity->getBl_becaEstimulo());
            $oIntegranteEstado->setDt_becaEstimulo($entity->getDt_becaEstimulo());
            $oIntegranteEstado->setDt_becaEstimuloHasta($entity->getDt_becaEstimuloHasta());

            $oIntegranteEstado->setDt_alta($entity->getDt_alta());
            $oIntegranteEstado->setDt_baja($entity->getDt_baja());
            $oIntegranteEstado->setDt_cambio($entity->getDt_cambioHS());
            $oIntegranteEstado->setNu_horasinv($entity->getNu_horasinv());
            $oIntegranteEstado->setDs_consecuencias($entity->getDs_consecuencias());
            $oIntegranteEstado->setDs_motivos($entity->getDs_motivos());
            $oIntegranteEstado->setDs_reduccionHS($entity->getDs_reduccionHS());

            $oUser = CdtSecureUtils::getUserLogged();
            $oIntegranteEstado->setUser($oUser);
            $oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
            $managerIntegranteEstado = ManagerFactory::getIntegranteEstadoManager();
            $managerIntegranteEstado->add($oIntegranteEstado);
        }catch(Exception $ex){
            if ($ex->getCode()=='1062') {
                $oCriteria = new CdtSearchCriteria();
                $oCriteria->addFilter('cd_docente', $entity->getDocente()->getOid(), '=');
                $oCriteria->addFilter('cd_proyecto', $entity->getProyecto()->getOid(), '=');
                $oCriteria->addNull('fechaHasta');
                $integranteManager = ManagerFactory::getIntegranteManager();
                $oIntegrante = $integranteManager->getEntity($oCriteria);
                if (($oIntegrante)&&($oIntegrante->getDt_alta()==$oIntegrante->getDt_baja())&&($oIntegrante->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_ADMITIDO)) {
                    $entity->setOid($oIntegrante->getOid());
                    $oIntegranteEstado = new IntegranteEstado();
                    $oIntegranteEstado->setIntegrante($entity);
                    $oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
                    $oIntegranteEstado->setEstado($entity->getEstado());
                    $oIntegranteEstado->setTipoIntegrante($entity->getTipoIntegrante());
                    $oIntegranteEstado->setCargo($entity->getCargo());
                    $oIntegranteEstado->setDeddoc($entity->getDeddoc());
                    $oIntegranteEstado->setCategoria($entity->getCategoria());
                    $oIntegranteEstado->setFacultad($entity->getFacultad());
                    $oIntegranteEstado->setCarreraInv($entity->getCarreraInv());
                    $oIntegranteEstado->setOrganismo($entity->getOrganismo());
                    $oIntegranteEstado->setDt_alta($entity->getDt_alta());
                    $oIntegranteEstado->setDs_orgbeca($entity->getDs_orgbeca());
                    $oIntegranteEstado->setDs_tipobeca($entity->getDs_tipobeca());
                    $oIntegranteEstado->setDt_beca($entity->getDt_beca());
                    $oIntegranteEstado->setDt_becaHasta($entity->getDt_becaHasta());
                    $oIntegranteEstado->setBl_becaEstimulo($entity->getBl_becaEstimulo());
                    $oIntegranteEstado->setDt_becaEstimulo($entity->getDt_becaEstimulo());
                    $oIntegranteEstado->setDt_becaEstimuloHasta($entity->getDt_becaEstimuloHasta());
                    $oIntegranteEstado->setDt_alta($entity->getDt_alta());
                    $oIntegranteEstado->setDt_baja($entity->getDt_baja());
                    $oIntegranteEstado->setDt_cambio($entity->getDt_cambioHS());
                    $oIntegranteEstado->setNu_horasinv($entity->getNu_horasinv());
                    $oIntegranteEstado->setDs_consecuencias($entity->getDs_consecuencias());
                    $oIntegranteEstado->setDs_motivos($entity->getDs_motivos());
                    $oIntegranteEstado->setDs_reduccionHS($entity->getDs_reduccionHS());
                    $oIntegranteEstado->setMotivo('Nueva alta');
                    $oUser = CdtSecureUtils::getUserLogged();
                    $oIntegranteEstado->setUser($oUser);
                    $oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));

                    $this->cambiarEstado($entity, $oIntegranteEstado);
                }
                else{
                    throw new DBException('El investigador ya forma parte del proyecto');
                }
            }
            else
                throw new DBException($ex->getMessage());

        }


        unset($_SESSION['archivos']);
    }

    public function update(Entity $entity) {

        parent::update($entity);

        $oIntegranteEstado = new IntegranteEstado();
        $oIntegranteEstado->setIntegrante($entity);
        $oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
        $oIntegranteEstado->setEstado($entity->getEstado());
        $oIntegranteEstado->setTipoIntegrante($entity->getTipoIntegrante());
        $oIntegranteEstado->setCargo($entity->getCargo());
        $oIntegranteEstado->setDeddoc($entity->getDeddoc());
        $oIntegranteEstado->setCategoria($entity->getCategoria());
        $oIntegranteEstado->setFacultad($entity->getFacultad());
        $oIntegranteEstado->setCarreraInv($entity->getCarreraInv());
        $oIntegranteEstado->setOrganismo($entity->getOrganismo());
        $oIntegranteEstado->setDt_alta($entity->getDt_alta());
        $oIntegranteEstado->setDs_orgbeca($entity->getDs_orgbeca());
        $oIntegranteEstado->setDs_tipobeca($entity->getDs_tipobeca());
        $oIntegranteEstado->setDt_beca($entity->getDt_beca());
        $oIntegranteEstado->setDt_becaHasta($entity->getDt_becaHasta());
        $oIntegranteEstado->setBl_becaEstimulo($entity->getBl_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimulo($entity->getDt_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimuloHasta($entity->getDt_becaEstimuloHasta());
        $oIntegranteEstado->setDt_alta($entity->getDt_alta());
        $oIntegranteEstado->setDt_baja($entity->getDt_baja());
        $oIntegranteEstado->setDt_cambio($entity->getDt_cambioHS());
        $oIntegranteEstado->setNu_horasinv($entity->getNu_horasinv());
        $oIntegranteEstado->setDs_consecuencias($entity->getDs_consecuencias());
        $oIntegranteEstado->setDs_motivos($entity->getDs_motivos());
        $oIntegranteEstado->setDs_reduccionHS($entity->getDs_reduccionHS());
        $oIntegranteEstado->setMotivo('Modificacion de alta');
        $oUser = CdtSecureUtils::getUserLogged();
        $oIntegranteEstado->setUser($oUser);
        $oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));

        $this->cambiarEstado($entity, $oIntegranteEstado);
        unset($_SESSION['archivos']);
    }

    public function updatesinvalidar(Entity $entity) {

        $this->getDAO()->updateEntity($entity);

    }

    public function cambio(Entity $entity) {
        //print_r($entity);
        parent::update($entity);
        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('oid', $entity->getOid(), '=');
        $oCriteria->addNull('fechaHasta');
        $integranteManager = ManagerFactory::getIntegranteManager();
        $oIntegrante = $integranteManager->getEntity($oCriteria);
        //print_r($oIntegrante);
        $oIntegranteEstado = new IntegranteEstado();
        $oIntegranteEstado->setIntegrante($oIntegrante);
        $oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
        $oIntegranteEstado->setEstado($oIntegrante->getEstado());
        $oIntegranteEstado->setTipoIntegrante($oIntegrante->getTipoIntegrante());
        $oIntegranteEstado->setCargo($oIntegrante->getCargo());
        $oIntegranteEstado->setDeddoc($oIntegrante->getDeddoc());
        $oIntegranteEstado->setCategoria($oIntegrante->getCategoria());
        $oIntegranteEstado->setFacultad($oIntegrante->getFacultad());
        $oIntegranteEstado->setCarreraInv($oIntegrante->getCarreraInv());
        $oIntegranteEstado->setOrganismo($oIntegrante->getOrganismo());
        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDs_orgbeca($oIntegrante->getDs_orgbeca());
        $oIntegranteEstado->setDs_tipobeca($oIntegrante->getDs_tipobeca());
        $oIntegranteEstado->setDt_beca($oIntegrante->getDt_beca());
        $oIntegranteEstado->setDt_becaHasta($oIntegrante->getDt_becaHasta());
        $oIntegranteEstado->setBl_becaEstimulo($oIntegrante->getBl_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimulo($oIntegrante->getDt_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimuloHasta($oIntegrante->getDt_becaEstimuloHasta());
        $oIntegranteEstado->setDt_alta($entity->getDt_alta());
        $oIntegranteEstado->setDt_baja($oIntegrante->getDt_baja());
        $oIntegranteEstado->setDt_cambio($oIntegrante->getDt_cambioHS());
        $oIntegranteEstado->setNu_horasinv($oIntegrante->getNu_horasinv());
        $oIntegranteEstado->setDs_consecuencias($oIntegrante->getDs_consecuencias());
        $oIntegranteEstado->setDs_motivos('');
        $oIntegranteEstado->setDs_reduccionHS($oIntegrante->getDs_reduccionHS());

        $oUser = CdtSecureUtils::getUserLogged();
        $oIntegranteEstado->setUser($oUser);
        $oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
        //print_r($oIntegranteEstado);
        $this->cambiarEstado($oIntegrante, $oIntegranteEstado);
        unset($_SESSION['archivos']);
    }

    public function cambioHS(Entity $entity) {
        //print_r($entity);
        $this->validateOnCambioHS($entity);
        parent::update($entity);

        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('oid', $entity->getOid(), '=');
        $oCriteria->addNull('fechaHasta');
        $integranteManager = ManagerFactory::getIntegranteManager();
        $oIntegrante = $integranteManager->getEntity($oCriteria);
        //print_r($oIntegrante);
        $oIntegranteEstado = new IntegranteEstado();
        $oIntegranteEstado->setIntegrante($oIntegrante);
        $oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
        $oIntegranteEstado->setEstado($oIntegrante->getEstado());
        $oIntegranteEstado->setTipoIntegrante($oIntegrante->getTipoIntegrante());
        $oIntegranteEstado->setCargo($oIntegrante->getCargo());
        $oIntegranteEstado->setDeddoc($oIntegrante->getDeddoc());
        $oIntegranteEstado->setCategoria($oIntegrante->getCategoria());
        $oIntegranteEstado->setFacultad($oIntegrante->getFacultad());
        $oIntegranteEstado->setCarreraInv($oIntegrante->getCarreraInv());
        $oIntegranteEstado->setOrganismo($oIntegrante->getOrganismo());
        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDs_orgbeca($oIntegrante->getDs_orgbeca());
        $oIntegranteEstado->setDs_tipobeca($oIntegrante->getDs_tipobeca());
        $oIntegranteEstado->setDt_beca($oIntegrante->getDt_beca());
        $oIntegranteEstado->setDt_becaHasta($oIntegrante->getDt_becaHasta());
        $oIntegranteEstado->setBl_becaEstimulo($oIntegrante->getBl_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimulo($oIntegrante->getDt_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimuloHasta($oIntegrante->getDt_becaEstimuloHasta());
        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDt_baja($oIntegrante->getDt_baja());
        $oIntegranteEstado->setDt_cambio($entity->getDt_cambioHS());
        $oIntegranteEstado->setNu_horasinv($entity->getNu_horasinv());
        $oIntegranteEstado->setDs_consecuencias($oIntegrante->getDs_consecuencias());
        $oIntegranteEstado->setDs_motivos('');
        $oIntegranteEstado->setDs_reduccionHS($oIntegrante->getDs_reduccionHS());

        $oUser = CdtSecureUtils::getUserLogged();
        $oIntegranteEstado->setUser($oUser);
        $oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
        //print_r($oIntegranteEstado);
        $this->cambiarEstado($oIntegrante, $oIntegranteEstado);
        unset($_SESSION['archivos']);
    }

    public function cambioTipo(Entity $entity) {
        //print_r($entity);
        $this->validateOnCambioTipo($entity);
        //$this->updatesinvalidar($entity);
        parent::update($entity);

        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('oid', $entity->getOid(), '=');
        $oCriteria->addNull('fechaHasta');
        $integranteManager = ManagerFactory::getIntegranteManager();
        $oIntegrante = $integranteManager->getEntity($oCriteria);
        $motivo='';
        //CYTSecureUtils::logObject($oIntegrante);
        //print_r($oIntegrante);
        $oIntegranteEstado = new IntegranteEstado();
        $oIntegranteEstado->setIntegrante($oIntegrante);
        $oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
        $oIntegranteEstado->setEstado($oIntegrante->getEstado());
        $oIntegranteEstado->setTipoIntegrante($oIntegrante->getTipoIntegrante());
        $oIntegranteEstado->setCargo($oIntegrante->getCargo());
        $oIntegranteEstado->setDeddoc($oIntegrante->getDeddoc());
        $oIntegranteEstado->setCategoria($oIntegrante->getCategoria());
        $oIntegranteEstado->setFacultad($oIntegrante->getFacultad());
        $oIntegranteEstado->setCarreraInv($oIntegrante->getCarreraInv());
        $oIntegranteEstado->setOrganismo($oIntegrante->getOrganismo());
        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDs_orgbeca($oIntegrante->getDs_orgbeca());
        $oIntegranteEstado->setDs_tipobeca($oIntegrante->getDs_tipobeca());
        $oIntegranteEstado->setDt_beca($oIntegrante->getDt_beca());
        $oIntegranteEstado->setDt_becaHasta($oIntegrante->getDt_becaHasta());
        $oIntegranteEstado->setBl_becaEstimulo($oIntegrante->getBl_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimulo($oIntegrante->getDt_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimuloHasta($oIntegrante->getDt_becaEstimuloHasta());
        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDt_baja($oIntegrante->getDt_baja());
        $oIntegranteEstado->setDt_cambio($entity->getDt_cambioHS());
        $oIntegranteEstado->setNu_horasinv($entity->getNu_horasinv());
        $oIntegranteEstado->setDs_consecuencias($oIntegrante->getDs_consecuencias());
        $oIntegranteEstado->setDs_motivos('');
        $oIntegranteEstado->setDs_reduccionHS($oIntegrante->getDs_reduccionHS());

        $oUser = CdtSecureUtils::getUserLogged();
        $oIntegranteEstado->setUser($oUser);
        $oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
        //print_r($oIntegranteEstado);
        $this->cambiarEstado($oIntegrante, $oIntegranteEstado);
        unset($_SESSION['archivos']);
    }


    public function baja(Entity $entity) {
        //print_r($entity);
        $this->validateOnBaja($entity);
        $this->getDAO()->updateBaja($entity);
        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('oid', $entity->getOid(), '=');
        $oCriteria->addNull('fechaHasta');
        $integranteManager = ManagerFactory::getIntegranteManager();
        $oIntegrante = $integranteManager->getEntity($oCriteria);
        //print_r($oIntegrante);
        $oIntegranteEstado = new IntegranteEstado();
        $oIntegranteEstado->setIntegrante($oIntegrante);
        $oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
        $oIntegranteEstado->setEstado($oIntegrante->getEstado());
        $oIntegranteEstado->setTipoIntegrante($oIntegrante->getTipoIntegrante());
        $oIntegranteEstado->setCargo($oIntegrante->getCargo());
        $oIntegranteEstado->setDeddoc($oIntegrante->getDeddoc());
        $oIntegranteEstado->setCategoria($oIntegrante->getCategoria());
        $oIntegranteEstado->setFacultad($oIntegrante->getFacultad());
        $oIntegranteEstado->setCarreraInv($oIntegrante->getCarreraInv());
        $oIntegranteEstado->setOrganismo($oIntegrante->getOrganismo());
        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDs_orgbeca($oIntegrante->getDs_orgbeca());
        $oIntegranteEstado->setDs_tipobeca($oIntegrante->getDs_tipobeca());
        $oIntegranteEstado->setDt_beca($oIntegrante->getDt_beca());
        $oIntegranteEstado->setDt_becaHasta($oIntegrante->getDt_becaHasta());
        $oIntegranteEstado->setBl_becaEstimulo($oIntegrante->getBl_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimulo($oIntegrante->getDt_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimuloHasta($oIntegrante->getDt_becaEstimuloHasta());
        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDt_baja($entity->getDt_baja());
        $oIntegranteEstado->setDt_cambio($oIntegrante->getDt_cambioHS());
        $oIntegranteEstado->setNu_horasinv($oIntegrante->getNu_horasinv());
        $oIntegranteEstado->setDs_consecuencias($oIntegrante->getDs_consecuencias());
        $oIntegranteEstado->setDs_motivos($oIntegrante->getDs_motivos());
        $oIntegranteEstado->setDs_reduccionHS($oIntegrante->getDs_reduccionHS());

        $oUser = CdtSecureUtils::getUserLogged();
        $oIntegranteEstado->setUser($oUser);
        $oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
        //print_r($oIntegranteEstado);
        $this->cambiarEstado($oIntegrante, $oIntegranteEstado);
    }

    /**
     * se elimina la entity
     * @param int identificador de la entity a eliminar.
     */
    public function delete($id) {
        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('integrante_oid', $id, '=');
        $oCriteria->addNull('fechaHasta');
        $managerIntegranteEstadoManager =  ManagerFactory::getIntegranteEstadoManager();
        $oIntegranteEstado = $managerIntegranteEstadoManager->getEntity($oCriteria);
        if (($oIntegranteEstado->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_ALTA_CREADA)) {

            throw new GenericException( CYT_MSG_INTEGRANTE_ELIMINAR_PROHIBIDO);
        }
        else{

            $oIntegranteManager = ManagerFactory::getIntegranteManager();
            $oIntegrante = $oIntegranteManager->getObjectByCode($id);
            $oIntegranteEstadoDAO =  DAOFactory::getIntegranteEstadoDAO();
            $oIntegranteEstadoDAO->deleteIntegranteEstadoPorIntegrante($id);




            parent::delete( $id );

            //print_r($oIntegrante);


            $dirApp = CYT_PATH_PDFS.'/'.CYT_YEAR.'/'.CYT_PERIODO.'/'.$oIntegrante->getProyecto()->getOid().'/';






            $dir =$dirApp. $oIntegrante->getDocente()->getNu_documento().'/';

            CdtUtils::log($dir, __CLASS__,LoggerLevel::getLevelDebug());

            $handle=opendir($dir);
            while ($archivo = readdir($handle)){
                if ((is_file($dir.$archivo))){
                    unlink($dir.$archivo);
                }
            }

            $dir =$dirApp.str_pad($oIntegrante->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);

            $handle=opendir($dir);
            while ($archivo = readdir($handle)){
                if ((is_file($dir.$archivo))){
                    unlink($dir.$archivo);
                }
            }

            closedir($handle);
        }

    }

    /**
     * (non-PHPdoc)
     * @see classes/com/entities/manager/EntityManager::validateOnAdd()
     */
    protected function validateOnAdd(Entity $entity){

        parent::validateOnAdd($entity);
        $error='';
        $separarCUIL = explode('-',trim($entity->getCuil()));

        $preCuil = $separarCUIL[0];
        $documento = $separarCUIL[1];
        $posCuil = $separarCUIL[2];

        if ((strlen($preCuil)!=2)||(strlen($posCuil)!=1)) {
            $error .=CYT_MSG_INTEGRANTE_CUIL_FORMAT.'<br />';
        }

        if ((date("Y").'-'.'01-01'>CYTSecureUtils::formatDateToPersist($entity->getDt_alta()))||(date("Y").'-'.'31-12'<CYTSecureUtils::formatDateToPersist($entity->getDt_alta()))){
            $error .=CYT_MSG_INTEGRANTE_ALTA_FUERA_PERIODO.'<br />';
        }


        if (!$entity->getCargo()->getOid()&&$entity->getDeddoc()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_CARGO.'<br />';
        }

        if ($entity->getCargo()->getOid()&&!$entity->getDeddoc()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_DEDDOC.'<br />';
        }
        if ($entity->getCargo()->getOid()&&trim($entity->getDt_cargo())==''){
            $error .=CYT_MSG_INTEGRANTE_SIN_FECHA_CARGO.'<br />';
        }
        if ((trim($entity->getDs_orgbeca())!='')&&(trim($entity->getDs_tipobeca())=='')){
            $error .=CYT_MSG_INTEGRANTE_SIN_TIPOBECA.'<br />';
        }

        if ((trim($entity->getDs_orgbeca())=='')&&(trim($entity->getDs_tipobeca())!='')){
            $error .=CYT_MSG_INTEGRANTE_SIN_ORGBECA.'<br />';
        }
        if (trim($entity->getDs_tipobeca())!=''&&(trim($entity->getDt_beca())==''||trim($entity->getDt_becaHasta())=='')){
            $error .=CYT_MSG_INTEGRANTE_SIN_FECHA_BECA.'<br />';
        }

        if (trim($entity->getDt_becaHasta())!=''&&(date('Y-m-d')>CYTSecureUtils::formatDateToPersist($entity->getDt_becaHasta()))) {
            $error .=CYT_MSG_INTEGRANTE_BECA_TERMINADA.'<br />';
        }
        if (trim($entity->getDt_becaHasta())!=''&& CYTSecureUtils::formatDateToPersist($entity->getDt_beca())>CYTSecureUtils::formatDateToPersist($entity->getDt_becaHasta())) {
            $error .=CYT_MSG_INTEGRANTE_ERROR_FECHA_BECA.'<br />';
        }

        if (!$entity->getCarrerainv()->getOid()&&$entity->getOrganismo()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_CARRERAINV.'<br />';
        }

        if ($entity->getCarrerainv()->getOid()&&!$entity->getOrganismo()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_ORGANISMO.'<br />';
        }
        if ((!$entity->getTitulo()->getOid())&&((trim($entity->getNu_materias())=='')||(trim($entity->getNu_materias())=='0')||(trim($entity->getNu_totalMat())=='')||(trim($entity->getNu_totalMat())=='0')||(trim($entity->getDs_carrera())==''))){
            $error .=CYT_MSG_INTEGRANTE_SIN_MATERIAS_ADEUDADAS.'<br />';
        }
        if ($entity->getBl_becaEstimulo()&&(trim($entity->getDt_becaEstimulo())=='' || trim($entity->getDt_becaEstimuloHasta())=='')){
            $error .=CYT_MSG_INTEGRANTE_SIN_FECHA_BECA_ESTIMULO.'<br />';
        }

        if (trim($entity->getDt_becaEstimuloHasta())!='' && date('Y-m-d')>CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimuloHasta())) {
            $error .=CYT_MSG_INTEGRANTE_BECA_TERMINADA.'<br />';
        }
        if (trim($entity->getDt_becaEstimuloHasta())!='' && CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimulo())>CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimuloHasta())) {
            $error .=CYT_MSG_INTEGRANTE_ERROR_FECHA_BECA.'<br />';
        }

        if (($entity->getTipoIntegrante()->getOid()==CYT_INTEGRANTE_COLABORADOR)) {
            if ($entity->getCargo()->getOid() || $entity->getCarrerainv()->getOid() || $entity->getDs_tipobeca()){
                $error .=CYT_MSG_COLABORADOR_CON_CARGO.'<br />';
            }

            $cantProyectos = 0;
            if (($entity->getDocente()->getOid())) {
                $oCriteria = new CdtSearchCriteria();
                $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
                $tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
                $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
                $oCriteria->addFilter("$tDocente.cd_docente", $entity->getDocente()->getOid(), '=');
                $oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
                $oCriteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, '=');
                $oCriteria->addFilter("$tProyecto.cd_proyecto", $entity->getProyecto()->getOid(), '<>');
                $filter = new CdtSimpleExpression("((".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." AND ".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." AND ".$tIntegrante.".dt_baja > '".date('Y-m-d')."') OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");
                $oCriteria->setExpresion($filter);
                $twoYearAgo = intval(CYT_YEAR)-1;
                $oCriteria->addFilter('dt_fin', $twoYearAgo.CYT_DIA_MES_PROYECTO_FIN, '>', new CdtCriteriaFormatStringValue());

                //proyectos.
                $proyectosManager = CYTSecureManagerFactory::getProyectoManager();
                $proyectos = $proyectosManager->getEntities($oCriteria);
                $cantProyectos = $proyectos->size();
            }
            if ($cantProyectos>0) {
                $error .=CYT_MSG_COLABORADOR_CON_OTRO_PROYECTO.'<br />';
            }

            $hsTotales = $entity->getNu_horasinv();


            if($hsTotales != 4){
                $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
            }


        }
        else{
            //print_r($entity);
            /*if (($entity->getTipoIntegrante()->getOid()==CYT_INTEGRANTE_BECARIO)) {
                if (trim($entity->getDs_tipobeca())==''){

                    $error .=CYT_MSG_INTEGRANTE_BECARIO_SIN_BECA.'<br />';
                }
            }*/
            if (!$entity->getCargo()->getOid()&&!$entity->getDeddoc()->getOid()&&!$entity->getBl_becaEstimulo()){
                if (!$entity->getCarrerainv()->getOid()&&(trim($entity->getDs_tipobeca())=='')&&($entity->getTipoIntegrante()->getOid()!=CYT_INTEGRANTE_BECARIO)){

                    $error .=CYT_MSG_INTEGRANTE_SIN_CARGO_SIN_BECA.'<br />';
                }
            }
            /*if (!$entity->getTitulo()->getOid()){
                $error .=CYT_MSG_INTEGRANTE_SIN_TITULO.'<br />';
            }*/

            $cantProyectos = 0;
            if (($entity->getDocente()->getOid())) {
                $oCriteria = new CdtSearchCriteria();
                $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
                $tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
                $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
                $oCriteria->addFilter("$tDocente.cd_docente", $entity->getDocente()->getOid(), '=');
                $oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
                //$oCriteria->addFilter("$tIntegrante.cd_tipoinvestigador", CYT_INTEGRANTE_COLABORADOR, '<>');
                $oCriteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, '=');
                $oCriteria->addFilter("$tProyecto.cd_proyecto", $entity->getProyecto()->getOid(), '<>');
                $filter = new CdtSimpleExpression("((".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." AND ".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." AND ".$tIntegrante.".dt_baja > '".date('Y-m-d')."') OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");
                $oCriteria->setExpresion($filter);
                $twoYearAgo = intval(CYT_YEAR)-1;
                $oCriteria->addFilter('dt_fin', $twoYearAgo.CYT_DIA_MES_PROYECTO_FIN, '>', new CdtCriteriaFormatStringValue());

                //proyectos.
                $proyectosManager = CYTSecureManagerFactory::getProyectoManager();
                $proyectos = $proyectosManager->getEntities($oCriteria);
                $cantProyectos = $proyectos->size();
            }
            $max = ((in_array($entity->getDeddoc()->getOid(), explode(",",CYT_MAYORES_DEDICACIONES)))||(in_array($entity->getCarrerainv()->getOid(), explode(",",CYT_CARRERAINV_MOSTRADAS))))?1:0;

            if((trim($entity->getDs_tipobeca())!='')&&(trim($entity->getDs_tipobeca())!=CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9)){
                $max = 0;
            }
            if(trim($entity->getDs_tipobeca())=='Beca posdoctoral'){
                $max = 1;
            }
            if (intval($entity->getNu_materias())>0) {
                $max = 0;
            }
            if ($entity->getBl_becaEstimulo()){
                $max = 0;
            }
            if (in_array($entity->getCargo()->getOid(), explode(",",CYT_CARGOS_EMERITOS_CONSULTOS))) {
                $max = 0;
            }
            //if (($cantProyectos>$max)&&($entity->getTipoIntegrante()->getOid()!=CYT_INTEGRANTE_COLABORADOR)) {
            if (($cantProyectos>$max)) {
                $error .=CYT_MSG_INTEGRANTE_MUCHOS_PROYECTOS.'<br />';
                foreach ($proyectos as $proyecto) {
                    $error .=$proyecto->getDs_codigo().' ('.$proyecto->getDirector()->getDs_apellido().', '.$proyecto->getDirector()->getDs_nombre().')<br />';
                }
            }
            else{
                $hsEnProyectos = 0;
                if ($cantProyectos>0) {
                    foreach ($proyectos as $proyecto) {
                        $oCriteria = new CdtSearchCriteria();
                        $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
                        $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
                        $oCriteria->addFilter("$tDocente.cd_docente", $entity->getDocente()->getOid(), '=');
                        $oCriteria->addFilter("$tProyecto.cd_proyecto", $proyecto->getOid(), '=');
                        $integranteManager = ManagerFactory::getIntegranteManager();
                        $integrante = $integranteManager->getEntity($oCriteria);
                        $proyectoAnterior = array('ds_codigo'=>$proyecto->getDs_codigo(),'director'=>$proyecto->getDirector()->getDs_apellido().', '.$proyecto->getDirector()->getDs_nombre(),'horas'=>$integrante->getNu_horasinv());
                        $hsEnProyectos += $integrante->getNu_horasinv();
                    }
                }

                $hsTotales = $entity->getNu_horasinv()+$hsEnProyectos;
                if ($entity->getUniversidad()->getOid()!= CYT_CD_UNIVERSIDAD_UNLP) {
                    if (($entity->getDeddoc()->getOid()==CYT_CD_DEDDOC_SIMPLE)&&($hsTotales!=4)) {
                        $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                    }
                    elseif(($hsTotales > 6)||($hsTotales < 4)){
                        $error .=CYT_MSG_INTEGRANTE_EXTERNO_HORAS.'<br />';
                        if ($cantProyectos>0) {
                            $error .=CYT_LBL_PROYECTO.'<br />';
                            $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                        }
                    }
                }
                else{
                    if (($entity->getBl_becaEstimulo())||(trim($entity->getDs_tipobeca())==CYT_LBL_INTEGRANTE_TIPO_BECA_CIC1)){
                        if($hsTotales != 12){
                            $error .=CYT_MSG_INTEGRANTE_BECA_ESTIMULO_HORAS.'<br />';

                        }
                    }
                    elseif ((trim($entity->getDs_tipobeca())!='')){
                        switch (trim($entity->getDs_tipobeca())) {
                            case CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP8:
                                if($hsTotales > 40){
                                    $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS_2.'<br />';

                                }
                                if($entity->getNu_horasinv() < 10){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';

                                }
                                break;
                            case CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9:
                                if($hsTotales > 30){
                                    $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS_3.'<br />';

                                }
                                if($entity->getNu_horasinv() < 10){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';

                                }
                                break;
                            default:
                                if($hsTotales != 40){
                                    $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS.'<br />';

                                }
                                break;
                        }
                    }
                    elseif (intval($entity->getNu_materias())>0) {
                        if($hsTotales != 4){
                            $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                        }
                    }
                    elseif (in_array($entity->getCargo()->getOid(), explode(",",CYT_CARGOS_EMERITOS_CONSULTOS))) {
                        if($hsTotales != 4){
                            $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                        }
                    }
                    elseif(in_array($entity->getCarrerainv()->getOid(), explode(",",CYT_CARRERAINV_MOSTRADAS))){

                        if($hsTotales > 35){
                            $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS.'<br />';
                            if ($cantProyectos>0) {
                                $error .=CYT_LBL_PROYECTO.'<br />';
                                $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                            }

                        }


                        if($entity->getNu_horasinv() < 10){
                            $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';
                            /*if ($cantProyectos>0) {
                                $error .=CYT_LBL_PROYECTO.'<br />';
                                $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                            }*/
                        }
                    }
                    else{
                        switch ($entity->getDeddoc()->getOid()) {
                            case CYT_CD_DEDDOC_EXCLUSIVA:

                                if($hsTotales > 35){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS.'<br />';
                                    if ($cantProyectos>0) {
                                        $error .=CYT_LBL_PROYECTO.'<br />';
                                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                    }
                                }

                                if($entity->getNu_horasinv() < 10){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';
                                    /*if ($cantProyectos>0) {
                                        $error .=CYT_LBL_PROYECTO.'<br />';
                                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                    }*/
                                }
                                break;

                            case CYT_CD_DEDDOC_SEMIEXCLUSIVA:
                                if($hsTotales > 15){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_SEMIEXCLUSIVA_HORAS.'<br />';
                                    if ($cantProyectos>0) {
                                        $error .=CYT_LBL_PROYECTO.'<br />';
                                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                    }
                                }
                                if($entity->getNu_horasinv() < 6){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_SEMIEXCLUSIVA_HORAS_MIN.'<br />';
                                    /*if ($cantProyectos>0) {
                                        $error .=CYT_LBL_PROYECTO.'<br />';
                                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                    }*/
                                }
                                break;
                            case CYT_CD_DEDDOC_SIMPLE:
                                if($hsTotales != 4){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                                }

                                break;
                        }
                    }
                }
            }
        }

        if ($error) {
            throw new GenericException( $error );
        }
    }

    /**
     * (non-PHPdoc)
     * @see classes/com/entities/manager/EntityManager::validateOnUpdate()
     */
    protected function validateOnUpdate(Entity $entity){

        parent::validateOnUpdate($entity);
        $error='';
        $separarCUIL = explode('-',trim($entity->getCuil()));

        $preCuil = $separarCUIL[0];
        $documento = $separarCUIL[1];
        $posCuil = $separarCUIL[2];

        if ((strlen($preCuil)!=2)||(strlen($posCuil)!=1)) {
            $error .=CYT_MSG_INTEGRANTE_CUIL_FORMAT.'<br />';
        }

        if (($entity->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO)&&($entity->getEstado()->getOid()!=CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO)) {
            if ((date("Y").'-'.'01-01'>CYTSecureUtils::formatDateToPersist($entity->getDt_alta()))||(date("Y").'-'.'31-12'<CYTSecureUtils::formatDateToPersist($entity->getDt_alta()))){
                $error .=CYT_MSG_INTEGRANTE_ALTA_FUERA_PERIODO.'<br />';
            }
        }



        if (!$entity->getCargo()->getOid()&&$entity->getDeddoc()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_CARGO.'<br />';
        }
        if ($entity->getCargo()->getOid()&&!$entity->getDeddoc()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_DEDDOC.'<br />';
        }
        if ($entity->getCargo()->getOid()&&trim($entity->getDt_cargo())==''){
            $error .=CYT_MSG_INTEGRANTE_SIN_FECHA_CARGO.'<br />';
        }
        if ((trim($entity->getDs_orgbeca())!='')&&(trim($entity->getDs_tipobeca())=='')){
            $error .=CYT_MSG_INTEGRANTE_SIN_TIPOBECA.'<br />';
        }

        if ((trim($entity->getDs_orgbeca())=='')&&(trim($entity->getDs_tipobeca())!='')){
            $error .=CYT_MSG_INTEGRANTE_SIN_ORGBECA.'<br />';
        }
        if (trim($entity->getDs_tipobeca())!='' && (trim($entity->getDt_beca())=='' || trim($entity->getDt_becaHasta())=='')){
            $error .=CYT_MSG_INTEGRANTE_SIN_FECHA_BECA.'<br />';
        }

        if (trim($entity->getDt_becaHasta())!='' && date('Y-m-d')>CYTSecureUtils::formatDateToPersist($entity->getDt_becaHasta())) {
            $error .=CYT_MSG_INTEGRANTE_BECA_TERMINADA.'<br />';
        }
        if (trim($entity->getDt_becaHasta())!='' && CYTSecureUtils::formatDateToPersist($entity->getDt_beca())>CYTSecureUtils::formatDateToPersist($entity->getDt_becaHasta())) {
            $error .=CYT_MSG_INTEGRANTE_ERROR_FECHA_BECA.'<br />';
        }

        if (!$entity->getCarrerainv()->getOid()&&$entity->getOrganismo()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_CARRERAINV.'<br />';
        }

        if ($entity->getCarrerainv()->getOid()&&!$entity->getOrganismo()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_ORGANISMO.'<br />';
        }

        if ((!$entity->getTitulo()->getOid())&&((trim($entity->getNu_materias())=='')||(trim($entity->getNu_materias())=='0')||(trim($entity->getNu_totalMat())=='')||(trim($entity->getNu_totalMat())=='0')||(trim($entity->getDs_carrera())==''))){
            $error .=CYT_MSG_INTEGRANTE_SIN_MATERIAS_ADEUDADAS.'<br />';
        }
        if ($entity->getBl_becaEstimulo() && (trim($entity->getDt_becaEstimulo())=='' || trim($entity->getDt_becaEstimuloHasta())=='')){
            $error .=CYT_MSG_INTEGRANTE_SIN_FECHA_BECA_ESTIMULO.'<br />';
        }

        if (trim($entity->getDt_becaEstimuloHasta())!='' && date('Y-m-d')>CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimuloHasta())) {
            $error .=CYT_MSG_INTEGRANTE_BECA_TERMINADA.'<br />';
        }
        if (trim($entity->getDt_becaEstimuloHasta())!='' && CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimulo())>CYTSecureUtils::formatDateToPersist($entity->getDt_becaEstimuloHasta())) {
            $error .=CYT_MSG_INTEGRANTE_ERROR_FECHA_BECA.'<br />';
        }

        if (($entity->getTipoIntegrante()->getOid()==CYT_INTEGRANTE_COLABORADOR)) {

            if ($entity->getCargo()->getOid() || $entity->getCarrerainv()->getOid() || $entity->getDs_tipobeca()){
                $error .=CYT_MSG_COLABORADOR_CON_CARGO.'<br />';
            }

            $cantProyectos = 0;
            if (($entity->getDocente()->getOid())) {
                $oCriteria = new CdtSearchCriteria();
                $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
                $tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
                $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
                $oCriteria->addFilter("$tDocente.cd_docente", $entity->getDocente()->getOid(), '=');
                $oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
                $oCriteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, '=');
                $oCriteria->addFilter("$tProyecto.cd_proyecto", $entity->getProyecto()->getOid(), '<>');
                $filter = new CdtSimpleExpression("((".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." AND ".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." AND ".$tIntegrante.".dt_baja > '".date('Y-m-d')."') OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");
                $oCriteria->setExpresion($filter);
                $twoYearAgo = intval(CYT_YEAR)-1;
                $oCriteria->addFilter('dt_fin', $twoYearAgo.CYT_DIA_MES_PROYECTO_FIN, '>', new CdtCriteriaFormatStringValue());

                //proyectos.
                $proyectosManager = CYTSecureManagerFactory::getProyectoManager();
                $proyectos = $proyectosManager->getEntities($oCriteria);
                $cantProyectos = $proyectos->size();
            }
            if ($cantProyectos>0) {
                $error .=CYT_MSG_COLABORADOR_CON_OTRO_PROYECTO.'<br />';
            }
            $hsTotales = $entity->getNu_horasinv();


            if($hsTotales != 4){
                $error .=CYT_MSG_INTEGRANTE_SIN_CARGO_SIN_BECA.'<br />';
            }
        }
        else{
            //print_r($entity);
            if (!$entity->getCargo()->getOid()&&!$entity->getDeddoc()->getOid()&&!$entity->getBl_becaEstimulo()){
                if (!$entity->getCarrerainv()->getOid()&&(trim($entity->getDs_tipobeca())=='')&&($entity->getTipoIntegrante()->getOid()!=CYT_INTEGRANTE_BECARIO)){

                    $error .=CYT_MSG_INTEGRANTE_SIN_CARGO_SIN_BECA.'<br />';
                }
            }
            /*if (!$entity->getTitulo()->getOid()){
                $error .=CYT_MSG_INTEGRANTE_SIN_TITULO.'<br />';
            }*/

            $cantProyectos = 0;
            //CdtUtils::log('Docente: '.$entity->getDocente()->getOid());
            if (($entity->getDocente()->getOid())) {
                $oCriteria = new CdtSearchCriteria();
                $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
                $tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
                $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
                $oCriteria->addFilter("$tDocente.cd_docente", $entity->getDocente()->getOid(), '=');
                $oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
                //$oCriteria->addFilter("$tIntegrante.cd_tipoinvestigador", CYT_INTEGRANTE_COLABORADOR, '<>');
                $oCriteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, '=');
                $oCriteria->addFilter("$tProyecto.cd_proyecto", $entity->getProyecto()->getOid(), '<>');
                $filter = new CdtSimpleExpression("((".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." AND ".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." AND ".$tIntegrante.".dt_baja > '".date('Y-m-d')."') OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");
                $oCriteria->setExpresion($filter);
                $twoYearAgo = intval(CYT_YEAR)-1;
                $oCriteria->addFilter('dt_fin', $twoYearAgo.CYT_DIA_MES_PROYECTO_FIN, '>', new CdtCriteriaFormatStringValue());

                //proyectos.
                $proyectosManager = CYTSecureManagerFactory::getProyectoManager();
                $proyectos = $proyectosManager->getEntities($oCriteria);
                $cantProyectos = $proyectos->size();
            }
            $max = ((in_array($entity->getDeddoc()->getOid(), explode(",",CYT_MAYORES_DEDICACIONES)))||(in_array($entity->getCarrerainv()->getOid(), explode(",",CYT_CARRERAINV_MOSTRADAS))))?1:0;

            if((trim($entity->getDs_tipobeca())!='')&&(trim($entity->getDs_tipobeca())!=CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9)){
                $max = 0;
            }
            if(trim($entity->getDs_tipobeca())=='Beca posdoctoral'){
                $max = 1;
            }
            if (intval($entity->getNu_materias())>0) {
                $max = 0;
            }
            if ($entity->getBl_becaEstimulo()){
                $max = 0;
            }
            if (in_array($entity->getCargo()->getOid(), explode(",",CYT_CARGOS_EMERITOS_CONSULTOS))) {
                $max = 0;
            }
            //if (($cantProyectos>$max)&&($entity->getTipoIntegrante()->getOid()!=CYT_INTEGRANTE_COLABORADOR)) {
            if (($cantProyectos>$max)) {
                $error .=CYT_MSG_INTEGRANTE_MUCHOS_PROYECTOS.'<br />';
                foreach ($proyectos as $proyecto) {
                    $error .=$proyecto->getDs_codigo().' ('.$proyecto->getDirector()->getDs_apellido().', '.$proyecto->getDirector()->getDs_nombre().')<br />';
                }
            }
            else{
                $hsEnProyectos = 0;
                if ($cantProyectos>0) {
                    foreach ($proyectos as $proyecto) {
                        $oCriteria = new CdtSearchCriteria();
                        $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
                        $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
                        $oCriteria->addFilter("$tDocente.cd_docente", $entity->getDocente()->getOid(), '=');
                        $oCriteria->addFilter("$tProyecto.cd_proyecto", $proyecto->getOid(), '=');
                        $integranteManager = ManagerFactory::getIntegranteManager();
                        $integrante = $integranteManager->getEntity($oCriteria);
                        $proyectoAnterior = array('ds_codigo'=>$proyecto->getDs_codigo(),'director'=>$proyecto->getDirector()->getDs_apellido().', '.$proyecto->getDirector()->getDs_nombre(),'horas'=>$integrante->getNu_horasinv());
                        $hsEnProyectos += $integrante->getNu_horasinv();
                    }
                }

                $hsTotales = $entity->getNu_horasinv()+$hsEnProyectos;
                CdtUtils::log('Horas: '.$hsTotales);
                if ($entity->getUniversidad()->getOid()!= CYT_CD_UNIVERSIDAD_UNLP) {
                    if (($entity->getDeddoc()->getOid()==CYT_CD_DEDDOC_SIMPLE)&&($hsTotales!=4)) {
                        $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                    }
                    elseif(($hsTotales > 6)||($hsTotales < 4)){
                        $error .=CYT_MSG_INTEGRANTE_EXTERNO_HORAS.'<br />';
                        if ($cantProyectos>0) {
                            $error .=CYT_LBL_PROYECTO.'<br />';
                            $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                        }
                    }
                }
                else{
                    if (($entity->getBl_becaEstimulo())||(trim($entity->getDs_tipobeca())==CYT_LBL_INTEGRANTE_TIPO_BECA_CIC1)){
                        if($hsTotales != 12){
                            $error .=CYT_MSG_INTEGRANTE_BECA_ESTIMULO_HORAS.'<br />';

                        }
                    }
                    elseif ((trim($entity->getDs_tipobeca())!='')){
                        switch (trim($entity->getDs_tipobeca())) {
                            case CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP8:
                                if($hsTotales > 40){
                                    $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS_2.'<br />';

                                }
                                if($entity->getNu_horasinv() < 10){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';

                                }
                                break;
                            case CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9:
                                if($hsTotales > 30){
                                    $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS_3.'<br />';

                                }
                                if($entity->getNu_horasinv() < 10){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';

                                }
                                break;
                            default:
                                if($hsTotales != 40){
                                    $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS.'<br />';

                                }
                                break;
                        }

                    }

                    elseif (intval($entity->getNu_materias())>0) {
                        if($hsTotales != 4){
                            $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                        }
                    }
                    elseif (in_array($entity->getCargo()->getOid(), explode(",",CYT_CARGOS_EMERITOS_CONSULTOS))) {
                        if($hsTotales != 4){
                            $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                        }
                    }
                    elseif(in_array($entity->getCarrerainv()->getOid(), explode(",",CYT_CARRERAINV_MOSTRADAS))){

                        if($hsTotales > 35){
                            $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS.'<br />';
                            if ($cantProyectos>0) {
                                $error .=CYT_LBL_PROYECTO.'<br />';
                                $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                            }
                        }


                        if($entity->getNu_horasinv() < 10){
                            $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';
                            /*if ($cantProyectos>0) {
                                $error .=CYT_LBL_PROYECTO.'<br />';
                                $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                            }*/
                        }
                    }
                    else{
                        switch ($entity->getDeddoc()->getOid()) {
                            case CYT_CD_DEDDOC_EXCLUSIVA:

                                if($hsTotales > 35){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS.'<br />';
                                    if ($cantProyectos>0) {
                                        $error .=CYT_LBL_PROYECTO.'<br />';
                                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                    }
                                }

                                if($entity->getNu_horasinv() < 10){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';
                                    /*if ($cantProyectos>0) {
                                        $error .=CYT_LBL_PROYECTO.'<br />';
                                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                    }*/
                                }
                                break;

                            case CYT_CD_DEDDOC_SEMIEXCLUSIVA:
                                if($hsTotales > 15){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_SEMIEXCLUSIVA_HORAS.'<br />';
                                    if ($cantProyectos>0) {
                                        $error .=CYT_LBL_PROYECTO.'<br />';
                                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                    }
                                }
                                if($entity->getNu_horasinv() < 6){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_SEMIEXCLUSIVA_HORAS_MIN.'<br />';
                                    /*if ($cantProyectos>0) {
                                        $error .=CYT_LBL_PROYECTO.'<br />';
                                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                    }*/
                                }
                                break;
                            case CYT_CD_DEDDOC_SIMPLE:
                                if($hsTotales != 4){
                                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                                }

                                break;
                        }
                    }
                }
            }
        }

        if ($error) {
            throw new GenericException( $error );
        }



    }

    /**
     * (non-PHPdoc)
     * @see classes/com/entities/manager/EntityManager::validateOnAdd()
     */
    protected function validateOnBaja(Entity $entity){
        //print_r($entity);

        $error='';

        if ((date("Y").'-'.'01-01'>CYTSecureUtils::formatDateToPersist($entity->getDt_baja()))||(date("Y").'-'.'31-12'<CYTSecureUtils::formatDateToPersist($entity->getDt_baja()))){
            $error .=CYT_MSG_INTEGRANTE_BAJA_FUERA_PERIODO.'<br />';
        }


        if (!$entity->getBl_mincategorizados()){
            $msg = CYT_MSG_INTEGRANTE_MIN_CATEGORIZADOS;
            $params = array (CYT_MIN_CATEGORIZADOS);
            $error .=CdtFormatUtils::formatMessage( $msg, $params ).'<br />';

        }

        if (!$entity->getBl_minmayordedicacion()){
            $msg = CYT_MSG_INTEGRANTE_MIN_MAYOR_DEDICACION;
            $params = array (CYT_MIN_MAYOR_DEDICACION);
            $error .=CdtFormatUtils::formatMessage( $msg, $params ).'<br />';
        }
        if ($entity->getTipoIntegrante()->getOid()!=CYT_INTEGRANTE_COLABORADOR){
            $oCriteria = new CdtSearchCriteria();
            $oCriteria->addFilter('oid', $entity->getOid(), '<>');
            $oCriteria->addFilter('cd_proyecto', $entity->getProyecto()->getOid(), '=');
            $oCriteria->addFilter('cd_tipoinvestigador', CYT_INTEGRANTE_COLABORADOR, '<>');
            $oCriteria->addNull('fechaHasta');
            $oCriteria->addOrder(cd_tipoinvestigador, 'ASC');
            $oIntegranteManager = ManagerFactory::getIntegranteManager();
            $oIntegrantes = $oIntegranteManager->getEntities($oCriteria);
            $nu_horastotal=0;
            $nu_total=0;
            $nu_categorizados=0;
            $nu_mayordedicacion=0;
            foreach ($oIntegrantes as $integrante) {
                $nu_total++;
                $nu_horastotal = $nu_horastotal+$integrante->getNu_horasinv();

            }

        }

        if ($nu_total<CYT_MIN_INTEGRANTES){
            $msg = CYT_MSG_INTEGRANTE_MIN_INTEGRANTES;
            $params = array (CYT_MIN_INTEGRANTES);
            $error .=CdtFormatUtils::formatMessage( $msg, $params ).'<br />';
        }

        if ($nu_horastotal<CYT_MIN_HS_TOTALES){
            $msg = CYT_MSG_INTEGRANTE_MIN_HORAS_TOTALES;
            $params = array (CYT_MIN_HS_TOTALES);
            $error .=CdtFormatUtils::formatMessage( $msg, $params ).'<br />';
        }

        if ($error) {
            throw new GenericException( $error );
        }
    }

    protected function validateOnCambioHS(Entity $entity){
        //print_r($entity);

        $error='';

        if ((date("Y").'-'.'01-01'>CYTSecureUtils::formatDateToPersist($entity->getDt_cambioHS()))||(date("Y").'-'.'31-12'<CYTSecureUtils::formatDateToPersist($entity->getDt_cambioHS()))){
            $error .=CYT_MSG_INTEGRANTE_CAMBIO_HS_FUERA_PERIODO.'<br />';
        }

        if ($entity->getNu_horasinv()==$entity->getNu_horasinvAnt()){
            $error .=CYT_MSG_INTEGRANTE_CAMBIO_HS_IGUAL.'<br />';
        }

        if (($entity->getNu_horasinv()<$entity->getNu_horasinvAnt())&&($entity->getDs_reduccionHS()=='')){
            $error .=CYT_LBL_INTEGRANTE_CAMBIAR_HS_REDUCCION.'<br />';
        }

        if (!$entity->getCargo()->getOid()&&!$entity->getDeddoc()->getOid()&&!$entity->getBl_becaEstimulo()){
            if (!$entity->getCarrerainv()->getOid()&&(trim($entity->getDs_tipobeca())=='')&&($entity->getTipoIntegrante()->getOid()!=CYT_INTEGRANTE_BECARIO)){

                $error .=CYT_MSG_INTEGRANTE_SIN_CARGO_SIN_BECA.'<br />';
            }
        }
        /*if (!$entity->getTitulo()->getOid()){
            $error .=CYT_MSG_INTEGRANTE_SIN_TITULO.'<br />';
        }*/

        $cantProyectos = 0;
        if (($entity->getDocente()->getOid())) {
            $oCriteria = new CdtSearchCriteria();
            $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
            $tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
            $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
            $oCriteria->addFilter("$tDocente.cd_docente", $entity->getDocente()->getOid(), '=');
            $oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
            //$oCriteria->addFilter("$tIntegrante.cd_tipoinvestigador", CYT_INTEGRANTE_COLABORADOR, '<>');
            $oCriteria->addFilter("$tProyecto.cd_estado", CYT_ESTADO_PROYECTO_ACREDITADO, '=');
            $oCriteria->addFilter("$tProyecto.cd_proyecto", $entity->getProyecto()->getOid(), '<>');
            $filter = new CdtSimpleExpression("((".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." AND ".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." AND ".$tIntegrante.".dt_baja > '".date('Y-m-d')."') OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");
            $oCriteria->setExpresion($filter);
            $twoYearAgo = intval(CYT_YEAR)-1;
            $oCriteria->addFilter('dt_fin', $twoYearAgo.CYT_DIA_MES_PROYECTO_FIN, '>', new CdtCriteriaFormatStringValue());

            //proyectos.
            $proyectosManager = CYTSecureManagerFactory::getProyectoManager();
            $proyectos = $proyectosManager->getEntities($oCriteria);
            $cantProyectos = $proyectos->size();
        }
        $max = ((in_array($entity->getDeddoc()->getOid(), explode(",",CYT_MAYORES_DEDICACIONES)))||(in_array($entity->getCarrerainv()->getOid(), explode(",",CYT_CARRERAINV_MOSTRADAS))))?1:0;

        if((trim($entity->getDs_tipobeca())!='')&&(trim($entity->getDs_tipobeca())!=CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9)){
            $max = 0;
        }
        if(trim($entity->getDs_tipobeca())=='Beca posdoctoral'){
            $max = 1;
        }
        if (intval($entity->getNu_materias())>0) {
            $max = 0;
        }
        if ($entity->getBl_becaEstimulo()){
            $max = 0;
        }
        if (in_array($entity->getCargo()->getOid(), explode(",",CYT_CARGOS_EMERITOS_CONSULTOS))) {
            $max = 0;
        }
        //if (($cantProyectos>$max)&&($entity->getTipoIntegrante()->getOid()!=CYT_INTEGRANTE_COLABORADOR)) {
        if (($cantProyectos>$max)) {
            $error .=CYT_MSG_INTEGRANTE_MUCHOS_PROYECTOS.'<br />';
            foreach ($proyectos as $proyecto) {
                $error .=$proyecto->getDs_codigo().' ('.$proyecto->getDirector()->getDs_apellido().', '.$proyecto->getDirector()->getDs_nombre().')<br />';
            }
        }
        else{
            $hsEnProyectos = 0;
            if ($cantProyectos>0) {
                foreach ($proyectos as $proyecto) {
                    $oCriteria = new CdtSearchCriteria();
                    $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
                    $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
                    $oCriteria->addFilter("$tDocente.cd_docente", $entity->getDocente()->getOid(), '=');
                    $oCriteria->addFilter("$tProyecto.cd_proyecto", $proyecto->getOid(), '=');
                    $integranteManager = ManagerFactory::getIntegranteManager();
                    $integrante = $integranteManager->getEntity($oCriteria);
                    $proyectoAnterior = array('ds_codigo'=>$proyecto->getDs_codigo(),'director'=>$proyecto->getDirector()->getDs_apellido().', '.$proyecto->getDirector()->getDs_nombre(),'horas'=>$integrante->getNu_horasinv());
                    $hsEnProyectos += $integrante->getNu_horasinv();
                }
            }

            $hsTotales = $entity->getNu_horasinv()+$hsEnProyectos;
            if ($entity->getUniversidad()->getOid()!= CYT_CD_UNIVERSIDAD_UNLP) {
                if (($entity->getDeddoc()->getOid()==CYT_CD_DEDDOC_SIMPLE)&&($hsTotales!=4)) {
                    $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                }
                elseif(($hsTotales > 6)||($hsTotales < 4)){
                    $error .=CYT_MSG_INTEGRANTE_EXTERNO_HORAS.'<br />';
                    if ($cantProyectos>0) {
                        $error .=CYT_LBL_PROYECTO.'<br />';
                        $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                    }
                }
            }
            else{
                if (($entity->getBl_becaEstimulo())||(trim($entity->getDs_tipobeca())==CYT_LBL_INTEGRANTE_TIPO_BECA_CIC1)){
                    if($hsTotales != 12){
                        $error .=CYT_MSG_INTEGRANTE_BECA_ESTIMULO_HORAS.'<br />';

                    }
                }
                elseif ((trim($entity->getDs_tipobeca())!='')){
                    switch (trim($entity->getDs_tipobeca())) {
                        case CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP8:
                            if($hsTotales > 40){
                                $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS_2.'<br />';

                            }
                            if($entity->getNu_horasinv() < 10){
                                $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';

                            }
                            break;
                        case CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9:
                            if($hsTotales > 30){
                                $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS_3.'<br />';

                            }
                            if($entity->getNu_horasinv() < 10){
                                $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';

                            }
                            break;
                        default:
                            if($hsTotales != 40){
                                $error .=CYT_MSG_INTEGRANTE_BECARIO_HORAS.'<br />';

                            }
                            break;
                    }
                }
                elseif (intval($entity->getNu_materias())>0) {
                    if($hsTotales != 4){
                        $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                    }
                }
                elseif (in_array($entity->getCargo()->getOid(), explode(",",CYT_CARGOS_EMERITOS_CONSULTOS))) {
                    if($hsTotales != 4){
                        $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                    }
                }
                elseif(in_array($entity->getCarrerainv()->getOid(), explode(",",CYT_CARRERAINV_MOSTRADAS))){

                    if($hsTotales > 35){
                        $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS.'<br />';
                        if ($cantProyectos>0) {
                            $error .=CYT_LBL_PROYECTO.'<br />';
                            $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                        }

                    }


                    if($entity->getNu_horasinv() < 10){
                        $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';
                        /*if ($cantProyectos>0) {
                            $error .=CYT_LBL_PROYECTO.'<br />';
                            $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                        }*/
                    }
                }
                else{
                    switch ($entity->getDeddoc()->getOid()) {
                        case CYT_CD_DEDDOC_EXCLUSIVA:

                            if($hsTotales > 35){
                                $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS.'<br />';
                                if ($cantProyectos>0) {
                                    $error .=CYT_LBL_PROYECTO.'<br />';
                                    $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                }
                            }

                            if($entity->getNu_horasinv() < 10){
                                $error .=CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN.'<br />';
                                /*if ($cantProyectos>0) {
                                    $error .=CYT_LBL_PROYECTO.'<br />';
                                    $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                }*/
                            }
                            break;

                        case CYT_CD_DEDDOC_SEMIEXCLUSIVA:
                            if($hsTotales > 15){
                                $error .=CYT_MSG_INTEGRANTE_DEDDOC_SEMIEXCLUSIVA_HORAS.'<br />';
                                if ($cantProyectos>0) {
                                    $error .=CYT_LBL_PROYECTO.'<br />';
                                    $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                }
                            }
                            if($entity->getNu_horasinv() < 6){
                                $error .=CYT_MSG_INTEGRANTE_DEDDOC_SEMIEXCLUSIVA_HORAS_MIN.'<br />';
                                /*if ($cantProyectos>0) {
                                    $error .=CYT_LBL_PROYECTO.'<br />';
                                    $error .=$proyectoAnterior['ds_codigo'].' ('.$proyectoAnterior['director'].') '.CYT_LBL_INTEGRANTE_HORAS.': '.$proyectoAnterior['horas'].'<br />';
                                }*/
                            }
                            break;
                        case CYT_CD_DEDDOC_SIMPLE:
                            if($hsTotales != 4){
                                $error .=CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS.'<br />';
                            }

                            break;
                    }
                }
            }
        }


        if ($error) {
            throw new GenericException( $error );
        }


        if ($error) {
            throw new GenericException( $error );
        }
    }

    protected function validateOnCambioTipo(Entity $entity){
        //print_r($entity);

        $error='';

        if (($entity->getTipoIntegrante()->getOid()!=CYT_INTEGRANTE_COLABORADOR)) {
            if (($entity->getNu_horasinv()<$entity->getNu_horasinvAnt())&&($entity->getDs_reduccionHS()=='')){
                $error .=CYT_LBL_INTEGRANTE_CAMBIAR_HS_REDUCCION.'<br />';
            }
        }








        if ($error) {
            throw new GenericException( $error );
        }


        if ($error) {
            throw new GenericException( $error );
        }
    }

    protected function validateOnSend(Entity $entity, $estado_oid){
        //print_r($entity);

        $error='';

        if (($estado_oid==CYT_ESTADO_INTEGRANTE_ALTA_CREADA)||($estado_oid==CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO)) {
            if (!$entity->getDs_curriculum()){
                $error .=CYT_MSG_INTEGRANTE_CV_REQUERIDO.'<br />';
            }
            if (!$entity->getDs_actividades()){
                $error .=CYT_MSG_INTEGRANTE_ACTIVIDADES_REQUERIDO.'<br />';
            }
            if (!$entity->getDs_resolucionBeca()&&(trim($entity->getDs_tipobeca())!='')&&(trim($entity->getDs_tipobeca())!=CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9)){
                $error .=CYT_MSG_INTEGRANTE_RESOLUCION_BECA_REQUERIDO.'<br />';
            }

            elseif (!$entity->getDs_resolucionBeca()&&($entity->getTipoIntegrante()->getOid()==CYT_INTEGRANTE_BECARIO)){
                $error .=CYT_MSG_INTEGRANTE_RESOLUCION_TESIS_REQUERIDO.'<br />';
            }
            $oid = $entity->getOid();
            $oCriteria = new CdtSearchCriteria();
            $oCriteria->addFilter('oid', $oid, '=');
            $oCriteria->addNull('fechaHasta');
            $oIntegranteManager = ManagerFactory::getIntegranteManager();
            $oIntegrante = $oIntegranteManager->getEntity($oCriteria);
            $dir = CYT_PATH_PDFS.'/'.CYT_YEAR.'/'.$dir .= CYT_PERIODO.'/'.$oIntegrante->getProyecto()->getOid().'/';
            $dirDoc = $dir.$oIntegrante->getDocente()->getNu_documento().'/';


            $okCv=0;
            $okPlan=0;
            $okRes=0;
            $handle=opendir($dirDoc);
            while ($archivo = readdir($handle))
            {
                if ((is_file($dirDoc.$archivo))&&(strchr($archivo,'CV_')))
                {
                    $okCv=1;
                }
                if ((is_file($dirDoc.$archivo))&&(strchr($archivo,'Actividades_')))
                {
                    $okPlan=1;
                }
                if ((is_file($dirDoc.$archivo))&&(strchr($archivo,'RES_BECA_')))
                {
                    $okRes=1;
                }

            }
            $dirDoc = $dir.str_pad($oIntegrante->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);
            $handle=opendir($dirDoc);
            while ($archivo = readdir($handle))
            {
                if ((is_file($dirDoc.$archivo))&&(strchr($archivo,'CV_')))
                {
                    $okCv=1;
                }
                if ((is_file($dirDoc.$archivo))&&(strchr($archivo,'Actividades_')))
                {
                    $okPlan=1;
                }
                if ((is_file($dirDoc.$archivo))&&(strchr($archivo,'RES_BECA_')))
                {
                    $okRes=1;
                }
            }
            if (!$okCv){
                $error .=CYT_MSG_INTEGRANTE_CV_PROBLEMA.'<br />';
            }
            if (!$okPlan){
                $error .=CYT_MSG_INTEGRANTE_ACTIVIDADES_PROBLEMA.'<br />';
            }
            if (!$okRes&&(trim($entity->getDs_tipobeca())!='')&&(trim($entity->getDs_tipobeca())!=CYT_LBL_INTEGRANTE_TIPO_BECA_UNLP9)){
                $error .=CYT_MSG_INTEGRANTE_RESOLUCION_BECA_PROBLEMA.'<br />';
            }
        }





        if ($error) {
            throw new GenericException( $error );
        }
    }

    public function send(Entity $entity) {

        //armamos el pdf con la data necesaria.
        $pdf = new ViewSolicitudPDF();



        $oid = $entity->getOid();
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

        $this->validateOnSend($entity, $oIntegranteEstado->getEstado()->getOid());

        switch ($oIntegranteEstado->getEstado()->getOid()) {
            case CYT_ESTADO_INTEGRANTE_ALTA_CREADA:
                $recibida = CYT_ESTADO_INTEGRANTE_ALTA_RECIBIDA;
                $motivo = 'Envio de alta';
                break;
            case CYT_ESTADO_INTEGRANTE_BAJA_CREADA:
                $recibida = CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA;
                $motivo = 'Envio de baja';
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO:
                $recibida = CYT_ESTADO_INTEGRANTE_CAMBIO_RECIBIDO;
                $motivo = 'Envio de cambio';
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO:
                $recibida = CYT_ESTADO_INTEGRANTE_CAMBIO_HS_RECIBIDO;
                $motivo = 'Envio de cambio de dedicacion horaria';
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO:
                $recibida = CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_RECIBIDO;
                $motivo = 'Envio de cambio de tipo';
                break;
        }

        $oEstado = new Estado();
        $oEstado->setOid($recibida);

        $oIntegranteEstado = new IntegranteEstado();
        $oIntegranteEstado->setIntegrante($oIntegrante);
        $oIntegranteEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
        $oIntegranteEstado->setEstado($oEstado);
        $oIntegranteEstado->setTipoIntegrante($oIntegrante->getTipoIntegrante());
        $oIntegranteEstado->setCargo($oIntegrante->getCargo());
        $oIntegranteEstado->setDeddoc($oIntegrante->getDeddoc());
        $oIntegranteEstado->setCategoria($oIntegrante->getCategoria());
        $oIntegranteEstado->setFacultad($oIntegrante->getFacultad());

        $oIntegranteEstado->setCarreraInv($oIntegrante->getCarreraInv());
        $oIntegranteEstado->setOrganismo($oIntegrante->getOrganismo());
        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDs_orgbeca($oIntegrante->getDs_orgbeca());
        $oIntegranteEstado->setDs_tipobeca($oIntegrante->getDs_tipobeca());
        $oIntegranteEstado->setDt_beca($oIntegrante->getDt_beca());
        $oIntegranteEstado->setDt_becaHasta($oIntegrante->getDt_becaHasta());
        $oIntegranteEstado->setBl_becaEstimulo($oIntegrante->getBl_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimulo($oIntegrante->getDt_becaEstimulo());
        $oIntegranteEstado->setDt_becaEstimuloHasta($oIntegrante->getDt_becaEstimuloHasta());

        $oIntegranteEstado->setDt_alta($oIntegrante->getDt_alta());
        $oIntegranteEstado->setDt_baja($oIntegrante->getDt_baja());
        $oIntegranteEstado->setDt_cambio($oIntegrante->getDt_cambioHS());
        $oIntegranteEstado->setNu_horasinv($oIntegrante->getNu_horasinv());
        $oIntegranteEstado->setDs_consecuencias($oIntegrante->getDs_consecuencias());
        $oIntegranteEstado->setDs_motivos($oIntegrante->getDs_motivos());
        $oIntegranteEstado->setDs_reduccionHS($oIntegrante->getDs_reduccionHS());
        $oIntegranteEstado->setMotivo($motivo);
        $oUser = CdtSecureUtils::getUserLogged();
        $oIntegranteEstado->setUser($oUser);
        $oIntegranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));

        $this->cambiarEstado($oIntegrante, $oIntegranteEstado);

        //armamos el pdf con la data necesaria.
        $pdf->setYear(CYT_YEAR);
        $pdf->setEstado_oid($oEstado->getOid());
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

        switch ($oEstado->getOid()) {
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
            case CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO:
                $ds_tipo = 'CAMBIOTIPO';
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_RECIBIDO:
                $ds_tipo = 'CAMBIOTIPO';
                break;

        }

        $pdf->setDs_tipo($ds_tipo);

        $pdf->setDocente_oid($oIntegrante->getDocente()->getOid());

        $pdf->setDs_investigador($oIntegrante->getDocente()->getDs_apellido().', '.$oIntegrante->getDocente()->getDs_nombre());

        $pdf->setNu_cuil($oIntegrante->getDocente()->getNu_precuil().'-'.$oIntegrante->getDocente()->getNu_documento().'-'.$oIntegrante->getDocente()->getNu_postcuil());

        $pdf->setDs_categoria($oIntegrante->getCategoria()->getDs_categoria());

        $pdf->setDs_titulogrado($oIntegrante->getTitulo()->getDs_titulo());

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

        $pdf->title = CYT_MSG_SOLICITUD_PDF_TITLE;
        $pdf->SetFont('Arial','', 13);

        // establecemos los mÃƒÂ¡rgenes
        $pdf->SetMargins(10, 20 , 10);
        $pdf->setMaxWidth($pdf->w - $pdf->lMargin - $pdf->rMargin);
        //$pdf->SetAutoPageBreak(true,90);
        $pdf->AddPage();
        $pdf->AliasNbPages();

        //imprimimos la solicitud.
        $pdf->printSolicitud();

        $dir = CYT_PATH_PDFS.'/';
        if (!file_exists($dir)) mkdir($dir, 0777);
        $dir .= CYT_YEAR.'/';
        if (!file_exists($dir)) mkdir($dir, 0777);
        $dir .= CYT_PERIODO.'/';
        if (!file_exists($dir)) mkdir($dir, 0777);
        $dir .= $oIntegrante->getProyecto()->getOid().'/';
        if (!file_exists($dir)) mkdir($dir, 0777);
        $dirDoc = $dir.$oIntegrante->getDocente()->getNu_documento().'/';
        if (!file_exists($dirDoc)) mkdir($dirDoc, 0777);






        $fileName = $dirDoc.$ds_tipo.'_'.CYTSecureUtils::stripAccents($oIntegrante->getDocente()->getDs_apellido()).'_'.$oIntegrante->getDocente()->getNu_documento().'.pdf';;
        $pdf->Output($fileName,'F');
        $pdf->Output();

        $attachs = array();
        $handle=opendir($dirDoc);
        while ($archivo = readdir($handle))
        {
            if ((is_file($dirDoc.$archivo))&&(($ds_tipo=='ALTA')&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIO_'))&&(!strchr($archivo,'CAMBIODEDHS_'))||($ds_tipo=='BAJA')&&(strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIODEDHS_'))&&(!strchr($archivo,'CAMBIOTIPO_'))||($ds_tipo=='CAMBIO')&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIODEDHS_'))&&(!strchr($archivo,'CAMBIOTIPO_'))||($ds_tipo=='CAMBIODEDHS')&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIOTIPO_'))||($ds_tipo=='CAMBIOTIPO')&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIODEDHS_'))&&(!strchr($archivo,'CAMBIO_'))&&(!strchr($archivo,'CV_'))&&(!strchr($archivo,'Actividades_'))&&(!strchr($archivo,'RES_BECA_'))))
            {
                $attachs[]=$dirDoc.$archivo;
            }
        }
        $dirDoc = $dir.str_pad($oIntegrante->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);
        $handle=opendir($dirDoc);
        while ($archivo = readdir($handle))
        {
            if ((is_file($dirDoc.$archivo))&&(($ds_tipo=='ALTA')&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIO_'))&&(!strchr($archivo,'CAMBIODEDHS_'))||($ds_tipo=='BAJA')&&(strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIODEDHS_'))&&(!strchr($archivo,'CAMBIOTIPO_'))||($ds_tipo=='CAMBIO')&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIODEDHS_'))&&(!strchr($archivo,'CAMBIOTIPO_'))||($ds_tipo=='CAMBIODEDHS')&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIOTIPO_'))||($ds_tipo=='CAMBIOTIPO')&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIODEDHS_'))&&(!strchr($archivo,'CAMBIO_'))&&(!strchr($archivo,'CV_'))&&(!strchr($archivo,'Actividades_'))&&(!strchr($archivo,'RES_BECA_'))))
            {
                $attachs[]=$dirDoc.$archivo;
            }
        }




        $integranteMail = ($oIntegrante->getTipoIntegrante()->getOid()==6)?'Colaborador':'Integrante';
        if ($ds_tipo == 'CAMBIO') {
            $integranteMail = 'Colaborador';
        }

        switch ($ds_tipo) {
            case 'ALTA':
                $fecha = $oIntegrante->getDt_alta();
                break;
            case 'BAJA':
                $fecha = $oIntegrante->getDt_baja();
                break;
            case 'CAMBIO':
                $fecha = $oIntegrante->getDt_alta();
                break;
            case 'CAMBIODEDHS':
                $fecha = $oIntegrante->getDt_cambioHS();
                break;
            case 'CAMBIOTIPO':
                $fecha = $oIntegrante->getDt_cambioHS();
                break;

        }
        $asunto = ($ds_tipo == 'CAMBIODEDHS')?'Cambio de dedicaciÃƒÂ³n horaria':(($ds_tipo == 'CAMBIOTIPO')?'Cambio de tipo de integrate':$ds_tipo." de ".$integranteMail);
        $tipo = ($ds_tipo == 'CAMBIODEDHS')?'Cambio de dedicaciÃƒÂ³n horaria':(($ds_tipo == 'CAMBIOTIPO')?'Cambio de tipo de integrate':$ds_tipo);
        $asunto = CYT_LBL_INTEGRANTE_SOLICITUD.$asunto;
        $xtpl = new XTemplate( CYT_TEMPLATE_SOLICITUD_MAIL_ENVIAR );
        $xtpl->assign ( 'img_logo', WEB_PATH.'css/images/image002.gif' );
        $xtpl->assign('asunto', $asunto);
        $xtpl->assign('ds_codigo', $oIntegrante->getProyecto()->getDs_codigo());
        $xtpl->assign('integranteMail', $integranteMail);
        $xtpl->assign('integrante', $oIntegrante->getDocente()->getDs_apellido().', '.$oIntegrante->getDocente()->getDs_nombre().' ('.$oIntegrante->getDocente()->getNu_precuil().'-'.$oIntegrante->getDocente()->getNu_documento().'-'.$oIntegrante->getDocente()->getNu_postcuil().')');
        $xtpl->assign('tipo', $tipo);
        $xtpl->assign('fecha', CYTSecureUtils::formatDateToView($fecha));
        $xtpl->parse('main');
        $bodyMail = $xtpl->text('main');



        $oUser = CdtSecureUtils::getUserLogged();
        $userManager = CYTSecureManagerFactory::getUserManager();
        $oUsuario = $userManager->getObjectByCode($oUser->getCd_user());

        if ($oUsuario->getDs_email() != "") {

            CYTSecureUtils::sendMail($oUsuario->getDs_name(), $oUsuario->getDs_email(), $asunto, $bodyMail, $attachs);


        }


        $oCriteriaGroup = new CdtSearchCriteria();
        $oCriteriaGroup->addFilter('usergroup_oid', CYT_CD_GROUP_ADMIN_FACULTAD_PROYECTOS, '=');
        $oUserUserGroupManager = CYTSecureManagerFactory::getUserUserGroupManager();
        $oUserUserGroups = $oUserUserGroupManager->getEntities($oCriteriaGroup);
        foreach ($oUserUserGroups as $oUserUserGroup) {
            $oCriteria = new CdtSearchCriteria();
            $oCriteria->addFilter('facultad_oid', $oProyecto->getFacultad()->getOid(), '=');
            $oCriteria->addFilter('oid', $oUserUserGroup->getUser()->getOid(), '=');
            $managerUsuario =  CYTSecureManagerFactory::getUserManager();
            $oUsuarios = $managerUsuario->getEntities($oCriteria);
            foreach ($oUsuarios as $usuario) {
                if ($usuario->getDs_email() != "") {

                    CYTSecureUtils::sendMail($usuario->getDs_name(), $usuario->getDs_email(), $asunto, $bodyMail, $attachs);

                }
            }


        }

        CYTSecureUtils::sendMail(CDT_POP_MAIL_FROM_NAME, CDT_POP_MAIL_FROM, $asunto, $bodyMail, $attachs,$oUsuario->getDs_name(), $oUsuario->getDs_email());

    }

    public function confirm(Entity $entity, $admitir=1, $motivo='') {

        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
        $oCriteria->addNull('fechaHasta');
        $managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
        $oIntegranteEstado = $managerIntegranteEstado->getEntity($oCriteria);
        $procesar=1;
        switch ($oIntegranteEstado->getEstado()->getOid()) {
            case CYT_ESTADO_INTEGRANTE_ALTA_RECIBIDA:
                $dt_baja = ($admitir!=1)?$oIntegranteEstado->getDt_alta():$oIntegranteEstado->getDt_baja();
                $ds_tipo = 'ALTA';
                $fecha = ($oIntegranteEstado->getDt_alta());
                $ds_funcion = 'Alta integrante';

                break;
            case CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA:
                //$dt_baja = $oIntegranteEstado->getDt_baja();
                $dt_baja = ($admitir!=1)?null:$oIntegranteEstado->getDt_baja();
                $ds_tipo = 'BAJA';
                $fecha = ($oIntegranteEstado->getDt_baja());
                $ds_funcion = 'Baja integrante';
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_RECIBIDO:
                $dt_baja = $oIntegranteEstado->getDt_baja();
                $ds_tipo = 'CAMBIO';
                $fecha = ($oIntegranteEstado->getDt_alta());
                $ds_funcion = 'Cambio colaborador';
                if ($admitir!=1) {
                    $oCriteria = new CdtSearchCriteria();
                    $oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
                    $oCriteria->addOrder('oid','DESC');

                    $oIntegranteEstados = $managerIntegranteEstado->getEntities($oCriteria);
                    foreach ($oIntegranteEstados as $integranteEstado) {
                        if ($oIntegranteEstado->getDt_alta()!=$integranteEstado->getDt_alta()) {
                            $entity->setTipointegrante($integranteEstado->getTipointegrante());
                            $entity->setNu_horasinv($integranteEstado->getNu_horasinv());
                            $entity->setDt_alta($integranteEstado->getDt_alta());
                            break;
                        }
                    }
                }
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_HS_RECIBIDO:
                $dt_baja = $oIntegranteEstado->getDt_baja();
                $ds_tipo = 'CAMBIODEDHS';
                $fecha = ($oIntegranteEstado->getDt_cambio());
                $ds_funcion = 'Cambio Dedicacion Horaria';
                if ($admitir!=1) {
                    $entity->setDt_cambioHS(null);
                    $entity->setDs_reduccionHS(null);
                    $entity->setNu_horasinv($entity->getNu_horasinvAnt());


                }
                $entity->setNu_horasinvAnt(null);
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_RECIBIDO:
                $dt_baja = $oIntegranteEstado->getDt_baja();
                $ds_tipo = 'CAMBIOTIPO';
                $fecha = ($oIntegranteEstado->getDt_cambio());
                $ds_funcion = 'Cambio tipo de integrate';
                if ($admitir!=1) {
                    $oCriteria = new CdtSearchCriteria();
                    $oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
                    $oCriteria->addOrder('oid','DESC');

                    $oIntegranteEstados = $managerIntegranteEstado->getEntities($oCriteria);
                    $siguiente=0;
                    foreach ($oIntegranteEstados as $integranteEstado) {
                        if ($siguiente){
                            $entity->setTipointegrante($integranteEstado->getTipointegrante());
                            $entity->setNu_horasinv($integranteEstado->getNu_horasinv());
                            //$entity->setDt_alta($integranteEstado->getDt_alta());
                            break;
                        }
                        if ($integranteEstado->getMotivo()=='Iniciar cambio de tipo') {

                            $siguiente=1;
                        }
                    }
                }
                break;
            default:
                $procesar=0;
                break;
        }


        if ($procesar) {
            $ds_funcionMail = $ds_funcion;
            if ($oIntegranteEstado->getTipoIntegrante()->getOid()==6) $ds_funcionMail = str_replace('integrante','colaborador',$ds_funcionMail);
            $integranteMail = ($oIntegranteEstado->getTipoIntegrante()->getOid()==6)?'Colaborador':'Integrante';


            $confirmacion = ($admitir==1)?'Confirmacion de ':'Rechazo de ';

            $asunto = $confirmacion.$ds_funcionMail;
            $tipo = ($ds_tipo == 'CAMBIODEDHS')?'Cambio de dedicaciÃƒÂ³n horaria':(($ds_tipo == 'CAMBIOTIPO')?'Cambio de tipo de integrante':$ds_tipo);

            $oEstado = new Estado();
            $oEstado->setOid(CYT_ESTADO_INTEGRANTE_ADMITIDO);

            $oIntegranteEstadoNuevo = new IntegranteEstado();
            $oIntegranteEstadoNuevo->setIntegrante($entity);
            $oIntegranteEstadoNuevo->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
            $oIntegranteEstadoNuevo->setEstado($oEstado);
            $oIntegranteEstadoNuevo->setTipoIntegrante($entity->getTipoIntegrante());
            $oIntegranteEstadoNuevo->setCargo($entity->getCargo());
            $oIntegranteEstadoNuevo->setDeddoc($entity->getDeddoc());
            $oIntegranteEstadoNuevo->setCategoria($entity->getCategoria());
            $oIntegranteEstadoNuevo->setFacultad($entity->getFacultad());

            $oIntegranteEstadoNuevo->setCarreraInv($entity->getCarreraInv());
            $oIntegranteEstadoNuevo->setOrganismo($entity->getOrganismo());
            $oIntegranteEstadoNuevo->setDt_alta($entity->getDt_alta());
            $oIntegranteEstadoNuevo->setDs_orgbeca($entity->getDs_orgbeca());
            $oIntegranteEstadoNuevo->setDs_tipobeca($entity->getDs_tipobeca());
            $oIntegranteEstadoNuevo->setDt_beca($entity->getDt_beca());
            $oIntegranteEstadoNuevo->setDt_becaHasta($entity->getDt_becaHasta());
            $oIntegranteEstadoNuevo->setBl_becaEstimulo($entity->getBl_becaEstimulo());
            $oIntegranteEstadoNuevo->setDt_becaEstimulo($entity->getDt_becaEstimulo());
            $oIntegranteEstadoNuevo->setDt_becaEstimuloHasta($entity->getDt_becaEstimuloHasta());

            $oIntegranteEstadoNuevo->setDt_alta($entity->getDt_alta());
            $oIntegranteEstadoNuevo->setDt_baja($dt_baja);
            $oIntegranteEstadoNuevo->setDt_cambio($entity->getDt_cambioHS());
            $oIntegranteEstadoNuevo->setNu_horasinv($entity->getNu_horasinv());
            $oIntegranteEstadoNuevo->setDs_consecuencias($oIntegranteEstado->getDs_consecuencias());
            $oIntegranteEstadoNuevo->setDs_motivos($oIntegranteEstado->getDs_motivos());
            $oIntegranteEstadoNuevo->setDs_reduccionHS($oIntegranteEstado->getDs_reduccionHS());
            $oIntegranteEstadoNuevo->setMotivo(($motivo)?$motivo:$asunto);
            $oUser = CdtSecureUtils::getUserLogged();
            $oIntegranteEstadoNuevo->setUser($oUser);
            $oIntegranteEstadoNuevo->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));


            $docentesManager = CYTSecureManagerFactory::getDocenteManager();
            $oDocente = $docentesManager->getObjectByCode($entity->getDocente()->getOid());
            if ($admitir==1) {


                if ($entity->getCarrerainv()) {
                    $oDocente->setCarreraInv($entity->getCarrerainv());
                }

                if ($entity->getOrganismo()) {
                    $oDocente->setOrganismo($entity->getOrganismo());
                }

                if ($entity->getCargo()) {
                    $oDocente->setCargo($entity->getCargo());
                }

                $oDocente->setDt_cargo($entity->getDt_cargo());

                if ($entity->getDeddoc()) {
                    $oDocente->setDeddoc($entity->getDeddoc());
                }

                if ($entity->getFacultad()) {
                    $oDocente->setFacultad($entity->getFacultad());
                }

                if ($entity->getUnidad()) {
                    $oDocente->setLugarTrabajo($entity->getUnidad());
                }

                if ($entity->getDs_tipobeca()) {
                    $oDocente->setBl_becario(1);
                    $oDocente->setDs_tipobeca($entity->getDs_tipobeca());
                }

                if ($entity->getDs_orgbeca()) {
                    $oDocente->setBl_becario(1);
                    $oDocente->setDs_orgbeca($entity->getDs_orgbeca());
                    $oDocente->setDt_beca($entity->getDt_beca());
                    $oDocente->setDt_becaHasta($entity->getDt_becaHasta());
                }

                $oDocente->setDs_mail($entity->getDs_mail());

                if ($entity->getTitulo()) {
                    $oDocente->setTitulo($entity->getTitulo());
                }

                if ($entity->getTitulopost()) {
                    $oDocente->setTitulopost($entity->getTitulopost());
                }

                if ($entity->getUniversidad()) {
                    $oDocente->setUniversidad($entity->getUniversidad());
                }


                $oDocente->setBl_becaEstimulo($entity->getBl_becaEstimulo());
                $oDocente->setDt_becaEstimulo($entity->getDt_becaEstimulo());
                $oDocente->setDt_becaEstimuloHasta($entity->getDt_becaEstimuloHasta());


                $docentesManager->update($oDocente);
            }
            else{
                $entity->setCategoria($oDocente->getCategoria());
                $entity->setDeddoc($oDocente->getDeddoc());
                $entity->setCargo($oDocente->getCargo());
                $entity->setDt_cargo($oDocente->getDt_cargo());
                $entity->setFacultad($oDocente->getFacultad());
                $entity->setUnidad($oDocente->getLugarTrabajo());
                $entity->setCarrerainv($oDocente->getCarrerainv());
                $entity->setOrganismo($oDocente->getOrganismo());
                $entity->setDs_tipobeca($oDocente->getDs_tipobeca());
                $entity->setDs_orgbeca($oDocente->getDs_orgbeca());
                $entity->setDt_beca($oDocente->getDt_beca());
                $entity->setDt_becaHasta($oDocente->getDt_becaHasta());
                $entity->setTitulo($oDocente->getTitulo());
                $entity->setTitulopost($oDocente->getTitulopost());
                $entity->setUniversidad($oDocente->getUniversidad());
                $entity->setBl_becaEstimulo($oDocente->getBl_becaEstimulo());
                $entity->setDt_becaEstimulo($oDocente->getDt_becaEstimulo());
                $entity->setDt_becaEstimuloHasta($oDocente->getDt_becaEstimuloHasta());
            }

            $this->cambiarEstado($entity, $oIntegranteEstadoNuevo);




            $proyectoManager = ManagerFactory::getProyectoManager();
            $oProyecto = $proyectoManager->getObjectByCode($entity->getProyecto()->getOid());

            $xtpl = new XTemplate( CYT_TEMPLATE_SOLICITUD_MAIL_ENVIAR );
            $xtpl->assign ( 'img_logo', WEB_PATH.'css/images/image002.gif' );
            $xtpl->assign('asunto', $asunto);
            $xtpl->assign('ds_codigo', $oProyecto->getDs_codigo());
            $xtpl->assign('integranteMail', $integranteMail);
            $xtpl->assign('integrante', $entity->getDocente()->getDs_apellido().', '.$entity->getDocente()->getDs_nombre().' ('.$entity->getDocente()->getNu_precuil().'-'.$entity->getDocente()->getNu_documento().'-'.$entity->getDocente()->getNu_postcuil().')');
            $xtpl->assign('tipo', $tipo);
            $xtpl->assign('fecha', CYTSecureUtils::formatDateToView($fecha));
            $xtpl->assign('comment', $motivo);
            $xtpl->parse('main');
            $bodyMail = $xtpl->text('main');




            $oDirector = $docentesManager->getObjectByCode($oProyecto->getDirector()->getOid());

            if ($oDirector->getDs_mail() != "") {

                CYTSecureUtils::sendMail($oDirector->getDs_apellido().', '.$oDirector->getDs_nombre(), $oDirector->getDs_mail(), $asunto, $bodyMail);


            }
            $oCriteriaGroup = new CdtSearchCriteria();
            $oCriteriaGroup->addFilter('usergroup_oid', CYT_CD_GROUP_ADMIN_FACULTAD_PROYECTOS, '=');
            $oUserUserGroupManager = CYTSecureManagerFactory::getUserUserGroupManager();
            $oUserUserGroups = $oUserUserGroupManager->getEntities($oCriteriaGroup);
            foreach ($oUserUserGroups as $oUserUserGroup) {
                $oCriteria = new CdtSearchCriteria();
                $oCriteria->addFilter('facultad_oid', $oProyecto->getFacultad()->getOid(), '=');
                $oCriteria->addFilter('oid', $oUserUserGroup->getUser()->getOid(), '=');
                $managerUsuario =  CYTSecureManagerFactory::getUserManager();
                $oUsuarios = $managerUsuario->getEntities($oCriteria);
                foreach ($oUsuarios as $usuario) {
                    if ($usuario->getDs_email() != "") {

                        CYTSecureUtils::sendMail($usuario->getDs_name(), $usuario->getDs_email(), $asunto, $bodyMail, $attachs);

                    }
                }


            }
            //CYTSecureUtils::sendMail(CDT_POP_MAIL_FROM_NAME, CDT_POP_MAIL_FROM, $asunto, $bodyMail, $attachs,$oUsuario->getDs_name(), $oUsuario->getDs_email());

        }



    }


    public function anular(Entity $entity) {

        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
        $oCriteria->addNull('fechaHasta');
        $managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
        $oIntegranteEstado = $managerIntegranteEstado->getEntity($oCriteria);

        switch ($oIntegranteEstado->getEstado()->getOid()) {

            case CYT_ESTADO_INTEGRANTE_BAJA_CREADA:
                $entity->setDt_baja(null);
                $entity->setDs_consecuencias(null);
                $entity->setDs_motivos(null);
                $motivo = 'Anular baja';

                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO:

                $oCriteria = new CdtSearchCriteria();
                $oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
                $oCriteria->addOrder('oid','DESC');

                $oIntegranteEstados = $managerIntegranteEstado->getEntities($oCriteria);
                foreach ($oIntegranteEstados as $integranteEstado) {
                    if ($integranteEstado->getTipointegrante()->getOid()==CYT_INTEGRANTE_COLABORADOR) {
                        $entity->setTipointegrante($integranteEstado->getTipointegrante());
                        $entity->setNu_horasinv($integranteEstado->getNu_horasinv());
                        $entity->setDt_alta($integranteEstado->getDt_alta());
                        break;
                    }
                }
                $motivo = 'Anular cambio de colaborador';
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO:

                $entity->setDt_cambioHS(null);
                $entity->setDs_reduccionHS(null);
                $entity->setNu_horasinv($entity->getNu_horasinvAnt());
                $entity->setNu_horasinvAnt(null);
                $motivo = 'Anular cambio de dedicacion horaria';
                break;
            case CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO:

                $oCriteria = new CdtSearchCriteria();
                $oCriteria->addFilter('integrante_oid', $entity->getOid(), '=');
                $oCriteria->addOrder('oid','DESC');

                $oIntegranteEstados = $managerIntegranteEstado->getEntities($oCriteria);
                $siguiente=0;
                foreach ($oIntegranteEstados as $integranteEstado) {
                    if ($siguiente){
                        $entity->setTipointegrante($integranteEstado->getTipointegrante());
                        $entity->setNu_horasinv($integranteEstado->getNu_horasinv());
                        //$entity->setDt_alta($integranteEstado->getDt_alta());
                        break;
                    }
                    if ($integranteEstado->getMotivo()=='Iniciar cambio de tipo') {

                        $siguiente=1;
                    }
                }
                $motivo = 'Anular cambio de tipo';
                break;


        }


        $docentesManager = CYTSecureManagerFactory::getDocenteManager();
        $oDocente = $docentesManager->getObjectByCode($entity->getDocente()->getOid());
        $entity->setCategoria($oDocente->getCategoria());
        $entity->setDeddoc($oDocente->getDeddoc());
        $entity->setCargo($oDocente->getCargo());
        $entity->setDt_cargo($oDocente->getDt_cargo());
        $entity->setFacultad($oDocente->getFacultad());
        $entity->setUnidad($oDocente->getLugarTrabajo());
        $entity->setCarrerainv($oDocente->getCarrerainv());
        $entity->setOrganismo($oDocente->getOrganismo());
        $entity->setDs_tipobeca($oDocente->getDs_tipobeca());
        $entity->setDs_orgbeca($oDocente->getDs_orgbeca());
        $entity->setDt_beca($oDocente->getDt_beca());
        $entity->setDt_becaHasta($oDocente->getDt_becaHasta());
        $entity->setBl_becaEstimulo($oDocente->getBl_becaEstimulo());
        $entity->setDt_becaEstimulo($oDocente->getDt_becaEstimulo());
        $entity->setDt_becaEstimuloHasta($oDocente->getDt_becaEstimuloHasta());
        if (($oDocente->getTitulo()&&($oDocente->getTitulo()->getOid()!=9999))) {
            $entity->setTitulo($oDocente->getTitulo());
        }

        if (($oDocente->getTitulopost()&&($oDocente->getTitulopost()->getOid()!=9999))) {
            $entity->setTitulopost($oDocente->getTitulopost());
        }
        $entity->setUniversidad($oDocente->getUniversidad());



        $oEstado = new Estado();
        $oEstado->setOid(CYT_ESTADO_INTEGRANTE_ADMITIDO);

        $oIntegranteEstadoNuevo = new IntegranteEstado();
        $oIntegranteEstadoNuevo->setIntegrante($entity);
        $oIntegranteEstadoNuevo->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
        $oIntegranteEstadoNuevo->setEstado($oEstado);
        $oIntegranteEstadoNuevo->setTipoIntegrante($entity->getTipoIntegrante());
        $oIntegranteEstadoNuevo->setCargo($entity->getCargo());
        $oIntegranteEstadoNuevo->setDeddoc($entity->getDeddoc());
        $oIntegranteEstadoNuevo->setCategoria($entity->getCategoria());
        $oIntegranteEstadoNuevo->setFacultad($entity->getFacultad());

        $oIntegranteEstadoNuevo->setCarreraInv($entity->getCarreraInv());
        $oIntegranteEstadoNuevo->setOrganismo($entity->getOrganismo());
        $oIntegranteEstadoNuevo->setDt_alta($entity->getDt_alta());
        $oIntegranteEstadoNuevo->setDs_orgbeca($entity->getDs_orgbeca());
        $oIntegranteEstadoNuevo->setDs_tipobeca($entity->getDs_tipobeca());
        $oIntegranteEstadoNuevo->setDt_beca($entity->getDt_beca());
        $oIntegranteEstadoNuevo->setDt_becaHasta($entity->getDt_becaHasta());
        $oIntegranteEstadoNuevo->setBl_becaEstimulo($entity->getBl_becaEstimulo());
        $oIntegranteEstadoNuevo->setDt_becaEstimulo($entity->getDt_becaEstimulo());
        $oIntegranteEstadoNuevo->setDt_becaEstimuloHasta($entity->getDt_becaEstimuloHasta());

        $oIntegranteEstadoNuevo->setDt_alta($entity->getDt_alta());
        $oIntegranteEstadoNuevo->setDt_baja($dt_baja);
        $oIntegranteEstadoNuevo->setDt_cambio($entity->getDt_cambioHS());
        $oIntegranteEstadoNuevo->setNu_horasinv($entity->getNu_horasinv());
        $oIntegranteEstadoNuevo->setDs_consecuencias($oIntegranteEstado->getDs_consecuencias());
        $oIntegranteEstadoNuevo->setDs_motivos($oIntegranteEstado->getDs_motivos());
        $oIntegranteEstadoNuevo->setDs_reduccionHS($oIntegranteEstado->getDs_reduccionHS());
        $oIntegranteEstadoNuevo->setMotivo($motivo);
        $oUser = CdtSecureUtils::getUserLogged();
        $oIntegranteEstadoNuevo->setUser($oUser);
        $oIntegranteEstadoNuevo->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));

        $this->cambiarEstado($entity, $oIntegranteEstadoNuevo);


    }

    public function cambiarEstado(Integrante $oIntegrante, IntegranteEstado $oIntegranteEstado, $actualizarDocente = 0){



        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('integrante_oid', $oIntegrante->getOid(), '=');
        $oCriteria->addNull('fechaHasta');
        $managerIntegranteEstado =  ManagerFactory::getIntegranteEstadoManager();
        $integranteEstado = $managerIntegranteEstado->getEntity($oCriteria);
        if (!empty($integranteEstado)) {
            if (($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO)&&($integranteEstado->getMotivo()!='Iniciar cambio de tipo')){
                $oIntegranteEstado->setMotivo('Iniciar cambio de tipo');
            }
            //print_r($integranteEstado->getUser());
            $integranteEstado->setFechaHasta(date(DB_DEFAULT_DATETIME_FORMAT));
            /*$oUser = CdtSecureUtils::getUserLogged();
            $integranteEstado->setUser($oUser);*/
            $integranteEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
            $integranteEstado->setIntegrante($oIntegrante);
            $managerIntegranteEstado->update($integranteEstado);
            $managerIntegranteEstado->add($oIntegranteEstado);
            $oIntegrante->setEstado($oIntegranteEstado->getEstado());
            $oIntegrante->setTipoIntegrante($oIntegranteEstado->getTipoIntegrante());
            $oIntegrante->setCargo($oIntegranteEstado->getCargo());
            $oIntegrante->setDeddoc($oIntegranteEstado->getDeddoc());
            $oIntegrante->setCategoria($oIntegranteEstado->getCategoria());
            $oIntegrante->setFacultad($oIntegranteEstado->getFacultad());
            $oIntegrante->setDt_alta($oIntegranteEstado->getDt_alta());
            $oIntegrante->setDt_baja($oIntegranteEstado->getDt_baja());
            $oIntegrante->setDt_cambioHS($oIntegranteEstado->getDt_cambio());
            $oIntegrante->setNu_horasinv($oIntegranteEstado->getNu_horasinv());

            $oIntegrante->setCarreraInv($oIntegranteEstado->getCarreraInv());

            $oIntegrante->setOrganismo($oIntegranteEstado->getOrganismo());
            $oIntegrante->setDt_alta($oIntegranteEstado->getDt_alta());
            $oIntegrante->setDs_orgbeca($oIntegranteEstado->getDs_orgbeca());
            $oIntegrante->setDs_tipobeca($oIntegranteEstado->getDs_tipobeca());
            $oIntegrante->setDt_beca($oIntegranteEstado->getDt_beca());
            $oIntegrante->setDt_becaHasta($oIntegranteEstado->getDt_becaHasta());
            $oIntegrante->setBl_becaEstimulo($oIntegranteEstado->getBl_becaEstimulo());
            $oIntegrante->setDt_becaEstimulo($oIntegranteEstado->getDt_becaEstimulo());
            $oIntegrante->setDt_becaEstimuloHasta($oIntegranteEstado->getDt_becaEstimuloHasta());


            $managerIntegrante =  ManagerFactory::getIntegranteManager();
            $managerIntegrante->updatesinvalidar($oIntegrante);

            $docentesManager = CYTSecureManagerFactory::getDocenteManager();
            $oDocente = $docentesManager->getObjectByCode($oIntegrante->getDocente()->getOid());
            if ($actualizarDocente==1) {
                if ($oIntegrante->getCategoria()) {
                    $oDocente->setCategoria($oIntegrante->getCategoria());
                }
                if ($oIntegrante->getCargo()) {
                    $oDocente->setCargo($oIntegrante->getCargo());
                }
                if ($oIntegrante->getDeddoc()) {
                    $oDocente->setDeddoc($oIntegrante->getDeddoc());
                }
                if ($oIntegrante->getFacultad()) {
                    $oDocente->setFacultad($oIntegrante->getFacultad());
                }
                if ($oIntegrante->getCarreraInv()) {
                    $oDocente->setCarreraInv($oIntegrante->getCarreraInv());
                }
                if ($oIntegrante->getOrganismo()) {
                    $oDocente->setOrganismo($oIntegrante->getOrganismo());
                }
                if ($oIntegrante->getDs_tipobeca()) {
                    $oDocente->setBl_becario(1);

                }
                else{
                    $oDocente->setBl_becario(0);
                }
                $oDocente->setDs_tipobeca($oIntegrante->getDs_tipobeca());
                $oDocente->setDs_orgbeca($oIntegrante->getDs_orgbeca());


                $oDocente->setDt_beca($oIntegrante->getDt_beca());
                $oDocente->setDt_becaHasta($oIntegrante->getDt_becaHasta());

                $oDocente->setBl_becaEstimulo($oIntegrante->getBl_becaEstimulo());
                $oDocente->setDt_becaEstimulo($oIntegrante->getDt_becaEstimulo());
                $oDocente->setDt_becaEstimuloHasta($oIntegrante->getDt_becaEstimuloHasta());


                $docentesManager->update($oDocente);
            }

        }
        else{
            if (($oIntegranteEstado->getEstado()->getOid()==CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO)){
                $oIntegranteEstado->setMotivo('Iniciar cambio de tipo');
            }
            $managerIntegranteEstado->add($oIntegranteEstado);
        }

    }

}
?>
