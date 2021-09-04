<?php

/**
 * Factory para Managers
 *  
 * @author Marcos
 * @since 16-10-2013
 */
class ManagerFactory{
	
	public static function getProyectoManager(){
		return new ProyectoDirectorManager();
	}
	
	
	public static function getTipoIntegranteManager(){
		return new TipoIntegranteManager();
	}
	
	public static function getIntegranteManager(){
		return new IntegranteManager();
	}
	
	public static function getIntegranteEstadoManager(){
		return new IntegranteEstadoManager();
	}
	
	public static function getEstadoIntegranteManager(){
		return new EstadoIntegranteManager();
	}
	
}

?>