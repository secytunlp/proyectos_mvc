<?php

/**
 * Integrante
 *
 * @author Marcos
 * @since 02-11-2016
 */

class Integrante extends Entity{

	//variables de instancia.

	private $cuil;
	
	private $ds_apellido;
	
	private $ds_nombre;
	
	private $ds_mail;
	
	private $proyecto;
	
	private $docente;

	private $tipoIntegrante;
	 
	
	
	private $categoria;
	  
	private $carreraInv;  
	
	private $dt_carrerainv;
	
	private $organismo;
	  
	private $ds_orgbeca; 
	
	private $ds_tipobeca;

	private $dt_beca;
	
	private $dt_becaHasta;
	  
	private $cargo;  
	
	private $dt_cargo;
	
	private $deddoc;
	
	private $facultad;
	
	private $universidad;
	  
	private $unidad;  
	
	private $nu_horasinv;
	
	private $nu_horasinvAnt;
	  
	private $dt_alta; 
	
	private $dt_baja;
	 
	private $titulo;  
	
	private $titulopost; 
	
	private $ds_curriculum; 
	
	private $ds_actividades;
	
	private $ds_resolucionBeca;
	
	private $ds_consecuencias;
	
	private $ds_motivos;
	
	private $estado;
	
	private $dt_cambioHS;
	
	private $ds_reduccionHS;

	private $bl_estudiante;
	
	private $nu_materias;
	
	private $bl_mincategorizados;
	
	private $bl_minmayordedicacion;
	
	private $bl_becaEstimulo;
	
	private $dt_becaEstimulo;
	
	private $dt_becaEstimuloHasta;

    private $nu_totalMat;

    private $ds_carrera;
	
	public function __construct(){
		 
		$this->proyecto = new Proyecto();
		
		$this->docente = new Docente();

		$this->tipoIntegrante = new TipoIntegrante();
		 
		
		$this->categoria = new Categoria();
		  
		$this->carreraInv = new CarreraInv();  
		
		$this->organismo = new Organismo();
		  
		$this->beca = "";  
		  
		$this->cargo = new Cargo();  
		
		$this->deddoc = new DedDoc();
		
		$this->facultad = new Facultad();
		
		$this->universidad = new Universidad();
		  
		$this->unidad = new LugarTrabajo();  
		
		$this->nu_horasinv = "";
		  
		$this->dt_alta = ""; 
		
		$this->dt_baja = "";
		
		$this->titulo = new Titulo(); 
		 
		$this->titulopost = new Titulo();




	}


	public function __toString(){
		
		return $this->getProyecto()->getDs_codigo().' - '.$this->getDocente()->getDs_apellido();
	}




		public function getProyecto()
		{
		    return $this->proyecto;
		}

		public function setProyecto($proyecto)
		{
		    $this->proyecto = $proyecto;
		}

		public function getTipoIntegrante()
		{
		    return $this->tipoIntegrante;
		}

		public function setTipoIntegrante($tipoIntegrante)
		{
		    $this->tipoIntegrante = $tipoIntegrante;
		}

		public function getCategoria()
		{
		    return $this->categoria;
		}

		public function setCategoria($categoria)
		{
		    $this->categoria = $categoria;
		}

		public function getCarreraInv()
		{
		    return $this->carreraInv;
		}

		public function setCarreraInv($carreraInv)
		{
		    $this->carreraInv = $carreraInv;
		}

		public function getDt_carrerainv()
		{
		    return $this->dt_carrerainv;
		}

		public function setDt_carrerainv($dt_carrerainv)
		{
		    $this->dt_carrerainv = $dt_carrerainv;
		}

		public function getOrganismo()
		{
		    return $this->organismo;
		}

		public function setOrganismo($organismo)
		{
		    $this->organismo = $organismo;
		}

		

		public function getDt_beca()
		{
		    return $this->dt_beca;
		}

		public function setDt_beca($dt_beca)
		{
		    $this->dt_beca = $dt_beca;
		}

		public function getCargo()
		{
		    return $this->cargo;
		}

		public function setCargo($cargo)
		{
		    $this->cargo = $cargo;
		}

		public function getDt_cargo()
		{
		    return $this->dt_cargo;
		}

		public function setDt_cargo($dt_cargo)
		{
		    $this->dt_cargo = $dt_cargo;
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

		public function getUnidad()
		{
		    return $this->unidad;
		}

		public function setUnidad($unidad)
		{
		    $this->unidad = $unidad;
		}

		public function getNu_horasinv()
		{
		    return $this->nu_horasinv;
		}

		public function setNu_horasinv($nu_horasinv)
		{
		    $this->nu_horasinv = $nu_horasinv;
		}

		public function getNu_horasinvAnt()
		{
		    return $this->nu_horasinvAnt;
		}

		public function setNu_horasinvAnt($nu_horasinvAnt)
		{
		    $this->nu_horasinvAnt = $nu_horasinvAnt;
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

		public function getTitulo()
		{
		    return $this->titulo;
		}

		public function setTitulo($titulo)
		{
		    $this->titulo = $titulo;
		}

		public function getTitulopost()
		{
		    return $this->titulopost;
		}

		public function setTitulopost($titulopost)
		{
		    $this->titulopost = $titulopost;
		}

		public function getDs_curriculum()
		{
		    return $this->ds_curriculum;
		}

		public function setDs_curriculum($ds_curriculum)
		{
		    $this->ds_curriculum = $ds_curriculum;
		}

		public function getDs_actividades()
		{
		    return $this->ds_actividades;
		}

		public function setDs_actividades($ds_actividades)
		{
		    $this->ds_actividades = $ds_actividades;
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

		public function getEstado()
		{
		    return $this->estado;
		}

		public function setEstado($estado)
		{
		    $this->estado = $estado;
		}

		public function getDt_cambioHS()
		{
		    return $this->dt_cambioHS;
		}

		public function setDt_cambioHS($dt_cambioHS)
		{
		    $this->dt_cambioHS = $dt_cambioHS;
		}

		public function getDs_reduccionHS()
		{
		    return $this->ds_reduccionHS;
		}

		public function setDs_reduccionHS($ds_reduccionHS)
		{
		    $this->ds_reduccionHS = $ds_reduccionHS;
		}

		public function getBl_estudiante()
		{
		    return $this->bl_estudiante;
		}

		public function setBl_estudiante($bl_estudiante)
		{
		    $this->bl_estudiante = $bl_estudiante;
		}

		public function getNu_materias()
		{
		    return $this->nu_materias;
		}

		public function setNu_materias($nu_materias)
		{
		    $this->nu_materias = $nu_materias;
		}

	public function getDocente()
	{
	    return $this->docente;
	}

	public function setDocente($docente)
	{
	    $this->docente = $docente;
	}

	public function getCuil()
	{
	    return $this->cuil;
	}

	public function setCuil($cuil)
	{
	    $this->cuil = $cuil;
	}

	public function getDs_apellido()
	{
	    return $this->ds_apellido;
	}

	public function setDs_apellido($ds_apellido)
	{
	    $this->ds_apellido = $ds_apellido;
	}

	public function getDs_nombre()
	{
	    return $this->ds_nombre;
	}

	public function setDs_nombre($ds_nombre)
	{
	    $this->ds_nombre = $ds_nombre;
	}

	public function getUniversidad()
	{
	    return $this->universidad;
	}

	public function setUniversidad($universidad)
	{
	    $this->universidad = $universidad;
	}

	public function getDs_mail()
	{
	    return $this->ds_mail;
	}

	public function setDs_mail($ds_mail)
	{
	    $this->ds_mail = $ds_mail;
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

	public function getBl_mincategorizados()
	{
	    return $this->bl_mincategorizados;
	}

	public function setBl_mincategorizados($bl_mincategorizados)
	{
	    $this->bl_mincategorizados = $bl_mincategorizados;
	}

	public function getBl_minmayordedicacion()
	{
	    return $this->bl_minmayordedicacion;
	}

	public function setBl_minmayordedicacion($bl_minmayordedicacion)
	{
	    $this->bl_minmayordedicacion = $bl_minmayordedicacion;
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

	public function getDt_becaHasta()
	{
	    return $this->dt_becaHasta;
	}

	public function setDt_becaHasta($dt_becaHasta)
	{
	    $this->dt_becaHasta = $dt_becaHasta;
	}

	public function getDt_becaEstimuloHasta()
	{
	    return $this->dt_becaEstimuloHasta;
	}

	public function setDt_becaEstimuloHasta($dt_becaEstimuloHasta)
	{
	    $this->dt_becaEstimuloHasta = $dt_becaEstimuloHasta;
	}

	public function getDs_resolucionBeca()
	{
	    return $this->ds_resolucionBeca;
	}

	public function setDs_resolucionBeca($ds_resolucionBeca)
	{
	    $this->ds_resolucionBeca = $ds_resolucionBeca;
	}

    /**
     * @return mixed
     */
    public function getNu_totalMat()
    {
        return $this->nu_totalMat;
    }

    /**
     * @param mixed $nu_totalMat
     */
    public function setNu_totalMat($nu_totalMat)
    {
        $this->nu_totalMat = $nu_totalMat;
    }

    /**
     * @return mixed
     */
    public function getDs_carrera()
    {
        return $this->ds_carrera;
    }

    /**
     * @param mixed $ds_carrera
     */
    public function setDs_carrera($ds_carrera)
    {
        $this->ds_carrera = $ds_carrera;
    }
}
?>