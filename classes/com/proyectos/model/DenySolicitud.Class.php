<?php

/**
 * DenySolicitud
 *
 * @author Marcos
 * @since 18-11-2016
 */

class DenySolicitud extends Entity{

	//variables de instancia.
	
	

	private $integrante;
	
	private $estado;
	
	private $tipoIntegrante;
	
	private $observaciones;
	

	public function __construct(){
		
		$this->integrante = new Integrante();
		
		$this->estado = new Estado();
		
		$this->tipoIntegrante = new TipoIntegrante();
		
		$this->observaciones = "";
		
	}



	

	public function getIntegrante()
	{
	    return $this->integrante;
	}

	public function setIntegrante($integrante)
	{
	    $this->integrante = $integrante;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	public function getTipoIntegrante()
	{
	    return $this->tipoIntegrante;
	}

	public function setTipoIntegrante($tipoIntegrante)
	{
	    $this->tipoIntegrante = $tipoIntegrante;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}
}
?>