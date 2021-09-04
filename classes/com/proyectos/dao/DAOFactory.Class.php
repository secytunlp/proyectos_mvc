<?php

/**
 * Factory para DAOs
 *
 * @author Marcos
 * @since 16-10-2013
 */
class DAOFactory{


	
	
	
	public static function getEstadoDAO(){
		return new EstadoDAO();
	}

	
	
	public static function getTipoIntegranteDAO(){
		return new TipoIntegranteDAO();
	}
	
	public static function getProyectoDAO(){
		return new ProyectoDirectorDAO();
	}
	
	
	public static function getIntegranteDAO(){
		return new IntegranteDAO();
	}
	
	public static function getEstadoIntegranteDAO(){
		return new EstadoIntegranteDAO();
	}
	
	public static function getIntegranteEstadoDAO(){
		return new IntegranteEstadoDAO();
	}
	
}
?>
