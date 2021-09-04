<?php

/**
 * DAO para Proyecto
 *  
 * @author Marcos
 * @since 12-11-2013
 */
class ProyectoDirectorDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_PROYECTO;
	}
	
	public function getEntityFactory(){
		return new ProyectoDirectorFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_proyecto";
	}
	
	
public function getFromToSelect(){
		
		$tProyecto = $this->getTableName();
		
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		$tIntegrante = DAOFactory::getIntegranteDAO()->getTableName();
		$tIntegranteEstado = DAOFactory::getIntegranteEstadoDAO()->getTableName();
		$tEstado = DAOFactory::getEstadoDAO()->getTableName();
		
		
		
        $sql  = parent::getFromToSelect();
       
        $sql .= " LEFT JOIN " . $tFacultad . " ON($tProyecto.cd_facultad = $tFacultad.cd_facultad)";
        $sql .= " LEFT JOIN " . $tIntegrante . " ON($tProyecto.cd_proyecto = $tIntegrante.cd_proyecto) ";
        $sql .= " INNER JOIN " . $tIntegranteEstado . " ON($tIntegrante.oid = $tIntegranteEstado.integrante_oid) AND ($tIntegranteEstado.tipoInvestigador_oid =".CYT_TIPO_INTEGRANTE_DIRECTOR.") AND $tIntegranteEstado.fechaHasta is Null";
        $sql .= " LEFT JOIN " . $tDocente . " ON($tIntegrante.cd_docente = $tDocente.cd_docente)";
        $sql .= " LEFT JOIN " . $tEstado . " ON($tProyecto.cd_estado = $tEstado.cd_estado)";
        
       
        
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		
		
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		
		
		$fields = parent::getFieldsToSelect();
		
        $fields[] = "$tFacultad.cd_facultad as " . $tFacultad . "_oid ";
        $fields[] = "$tFacultad.ds_facultad as " . $tFacultad . "_ds_facultad ";
        
        $tIntegrante = DAOFactory::getIntegranteDAO()->getTableName();
        //$fields[] = "$tIntegrante.cd_integrante as " . $tIntegrante . "_oid ";
        
       	
        $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
        $fields[] = "$tDocente.cd_docente as " . $tDocente . "_oid ";
        $fields[] = "$tDocente.ds_apellido as " . $tDocente . "_ds_apellido ";
        $fields[] = "$tDocente.ds_nombre as " . $tDocente . "_ds_nombre ";
        
       	$tEstado = DAOFactory::getEstadoDAO()->getTableName();
        $fields[] = "$tEstado.cd_estado as " . $tEstado . "_oid ";
        $fields[] = "$tEstado.ds_estado as " . $tEstado . "_ds_estado ";
        
        return $fields;
	}
	
	

	
	
}
?>