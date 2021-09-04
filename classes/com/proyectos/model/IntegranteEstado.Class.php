<?php

/**
 * IntegranteEstado
 *
 * @author Marcos
 * @since 02-11-2016
 */

class IntegranteEstado extends Entity{

	//variables de instancia.
	
	private $integrante;

	private $estado;
	
	private $tipoIntegrante;
	
	private $dt_alta;
	
	private $dt_baja;
	
	private $dt_cambio;
	
	private $nu_horasinv;
	
	private $ds_consecuencias;
	
	private $ds_motivos;
	
	private $ds_reduccionHS;
	
	
	
	private $fechaDesde;
	
	private $fechaHasta;
	
	private $motivo;
	
	private $docente;
	
	private $proyecto;
	
	private $user;
	private $fechaUltModificacion;
	
	private $categoria;
	    
	private $cargo;  
	
	private $deddoc;
	
	private $facultad;
	
	private $carreraInv;  
	

	
	private $organismo;
	  
	private $ds_orgbeca; 
	
	private $ds_tipobeca;

	private $dt_beca;
	
	private $dt_becaHasta;
	
	
	
	private $bl_becaEstimulo;
	
	private $dt_becaEstimulo;
	
	private $dt_becaEstimuloHasta;


	public function __construct(){
		 
		$this->integrante = new Integrante();
		
		$this->estado = new Estado();
		
		$this->tipoIntegrante = new TipoIntegrante();
			
		$this->fechaDesde = "";
		
		$this->fechaHasta = "";
		
		$this->motivo = "";
		
		$this->categoria = new Categoria();
		  
		$this->cargo = new Cargo();  
		
		$this->deddoc = new DedDoc();
		
		$this->facultad = new Facultad();
		
		$this->user = new User();		
		$this->fechaUltModificacion = "";
		
		$this->carreraInv = new CarreraInv();
	
	
		
		$this->organismo = new Organismo();
		  
		$this->ds_orgbeca = ""; 
		
		$this->ds_tipobeca= ""; 
	
		$this->dt_beca= ""; 
		
		$this->dt_becaHasta = ""; 
		
		
		
		$this->bl_becaEstimulo=0;
		
		$this->dt_becaEstimulo = ""; 
		
		$this->dt_becaEstimuloHasta = ""; 
		
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

	public function getDt_alta()
	{
	    return $this->dt_alta;
	}

	public function setDt_alta($dt_alta)
	{
	    $this->dt_alta = $dt_alta;
	}

	public function getDt_baja()
	{
	    return $this->dt_baja;
	}

	public function setDt_baja($dt_baja)
	{
	    $this->dt_baja = $dt_baja;
	}

	public function getDt_cambio()
	{
	    return $this->dt_cambio;
	}

	public function setDt_cambio($dt_cambio)
	{
	    $this->dt_cambio = $dt_cambio;
	}

	public function getNu_horasinv()
	{
	    return $this->nu_horasinv;
	}

	public function setNu_horasinv($nu_horasinv)
	{
	    $this->nu_horasinv = $nu_horasinv;
	}

	public function getDs_consecuencias()
	{
	    return $this->ds_consecuencias;
	}

	public function setDs_consecuencias($ds_consecuencias)
	{
	    $this->ds_consecuencias = $ds_consecuencias;
	}

	public function getDs_motivos()
	{
	    return $this->ds_motivos;
	}

	public function setDs_motivos($ds_motivos)
	{
	    $this->ds_motivos = $ds_motivos;
	}

	public function getDs_reduccionHS()
	{
	    return $this->ds_reduccionHS;
	}

	public function setDs_reduccionHS($ds_reduccionHS)
	{
	    $this->ds_reduccionHS = $ds_reduccionHS;
	}

	public function getFechaDesde()
	{
	    return $this->fechaDesde;
	}

	public function setFechaDesde($fechaDesde)
	{
	    $this->fechaDesde = $fechaDesde;
	}

	public function getFechaHasta()
	{
	    return $this->fechaHasta;
	}

	public function setFechaHasta($fechaHasta)
	{
	    $this->fechaHasta = $fechaHasta;
	}

	public function getMotivo()
	{
	    return $this->motivo;
	}

	public function setMotivo($motivo)
	{
	    $this->motivo = $motivo;
	}

	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}

	public function getFechaUltModificacion()
	{
	    return $this->fechaUltModificacion;
	}

	public function setFechaUltModificacion($fechaUltModificacion)
	{
	    $this->fechaUltModificacion = $fechaUltModificacion;
	}

	public function getDocente()
	{
	    return $this->docente;
	}

	public function setDocente($docente)
	{
	    $this->docente = $docente;
	}

	public function getProyecto()
	{
	    return $this->proyecto;
	}

	public function setProyecto($proyecto)
	{
	    $this->proyecto = $proyecto;
	}

	public function getCategoria()
	{
	    return $this->categoria;
	}

	public function setCategoria($categoria)
	{
	    $this->categoria = $categoria;
	}

	public function getCargo()
	{
	    return $this->cargo;
	}

	public function setCargo($cargo)
	{
	    $this->cargo = $cargo;
	}

	public function getDeddoc()
	{
	    return $this->deddoc;
	}

	public function setDeddoc($deddoc)
	{
	    $this->deddoc = $deddoc;
	}

	public function getFacultad()
	{
	    return $this->facultad;
	}

	public function setFacultad($facultad)
	{
	    $this->facultad = $facultad;
	}

	public function getCarreraInv()
	{
	    return $this->carreraInv;
	}

	public function setCarreraInv($carreraInv)
	{
	    $this->carreraInv = $carreraInv;
	}

	

	public function getOrganismo()
	{
	    return $this->organismo;
	}

	public function setOrganismo($organismo)
	{
	    $this->organismo = $organismo;
	}

	public function getDs_orgbeca()
	{
	    return $this->ds_orgbeca;
	}

	public function setDs_orgbeca($ds_orgbeca)
	{
	    $this->ds_orgbeca = $ds_orgbeca;
	}

	public function getDs_tipobeca()
	{
	    return $this->ds_tipobeca;
	}

	public function setDs_tipobeca($ds_tipobeca)
	{
	    $this->ds_tipobeca = $ds_tipobeca;
	}

	public function getDt_beca()
	{
	    return $this->dt_beca;
	}

	public function setDt_beca($dt_beca)
	{
	    $this->dt_beca = $dt_beca;
	}

	public function getDt_becaHasta()
	{
	    return $this->dt_becaHasta;
	}

	public function setDt_becaHasta($dt_becaHasta)
	{
	    $this->dt_becaHasta = $dt_becaHasta;
	}

	

	public function getBl_becaEstimulo()
	{
	    return $this->bl_becaEstimulo;
	}

	public function setBl_becaEstimulo($bl_becaEstimulo)
	{
	    $this->bl_becaEstimulo = $bl_becaEstimulo;
	}

	public function getDt_becaEstimulo()
	{
	    return $this->dt_becaEstimulo;
	}

	public function setDt_becaEstimulo($dt_becaEstimulo)
	{
	    $this->dt_becaEstimulo = $dt_becaEstimulo;
	}

	public function getDt_becaEstimuloHasta()
	{
	    return $this->dt_becaEstimuloHasta;
	}

	public function setDt_becaEstimuloHasta($dt_becaEstimuloHasta)
	{
	    $this->dt_becaEstimuloHasta = $dt_becaEstimuloHasta;
	}
}
?>