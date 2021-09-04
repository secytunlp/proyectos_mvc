<?php

/**
 * DAO para Integrante
 *  
 * @author Marcos
 * @since 30-10-2013
 */
class IntegranteDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_INTEGRANTE;
	}
	
	public function getEntityFactory(){
		return new IntegranteFactory();
	}
	
	public function getFieldsToAdd($entity){

		$fieldsValues = array();

		$fieldsValues["cd_proyecto"] = $this->formatIfNull( $entity->getProyecto()->getOid(), 'null' );
		$fieldsValues["cd_docente"] = $this->formatIfNull( $entity->getDocente()->getOid(), 'null' );
		$fieldsValues["cd_tipoinvestigador"] = $this->formatIfNull( $entity->getTipoIntegrante()->getOid(), 'null' );
		$fieldsValues["dt_alta"] = $this->formatDate( $entity->getDt_alta() );
		$fieldsValues["dt_baja"] = $this->formatDate( $entity->getDt_baja() );
		$fieldsValues["nu_horasinv"] = $this->formatIfNull( $entity->getNu_horasinv(), '0' );
		$fieldsValues["ds_curriculum"] = $this->formatString( $entity->getDs_curriculum() );
		$fieldsValues["ds_actividades"] = $this->formatString( $entity->getDs_actividades() );
		$fieldsValues["ds_resolucionBeca"] = $this->formatString( $entity->getDs_resolucionBeca() );
		$fieldsValues["ds_consecuencias"] = $this->formatString( $entity->getDs_consecuencias() );
		$fieldsValues["cd_estado"] = $this->formatIfNull( $entity->getEstado()->getOid(), 'null' );
		$fieldsValues["ds_motivos"] = $this->formatString( $entity->getDs_motivos() );
		$fieldsValues["cd_categoria"] = $this->formatIfNull( $entity->getCategoria()->getOid(), 'null' );
		$fieldsValues["cd_deddoc"] = $this->formatIfNull( $entity->getDeddoc()->getOid(), 'null' );
		$fieldsValues["cd_cargo"] = $this->formatIfNull( $entity->getCargo()->getOid(), 'null' );
		$fieldsValues["dt_cargo"] = $this->formatDate( $entity->getDt_cargo() );
		$fieldsValues["cd_facultad"] = $this->formatIfNull( $entity->getFacultad()->getOid(), 'null' );
		$fieldsValues["cd_unidad"] = $this->formatIfNull( $entity->getUnidad()->getOid(), 'null' );
		$fieldsValues["cd_universidad"] = $this->formatIfNull( $entity->getUniversidad()->getOid(), 'null' );
		$fieldsValues["cd_carrerainv"] = $this->formatIfNull( $entity->getCarrerainv()->getOid(), 'null' );
		$fieldsValues["cd_organismo"] = $this->formatIfNull( $entity->getOrganismo()->getOid(), 'null' );
		$fieldsValues["ds_orgbeca"] = $this->formatString( $entity->getDs_orgbeca() );
		$fieldsValues["ds_tipobeca"] = $this->formatString( $entity->getDs_tipobeca() );
		$fieldsValues["dt_beca"] = $this->formatDate( $entity->getDt_beca() );
		$fieldsValues["dt_becaHasta"] = $this->formatDate( $entity->getDt_becaHasta() );
		$fieldsValues["cd_titulo"] = $this->formatIfNull( $entity->getTitulo()->getOid(), 'null' );
		$fieldsValues["cd_titulopost"] = $this->formatIfNull( $entity->getTitulopost()->getOid(), 'null' );
		$fieldsValues["nu_materias"] = $this->formatIfNull( $entity->getNu_materias(), '0' );
		$fieldsValues["ds_mail"] = $this->formatString( $entity->getDs_mail() );
		$fieldsValues["nu_horasinvAnt"] = $this->formatIfNull( $entity->getNu_horasinvAnt(), '0' );
		$fieldsValues["dt_cambioHS"] = $this->formatDate( $entity->getDt_cambioHS() );
		$fieldsValues["ds_reduccionHS"] = $this->formatString( $entity->getDs_reduccionHS() );
		$fieldsValues["bl_becaEstimulo"] = $this->formatIfNull( $entity->getBl_becaEstimulo(), '0' );
		$fieldsValues["dt_becaEstimulo"] = $this->formatDate( $entity->getDt_becaEstimulo() );
		$fieldsValues["dt_becaEstimuloHasta"] = $this->formatDate( $entity->getDt_becaEstimuloHasta() );
		

		return $fieldsValues;
	}
	
	public function getFieldsToUpdate($entity){

		$fieldsValues = array();

		$fieldsValues["cd_tipoinvestigador"] = $this->formatIfNull( $entity->getTipoIntegrante()->getOid(), 'null' );
		$fieldsValues["dt_alta"] = $this->formatDate( $entity->getDt_alta() );
		$fieldsValues["dt_baja"] = $this->formatDate( $entity->getDt_baja() );
		$fieldsValues["nu_horasinv"] = $this->formatIfNull( $entity->getNu_horasinv(), '0' );
		$fieldsValues["ds_curriculum"] = $this->formatString( $entity->getDs_curriculum() );
		$fieldsValues["ds_actividades"] = $this->formatString( $entity->getDs_actividades() );
		$fieldsValues["ds_resolucionBeca"] = $this->formatString( $entity->getDs_resolucionBeca() );
		$fieldsValues["ds_consecuencias"] = $this->formatString( $entity->getDs_consecuencias() );
		$fieldsValues["cd_estado"] = $this->formatIfNull( $entity->getEstado()->getOid(), 'null' );
		$fieldsValues["ds_motivos"] = $this->formatString( $entity->getDs_motivos() );
		$fieldsValues["cd_categoria"] = $this->formatIfNull( $entity->getCategoria()->getOid(), 'null' );
		$fieldsValues["cd_deddoc"] = $this->formatIfNull( $entity->getDeddoc()->getOid(), 'null' );
		$fieldsValues["cd_cargo"] = $this->formatIfNull( $entity->getCargo()->getOid(), 'null' );
		$fieldsValues["dt_cargo"] = $this->formatDate( $entity->getDt_cargo() );
		$fieldsValues["cd_facultad"] = $this->formatIfNull( $entity->getFacultad()->getOid(), 'null' );
		$fieldsValues["cd_unidad"] = $this->formatIfNull( $entity->getUnidad()->getOid(), 'null' );
		$fieldsValues["cd_universidad"] = $this->formatIfNull( $entity->getUniversidad()->getOid(), 'null' );
		$fieldsValues["cd_carrerainv"] = $this->formatIfNull( $entity->getCarrerainv()->getOid(), 'null' );
		$fieldsValues["cd_organismo"] = $this->formatIfNull( $entity->getOrganismo()->getOid(), 'null' );
		$fieldsValues["ds_orgbeca"] = $this->formatString( $entity->getDs_orgbeca() );
		$fieldsValues["ds_tipobeca"] = $this->formatString( $entity->getDs_tipobeca() );
		$fieldsValues["dt_beca"] = $this->formatDate( $entity->getDt_beca() );
		$fieldsValues["dt_becaHasta"] = $this->formatDate( $entity->getDt_becaHasta() );
		$fieldsValues["cd_titulo"] = $this->formatIfNull( $entity->getTitulo()->getOid(), 'null' );
		$fieldsValues["cd_titulopost"] = $this->formatIfNull( $entity->getTitulopost()->getOid(), 'null' );
		$fieldsValues["nu_materias"] = $this->formatIfNull( $entity->getNu_materias(), '0' );
		$fieldsValues["ds_mail"] = $this->formatString( $entity->getDs_mail() );
		$fieldsValues["nu_horasinvAnt"] = $this->formatIfNull( $entity->getNu_horasinvAnt(), '0' );
		$fieldsValues["dt_cambioHS"] = $this->formatDate( $entity->getDt_cambioHS() );
		$fieldsValues["ds_reduccionHS"] = $this->formatString( $entity->getDs_reduccionHS() );
		$fieldsValues["bl_becaEstimulo"] = $this->formatIfNull( $entity->getBl_becaEstimulo(), '0' );
		$fieldsValues["dt_becaEstimulo"] = $this->formatDate( $entity->getDt_becaEstimulo() );
		$fieldsValues["dt_becaEstimuloHasta"] = $this->formatDate( $entity->getDt_becaEstimuloHasta() );
		return $fieldsValues;
	}
	
	public function getFieldsToBaja($entity){

		$fieldsValues = array();

		
		$fieldsValues["dt_baja"] = $this->formatDate( $entity->getDt_baja() );
		$fieldsValues["ds_consecuencias"] = $this->formatString( $entity->getDs_consecuencias() );
		$fieldsValues["cd_estado"] = $this->formatIfNull( $entity->getEstado()->getOid(), 'null' );
		$fieldsValues["ds_motivos"] = $this->formatString( $entity->getDs_motivos() );
		
		

		return $fieldsValues;
	}
	
	
	public function getFromToSelect(){
		
		$tIntegrante = $this->getTableName();
		$tTipoIntegrante = DAOFactory::getTipoIntegranteDAO()->getTableName();
		$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
		$tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
		$tCarrerainv = CYTSecureDAOFactory::getCarrerainvDAO()->getTableName();
		$tOrganismo = CYTSecureDAOFactory::getOrganismoDAO()->getTableName();
		$tUniversidad = CYTSecureDAOFactory::getUniversidadDAO()->getTableName();
		$tCargo = CYTSecureDAOFactory::getCargoDAO()->getTableName();
		$tDeddoc = CYTSecureDAOFactory::getDeddocDAO()->getTableName();
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		$tLugarTrabajo = CYTSecureDAOFactory::getLugarTrabajoDAO()->getTableName();
		$tEstado = DAOFactory::getEstadoIntegranteDAO()->getTableName();
		$tIntegranteEstado = DAOFactory::getINtegranteEstadoDAO()->getTableName();
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$tTitulo = CYTSecureDAOFactory::getTituloDAO()->getTableName();
		
		
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tProyecto . " ON($tIntegrante.cd_proyecto = $tProyecto.cd_proyecto)";
        $sql .= " LEFT JOIN " . $tDocente . " ON($tIntegrante.cd_docente = $tDocente.cd_docente)";
        $sql .= " LEFT JOIN " . $tTitulo . " ON($tIntegrante.cd_titulo = $tTitulo.cd_titulo)";
        $sql .= " LEFT JOIN " . $tTitulo . " Titulopost ON($tIntegrante.cd_titulopost = Titulopost.cd_titulo)";
        $sql .= " LEFT JOIN " . $tCategoria . " ON($tIntegrante.cd_categoria = $tCategoria.cd_categoria)";
        $sql .= " LEFT JOIN " . $tCarrerainv . " ON($tIntegrante.cd_carrerainv = $tCarrerainv.cd_carrerainv)";
        $sql .= " LEFT JOIN " . $tOrganismo . " ON($tIntegrante.cd_organismo = $tOrganismo.cd_organismo)";
        $sql .= " LEFT JOIN " . $tUniversidad . " ON($tIntegrante.cd_universidad = $tUniversidad.cd_universidad)";
        $sql .= " LEFT JOIN " . $tCargo . " ON($tIntegrante.cd_cargo = $tCargo.cd_cargo)";
        $sql .= " LEFT JOIN " . $tDeddoc . " ON($tIntegrante.cd_deddoc = $tDeddoc.cd_deddoc)";
        $sql .= " LEFT JOIN " . $tFacultad . " ON($tIntegrante.cd_facultad = $tFacultad.cd_facultad)";
        $sql .= " LEFT JOIN " . $tLugarTrabajo . " LugarTrabajo ON($tIntegrante.cd_unidad = LugarTrabajo.cd_unidad)";
        $sql .= " INNER JOIN " . $tIntegranteEstado . " ON($tIntegranteEstado.integrante_oid = $tIntegrante.oid)";
        $sql .= " LEFT JOIN " . $tEstado . " ON($tIntegranteEstado.estado_oid = $tEstado.cd_estado)";
        $sql .= " LEFT JOIN " . $tTipoIntegrante . " ON($tIntegranteEstado.tipoinvestigador_oid = $tTipoIntegrante.cd_tipoinvestigador)";
        
        
        
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$tTipoIntegrante = DAOFactory::getTipoIntegranteDAO()->getTableName();
		$tProyecto = DAOFactory::getProyectoDAO()->getTableName();
		$tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
		$tCarrerainv = CYTSecureDAOFactory::getCarrerainvDAO()->getTableName();
		$tOrganismo = CYTSecureDAOFactory::getOrganismoDAO()->getTableName();
		$tCargo = CYTSecureDAOFactory::getCargoDAO()->getTableName();
		$tDeddoc = CYTSecureDAOFactory::getDeddocDAO()->getTableName();
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$tLugarTrabajo = "LugarTrabajo";
		$tTitulo = CYTSecureDAOFactory::getTituloDAO()->getTableName();
		$tUniversidad = CYTSecureDAOFactory::getUniversidadDAO()->getTableName();
		
		
		$fields = parent::getFieldsToSelect();
		
        $fields[] = "$tTipoIntegrante.cd_tipoinvestigador as " . $tTipoIntegrante . "_oid ";
        $fields[] = "$tTipoIntegrante.ds_tipoinvestigador as " . $tTipoIntegrante . "_ds_tipoinvestigador ";
        
        $fields[] = "$tProyecto.cd_proyecto as " . $tProyecto . "_oid ";
        $fields[] = "$tProyecto.ds_codigo as " . $tProyecto . "_ds_codigo ";
        
        $fields[] = "$tDocente.cd_docente as " . $tDocente . "_oid ";
        $fields[] = "$tDocente.ds_nombre as " . $tDocente . "_ds_nombre ";
        $fields[] = "$tDocente.ds_apellido as " . $tDocente . "_ds_apellido ";
        $fields[] = "$tDocente.nu_precuil as " . $tDocente . "_nu_precuil ";
        $fields[] = "$tDocente.nu_documento as " . $tDocente . "_nu_documento ";
        $fields[] = "$tDocente.nu_postcuil as " . $tDocente . "_nu_postcuil ";
        
        $fields[] = "$tCategoria.cd_categoria as " . $tCategoria . "_oid ";
        $fields[] = "$tCategoria.ds_categoria as " . $tCategoria . "_ds_categoria ";
        
        $fields[] = "$tCarrerainv.cd_carrerainv as " . $tCarrerainv . "_oid ";
        $fields[] = "$tCarrerainv.ds_carrerainv as " . $tCarrerainv . "_ds_carrerainv ";
        
        $fields[] = "$tOrganismo.cd_organismo as " . $tOrganismo . "_oid ";
        $fields[] = "$tOrganismo.ds_codigo as " . $tOrganismo . "_ds_codigo ";
        
        $fields[] = "$tUniversidad.cd_universidad as " . $tUniversidad . "_oid ";
        $fields[] = "$tUniversidad.ds_universidad as " . $tUniversidad . "_ds_universidad ";
        
        $fields[] = "$tCargo.cd_cargo as " . $tCargo . "_oid ";
        $fields[] = "$tCargo.ds_cargo as " . $tCargo . "_ds_cargo ";
        
        $fields[] = "$tDeddoc.cd_deddoc as " . $tDeddoc . "_oid ";
        $fields[] = "$tDeddoc.ds_deddoc as " . $tDeddoc . "_ds_deddoc ";
        
        $fields[] = "$tFacultad.cd_facultad as " . $tFacultad . "_oid ";
        $fields[] = "$tFacultad.ds_facultad as " . $tFacultad . "_ds_facultad ";
        
        $fields[] = "$tLugarTrabajo.cd_unidad as " . $tLugarTrabajo . "_oid ";
        $fields[] = "$tLugarTrabajo.ds_unidad as " . $tLugarTrabajo . "_ds_unidad ";
        $fields[] = "$tLugarTrabajo.ds_sigla as " . $tLugarTrabajo . "_ds_sigla ";
        
        $tEstado = DAOFactory::getEstadoIntegranteDAO()->getTableName();
		$fields[] = "$tEstado.cd_estado as " . $tEstado . "_oid ";
        $fields[] = "$tEstado.ds_estado as " . $tEstado . "_ds_estado ";
        
        $tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
		$fields[] = "$tIntegranteEstado.oid as " . $tIntegranteEstado . "_oid ";
        $fields[] = "$tIntegranteEstado.fechaDesde as " . $tIntegranteEstado . "_fechaDesde ";
        $fields[] = "$tIntegranteEstado.fechaHasta as " . $tIntegranteEstado . "_fechaHasta ";
       	$fields[] = "$tIntegranteEstado.dt_alta as " . $tIntegranteEstado . "_dt_alta ";
        $fields[] = "$tIntegranteEstado.dt_baja as " . $tIntegranteEstado . "_dt_baja ";
        
        $fields[] = "$tTitulo.cd_titulo as " . $tTitulo . "_oid ";
        $fields[] = "$tTitulo.ds_titulo as " . $tTitulo . "_ds_titulo ";
        
        $fields[] = "Titulopost.cd_titulo as Tituloposgrado_oid ";
        $fields[] = "Titulopost.ds_titulo as Tituloposgrado_ds_titulo ";
       
        
        return $fields;
	}	
	
	
	
	public function deleteIntegrantePorUnidad($unidad_oid, $idConn=0) {
    	
        $db = CdtDbManager::getConnection( $idConn );

        
        
        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE unidad_oid = $unidad_oid ";

        CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }
	
	
	
	
/**
     * se modifica la entity
     * @param $entity entity a modificar.
     */
    public function updateBaja($entity, $idConn=0) {
        
    	$db = CdtDbManager::getConnection($idConn);

		$fields = $this->getFieldsToBaja( $entity );
        
        $strFieldsValues = array();
        foreach ($fields as $name => $value) {
        	$strFieldsValues[] = $name . "=" . $value;
        }
        
        $strFieldsValues = implode( ",", $strFieldsValues);
        
        $tableName = $this->getTableName();
    	        
        $id = CdtFormatUtils::ifEmpty( $this->getId($entity), 'null');

        $tableName = $this->getTableName();

        $idName = $this->getIdFieldName();
        
        $sql = "UPDATE $tableName SET $strFieldsValues WHERE $idName = $id ";

        //CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

	
	
}
?>