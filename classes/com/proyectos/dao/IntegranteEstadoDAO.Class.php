<?php

/**
 * DAO para Integrante Estado
 *
 * @author Marcos
 * @since 03-11-2016
 */
class IntegranteEstadoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_INTEGRANTE_ESTADO;
	}

	public function getEntityFactory(){
		return new IntegranteEstadoFactory();
	}
	
	public function getFieldsToAdd($entity){

		$fieldsValues = array();

		
		$fieldsValues["integrante_oid"] = $this->formatIfNull( $entity->getIntegrante()->getOid(), 'null' );
		$fieldsValues["estado_oid"] = $this->formatIfNull( $entity->getEstado()->getOid(), 'null' );
		$fieldsValues["tipoInvestigador_oid"] = $this->formatIfNull( $entity->getTipoIntegrante()->getOid(), 'null' );
		$fieldsValues["categoria_oid"] = $this->formatIfNull( $entity->getCategoria()->getOid(), 'null' );
		$fieldsValues["cargo_oid"] = $this->formatIfNull( $entity->getCargo()->getOid(), 'null' );
		$fieldsValues["deddoc_oid"] = $this->formatIfNull( $entity->getDeddoc()->getOid(), 'null' );
		$fieldsValues["facultad_oid"] = $this->formatIfNull( $entity->getFacultad()->getOid(), 'null' );
		$fieldsValues["dt_alta"] = $this->formatDate( $entity->getDt_alta() );
		$fieldsValues["dt_baja"] = $this->formatDate( $entity->getDt_baja() );
		$fieldsValues["dt_cambio"] = $this->formatDate( $entity->getDt_cambio() );
		$fieldsValues["nu_horasinv"] = $this->formatIfNull( $entity->getNu_horasinv(), 'null' );
		$fieldsValues["ds_motivos"] = $this->formatString( $entity->getDs_motivos() );
		$fieldsValues["ds_consecuencias"] = $this->formatString( $entity->getDs_consecuencias() );
		$fieldsValues["ds_reduccionHS"] = $this->formatString( $entity->getDs_reduccionHS() );
		
		$fieldsValues["fechaDesde"] = $this->formatDate( $entity->getFechaDesde() );
		$fieldsValues["fechaHasta"] = $this->formatDate( $entity->getFechaHasta() );
		$fieldsValues["motivo"] = $this->formatString( $entity->getMotivo() );
		$fieldsValues["user_oid"] = $this->formatIfNull( $entity->getUser()->getCd_user(), 'null' );
		$fieldsValues["fechaUltModificacion"] = $this->formatString($entity->getFechaUltModificacion());
		
	
		$fieldsValues["carrerainv_oid"] = $this->formatIfNull( $entity->getCarrerainv()->getOid(), 'null' );
		
		$fieldsValues["organismo_oid"] = $this->formatIfNull( $entity->getOrganismo()->getOid(), 'null' );
		$fieldsValues["ds_orgbeca"] = $this->formatString( $entity->getDs_orgbeca() );
		$fieldsValues["ds_tipobeca"] = $this->formatString( $entity->getDs_tipobeca() );
		$fieldsValues["dt_beca"] = $this->formatDate( $entity->getDt_beca() );
		$fieldsValues["dt_becaHasta"] = $this->formatDate( $entity->getDt_becaHasta() );
		$fieldsValues["bl_becaEstimulo"] = $this->formatIfNull( $entity->getBl_becaEstimulo(), '0' );
		$fieldsValues["dt_becaEstimulo"] = $this->formatDate( $entity->getDt_becaEstimulo() );
		$fieldsValues["dt_becaEstimuloHasta"] = $this->formatDate( $entity->getDt_becaEstimuloHasta() );
		

		return $fieldsValues;
	}
	
	public function getFieldsToUpdate($entity){

		$fieldsValues = array();

		
		$fieldsValues["integrante_oid"] = $this->formatIfNull( $entity->getIntegrante()->getOid(), 'null' );
		$fieldsValues["estado_oid"] = $this->formatIfNull( $entity->getEstado()->getOid(), 'null' );
		$fieldsValues["tipoInvestigador_oid"] = $this->formatIfNull( $entity->getTipoIntegrante()->getOid(), 'null' );
		$fieldsValues["categoria_oid"] = $this->formatIfNull( $entity->getCategoria()->getOid(), 'null' );
		$fieldsValues["cargo_oid"] = $this->formatIfNull( $entity->getCargo()->getOid(), 'null' );
		$fieldsValues["deddoc_oid"] = $this->formatIfNull( $entity->getDeddoc()->getOid(), 'null' );
		$fieldsValues["facultad_oid"] = $this->formatIfNull( $entity->getFacultad()->getOid(), 'null' );
		$fieldsValues["dt_alta"] = $this->formatDate( $entity->getDt_alta() );
		$fieldsValues["dt_baja"] = $this->formatDate( $entity->getDt_baja() );
		$fieldsValues["dt_cambio"] = $this->formatDate( $entity->getDt_cambio() );
		$fieldsValues["nu_horasinv"] = $this->formatIfNull( $entity->getNu_horasinv(), 'null' );
		$fieldsValues["ds_motivos"] = $this->formatString( $entity->getDs_motivos() );
		$fieldsValues["ds_consecuencias"] = $this->formatString( $entity->getDs_consecuencias() );
		$fieldsValues["ds_reduccionHS"] = $this->formatString( $entity->getDs_reduccionHS() );
		
		$fieldsValues["fechaDesde"] = $this->formatDate( $entity->getFechaDesde() );
		$fieldsValues["fechaHasta"] = $this->formatDate( $entity->getFechaHasta() );
		$fieldsValues["motivo"] = $this->formatString( $entity->getMotivo() );
		//$fieldsValues["user_oid"] = $this->formatIfNull( $entity->getUser()->getCd_user(), 'null' );
		$fieldsValues["fechaUltModificacion"] = $this->formatString($entity->getFechaUltModificacion());
		
		
		$fieldsValues["carrerainv_oid"] = $this->formatIfNull( $entity->getCarrerainv()->getOid(), 'null' );
		
		$fieldsValues["organismo_oid"] = $this->formatIfNull( $entity->getOrganismo()->getOid(), 'null' );
		$fieldsValues["ds_orgbeca"] = $this->formatString( $entity->getDs_orgbeca() );
		$fieldsValues["ds_tipobeca"] = $this->formatString( $entity->getDs_tipobeca() );
		$fieldsValues["dt_beca"] = $this->formatDate( $entity->getDt_beca() );
		$fieldsValues["dt_becaHasta"] = $this->formatDate( $entity->getDt_becaHasta() );
		$fieldsValues["bl_becaEstimulo"] = $this->formatIfNull( $entity->getBl_becaEstimulo(), '0' );
		$fieldsValues["dt_becaEstimulo"] = $this->formatDate( $entity->getDt_becaEstimulo() );
		$fieldsValues["dt_becaEstimuloHasta"] = $this->formatDate( $entity->getDt_becaEstimuloHasta() );

		return $fieldsValues;
	}
	
	public function getFromToSelect(){
		
		$tIntegranteEstado = $this->getTableName();
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$tIntegrante = DAOFactory::getIntegranteDAO()->getTableName();
		$tEstado = DAOFactory::getEstadoIntegranteDAO()->getTableName();
		$tTipoIntegrante = DAOFactory::getTipoIntegranteDAO()->getTableName();
		$tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
		$tCargo = CYTSecureDAOFactory::getCargoDAO()->getTableName();
		$tDeddoc = CYTSecureDAOFactory::getDeddocDAO()->getTableName();
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
		$tUser = CYTSecureDAOFactory::getUserDAO()->getTableName();
		$tCarrerainv = CYTSecureDAOFactory::getCarrerainvDAO()->getTableName();
		$tOrganismo = CYTSecureDAOFactory::getOrganismoDAO()->getTableName();
		
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tIntegrante . " ON($tIntegranteEstado.integrante_oid = $tIntegrante.oid)";
       	$sql .= " LEFT JOIN " . $tEstado . " ON($tIntegranteEstado.estado_oid = $tEstado.cd_estado)";
       	$sql .= " LEFT JOIN " . $tTipoIntegrante . " ON($tIntegranteEstado.tipoInvestigador_oid = $tTipoIntegrante.cd_tipoinvestigador)";
        $sql .= " LEFT JOIN " . $tDocente . " ON($tIntegrante.cd_docente = $tDocente.cd_docente)";
        $sql .= " LEFT JOIN " . $tCategoria . " ON($tIntegranteEstado.categoria_oid = $tCategoria.cd_categoria)";
        $sql .= " LEFT JOIN " . $tCargo . " ON($tIntegranteEstado.cargo_oid = $tCargo.cd_cargo)";
        $sql .= " LEFT JOIN " . $tDeddoc . " ON($tIntegranteEstado.deddoc_oid = $tDeddoc.cd_deddoc)";
        $sql .= " LEFT JOIN " . $tFacultad . " ON($tIntegranteEstado.facultad_oid = $tFacultad.cd_facultad)";
        $sql .= " LEFT JOIN " . $tProyecto . " ON($tIntegrante.cd_proyecto = $tProyecto.cd_proyecto)";
        $sql .= " LEFT JOIN " . $tUser . " ON($tIntegranteEstado.user_oid = $tUser.oid)";
        $sql .= " LEFT JOIN " . $tCarrerainv . " ON($tIntegranteEstado.carrerainv_oid = $tCarrerainv.cd_carrerainv)";
        $sql .= " LEFT JOIN " . $tOrganismo . " ON($tIntegranteEstado.organismo_oid = $tOrganismo.cd_organismo)";
        
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$tEstado = DAOFactory::getEstadoIntegranteDAO()->getTableName();
		
		
		$fields = parent::getFieldsToSelect();
		
                
        $tIntegrante = DAOFactory::getIntegranteDAO()->getTableName();
		$fields[] = "$tIntegrante.oid as " . $tIntegrante . "_oid ";
        
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$fields[] = "$tDocente.cd_docente as " . $tDocente . "_oid ";
        $fields[] = "$tDocente.ds_nombre as " . $tDocente . "_ds_nombre ";
        $fields[] = "$tDocente.ds_apellido as " . $tDocente . "_ds_apellido ";
       
        $tProyecto = DAOFactory::getProyectoDAO()->getTableName();
        $fields[] = "$tProyecto.cd_proyecto as " . $tProyecto . "_oid ";
        $fields[] = "$tProyecto.ds_codigo as " . $tProyecto . "_ds_codigo ";
        
        $tTipoIntegrante = DAOFactory::getTipoIntegranteDAO()->getTableName();
		$fields[] = "$tTipoIntegrante.cd_tipoinvestigador as " . $tTipoIntegrante . "_oid ";
        $fields[] = "$tTipoIntegrante.ds_tipoinvestigador as " . $tTipoIntegrante . "_ds_tipoinvestigador ";
        
        $tEstado = DAOFactory::getEstadoIntegranteDAO()->getTableName();
		$fields[] = "$tEstado.cd_estado as " . $tEstado . "_oid ";
        $fields[] = "$tEstado.ds_estado as " . $tEstado . "_ds_estado ";
        
        $tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
		$tCargo = CYTSecureDAOFactory::getCargoDAO()->getTableName();
		$tDeddoc = CYTSecureDAOFactory::getDeddocDAO()->getTableName();
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		
		$fields[] = "$tCategoria.cd_categoria as " . $tCategoria . "_oid ";
        $fields[] = "$tCategoria.ds_categoria as " . $tCategoria . "_ds_categoria ";
        
        $fields[] = "$tCargo.cd_cargo as " . $tCargo . "_oid ";
        $fields[] = "$tCargo.ds_cargo as " . $tCargo . "_ds_cargo ";
        
        $fields[] = "$tDeddoc.cd_deddoc as " . $tDeddoc . "_oid ";
        $fields[] = "$tDeddoc.ds_deddoc as " . $tDeddoc . "_ds_deddoc ";
        
        $fields[] = "$tFacultad.cd_facultad as " . $tFacultad . "_oid ";
        $fields[] = "$tFacultad.ds_facultad as " . $tFacultad . "_ds_facultad ";
        
        /*$tUser = CYT_TABLE_CDT_USER;
		$fields[] = "$tUser.oid";
        $fields[] = "CASE $tUser.ds_name WHEN '' THEN $tUser.ds_username ELSE $tUser.ds_name END AS ds_username";*/
        
        $tUser = CYTSecureDAOFactory::getUserDAO()->getTableName();
		$fields[] = "$tUser.oid AS ".$tUser."_oid";
        $fields[] = "CASE $tUser.ds_name WHEN '' THEN $tUser.ds_username ELSE $tUser.ds_name END AS ds_username";
        
        $tCarrerainv = CYTSecureDAOFactory::getCarrerainvDAO()->getTableName();
        $fields[] = "$tCarrerainv.cd_carrerainv as " . $tCarrerainv . "_oid ";
        $fields[] = "$tCarrerainv.ds_carrerainv as " . $tCarrerainv . "_ds_carrerainv ";
        
		$tOrganismo = CYTSecureDAOFactory::getOrganismoDAO()->getTableName();
		$fields[] = "$tOrganismo.cd_organismo as " . $tOrganismo . "_oid ";
        $fields[] = "$tOrganismo.ds_codigo as " . $tOrganismo . "_ds_codigo ";
        
       
        
        return $fields;
	}	
	
	public function deleteIntegranteEstadoPorIntegrante($integrante_oid, $idConn=0) {
    	
        $db = CdtDbManager::getConnection( $idConn );

        
        
        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE integrante_oid = $integrante_oid ";

       // CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>