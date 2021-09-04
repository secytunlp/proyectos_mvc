<?php

/**
 * Proyecto
 *
 * @author Marcos
 * @since 12-11-2013
 */

class ProyectoDirector extends Entity{

	//variables de instancia.

	
		private $ds_titulo;
		private $ds_codigo;
		private $dt_ini;
		private $dt_fin;
		
		private $facultad;
		
		private $director;
		
		private $tipoAcreditacion;
		
		private $estado;
		
		private $ds_abstract1;
		
		private $ds_abstracteng;

		private $ds_clave1;
		private $ds_clave2;
		private $ds_clave3;
		private $ds_clave4;
		private $ds_clave5;
		private $ds_clave6;
		
		private $ds_claveeng1;
		private $ds_claveeng2;
		private $ds_claveeng3;
		private $ds_claveeng4;
		private $ds_claveeng5;
		private $ds_claveeng6;
		
		private $ds_tipo;
		
		private $ds_linea;
		
		private $cd_disciplina;
		
		private $cd_especialidad;
		
		private $cd_campo;
		
		private $ds_codigoSIGEVA;
		
		private $cd_unidad;
		
		
	public function __construct(){
		 
			$this->ds_titulo = '';
			$this->ds_codigo = '';
			$this->dt_fin = '';
			$this->dt_inc = '';
			$this->dt_ini = '';
			$this->facultad = new Facultad();
			$this->director = new Docente();
			$this->tipoAcreditacion = new TipoAcreditacion();
			$this->estado = new Estado();
	}




public function __toString(){
		
		return $this->getDs_codigo().' '.$this->getDs_titulo();
	}

	


		public function getDs_titulo()
		{
		    return $this->ds_titulo;
		}

		public function setDs_titulo($ds_titulo)
		{
		    $this->ds_titulo = $ds_titulo;
		}

		public function getDs_codigo()
		{
		    return $this->ds_codigo;
		}

		public function setDs_codigo($ds_codigo)
		{
		    $this->ds_codigo = $ds_codigo;
		}

		public function getDt_ini()
		{
		    return $this->dt_ini;
		}

		public function setDt_ini($dt_ini)
		{
		    $this->dt_ini = $dt_ini;
		}

		public function getDt_fin()
		{
		    return $this->dt_fin;
		}

		public function setDt_fin($dt_fin)
		{
		    $this->dt_fin = $dt_fin;
		}

		public function getFacultad()
		{
		    return $this->facultad;
		}

		public function setFacultad($facultad)
		{
		    $this->facultad = $facultad;
		}

		public function getDirector()
		{
		    return $this->director;
		}

		public function setDirector($director)
		{
		    $this->director = $director;
		}

		public function getTipoAcreditacion()
		{
		    return $this->tipoAcreditacion;
		}

		public function setTipoAcreditacion($tipoAcreditacion)
		{
		    $this->tipoAcreditacion = $tipoAcreditacion;
		}

		

		public function getEstado()
		{
		    return $this->estado;
		}

		public function setEstado($estado)
		{
		    $this->estado = $estado;
		}

		public function getDs_abstract1()
		{
		    return $this->ds_abstract1;
		}

		public function setDs_abstract1($ds_abstract1)
		{
		    $this->ds_abstract1 = $ds_abstract1;
		}

		public function getDs_abstracteng()
		{
		    return $this->ds_abstracteng;
		}

		public function setDs_abstracteng($ds_abstracteng)
		{
		    $this->ds_abstracteng = $ds_abstracteng;
		}

		public function getDs_clave1()
		{
		    return $this->ds_clave1;
		}

		public function setDs_clave1($ds_clave1)
		{
		    $this->ds_clave1 = $ds_clave1;
		}

		public function getDs_clave2()
		{
		    return $this->ds_clave2;
		}

		public function setDs_clave2($ds_clave2)
		{
		    $this->ds_clave2 = $ds_clave2;
		}

		public function getDs_clave3()
		{
		    return $this->ds_clave3;
		}

		public function setDs_clave3($ds_clave3)
		{
		    $this->ds_clave3 = $ds_clave3;
		}

		public function getDs_clave4()
		{
		    return $this->ds_clave4;
		}

		public function setDs_clave4($ds_clave4)
		{
		    $this->ds_clave4 = $ds_clave4;
		}

		public function getDs_clave5()
		{
		    return $this->ds_clave5;
		}

		public function setDs_clave5($ds_clave5)
		{
		    $this->ds_clave5 = $ds_clave5;
		}

		public function getDs_clave6()
		{
		    return $this->ds_clave6;
		}

		public function setDs_clave6($ds_clave6)
		{
		    $this->ds_clave6 = $ds_clave6;
		}

		public function getDs_claveeng1()
		{
		    return $this->ds_claveeng1;
		}

		public function setDs_claveeng1($ds_claveeng1)
		{
		    $this->ds_claveeng1 = $ds_claveeng1;
		}

		public function getDs_claveeng2()
		{
		    return $this->ds_claveeng2;
		}

		public function setDs_claveeng2($ds_claveeng2)
		{
		    $this->ds_claveeng2 = $ds_claveeng2;
		}

		public function getDs_claveeng3()
		{
		    return $this->ds_claveeng3;
		}

		public function setDs_claveeng3($ds_claveeng3)
		{
		    $this->ds_claveeng3 = $ds_claveeng3;
		}

		public function getDs_claveeng4()
		{
		    return $this->ds_claveeng4;
		}

		public function setDs_claveeng4($ds_claveeng4)
		{
		    $this->ds_claveeng4 = $ds_claveeng4;
		}

		public function getDs_claveeng5()
		{
		    return $this->ds_claveeng5;
		}

		public function setDs_claveeng5($ds_claveeng5)
		{
		    $this->ds_claveeng5 = $ds_claveeng5;
		}

		public function getDs_claveeng6()
		{
		    return $this->ds_claveeng6;
		}

		public function setDs_claveeng6($ds_claveeng6)
		{
		    $this->ds_claveeng6 = $ds_claveeng6;
		}

		public function getDs_tipo()
		{
		    return $this->ds_tipo;
		}

		public function setDs_tipo($ds_tipo)
		{
		    $this->ds_tipo = $ds_tipo;
		}

		public function getDs_linea()
		{
		    return $this->ds_linea;
		}

		public function setDs_linea($ds_linea)
		{
		    $this->ds_linea = $ds_linea;
		}

		public function getCd_disciplina()
		{
		    return $this->cd_disciplina;
		}

		public function setCd_disciplina($cd_disciplina)
		{
		    $this->cd_disciplina = $cd_disciplina;
		}

		public function getCd_especialidad()
		{
		    return $this->cd_especialidad;
		}

		public function setCd_especialidad($cd_especialidad)
		{
		    $this->cd_especialidad = $cd_especialidad;
		}

		public function getCd_campo()
		{
		    return $this->cd_campo;
		}

		public function setCd_campo($cd_campo)
		{
		    $this->cd_campo = $cd_campo;
		}

		public function getDs_codigoSIGEVA()
		{
		    return $this->ds_codigoSIGEVA;
		}

		public function setDs_codigoSIGEVA($ds_codigoSIGEVA)
		{
		    $this->ds_codigoSIGEVA = $ds_codigoSIGEVA;
		}

		public function getCd_unidad()
		{
		    return $this->cd_unidad;
		}

		public function setCd_unidad($cd_unidad)
		{
		    $this->cd_unidad = $cd_unidad;
		}
}
?>