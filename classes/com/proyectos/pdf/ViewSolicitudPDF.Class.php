<?php

/**
 * PDF de Alta de Integrante
 * 
 * @author Marcos
 * @since 16/11/2106
 */
class ViewSolicitudPDF extends CdtPDFPrint{

	private $maxWidth = "";	
	
	private $year = "";
	
	private $estado_oid = "";
	
	private $mes = "";
	
	private $tipo = "";
	
	private $docente_oid = "";
	
	private $ds_facultad = "";
	 
	private $ds_titulo = "";
	
	private $ds_duracion = "";
	
	private $ds_codigo = "";
	
	private $dt_ini = "";
	
	private $dt_fin = "";
	
	private $ds_director = "";
	
	private $ds_tipo = "";
	
	private $ds_investigador = "";
	
	private $nu_cuil = "";
	
	private $ds_categoria = "";
	
	private $ds_titulogrado = "";
	
	private $ds_tituloposgrado = "";
	
	private $ds_cargo = "";
	
	private $ds_deddoc = "";
	
	private $ds_facultadintegrante = "";
	
	private $ds_universidad = "";
	
	private $ds_carrinv = "";
	
	private $ds_organismo = "";
	
	private $ds_tipobeca = "";
	
	private $ds_orgbeca = "";
	
	private $ds_unidad = "";
	
	private $nu_horasinv = "";
	
	private $ds_tipoinvestigador = "";
	
	private $ds_tipointegrante = "";
	
	private $proyectos;
	
	private $dt_baja = "";
	
	private $ds_consecuencias = "";
	
	private $ds_motivos = "";
	
	private $dt_alta = "";
	
	private $dt_cargo = "";
	
	private $dt_beca = "";
	
	private $dt_becaHasta = "";
	
	private $nu_materias = "";
	
	private $nu_horasinvAnt = "";
	
	private $ds_reduccionHS = "";
	
	private $minhstotales = "";
	
	private $dt_cambioHS = "";
	
	private $dt_becaEstimulo = "";
	
	private $dt_becaEstimuloHasta = "";
	
	private $bl_becaEstimulo = "";
	
	
	public function __construct(){
		
		parent::__construct();
		$this->setProyectos(new ItemCollection());
		
		
	}
	
	function printSolicitud(  ){
	
		$this->facultad();
		$this->identificacion();
		$this->director();
		$this->integrante();
		$this->firma();
	}
	
	function facultad() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 40, 6, "UNIDAD ACADEMICA");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 145, 6, $this->encodeCharacters($this->getDs_facultad()), 'LTBR',0,'L',1);
		
		$this->ln(8);
		
	}
	
	
	function identificacion() {
		$this->SetFillColor(200,200,200);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, "IDENTIFICACION DEL PROYECTO",0,0,'',1);
		$this->ln(8);
		$this->SetFillColor(255,255,255);
		$this->Cell ( 20, 6, "CODIGO:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 20, 6, $this->encodeCharacters($this->getDs_codigo()), 'LTBR',0,'L',1);
		$this->Cell ( 30, 6, "");
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 25, 6, "DURACION:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 90, 6, $this->encodeCharacters($this->getDs_duracion()), 'LTBR',0,'L',1);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->ln(8);
		$this->Cell ( 60, 6, "DENOMINACION DEL PROYECTO:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->MultiCell ( 125, 4, $this->encodeCharacters($this->getDs_titulo()), 'LTBR','L',1);
		$this->ln(3);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 35, 6, "FECHA DE INICIO:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 30, 6, CYTSecureUtils::formatDateToView($this->getDt_ini()), 'LTBR',0,'L',1);
		$this->Cell ( 30, 6, "");
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 35, 6, "FECHA DE FIN:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 30, 6, CYTSecureUtils::formatDateToView($this->getDt_fin()), 'LTBR',0,'L',1);
		
		$this->ln(8);
	}
	
	function director() {
		$this->SetFillColor(200,200,200);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, "DIRECTOR",0,0,'',1);
		$this->ln(8);
		$this->SetFillColor(255,255,255);
		$this->Cell ( 40, 6, "Apellido y Nombres:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 145, 6, $this->encodeCharacters($this->getDs_director()), 'LTBR',0,'L',1);	
		$this->ln(8);
	}
	
	function integrante() {
		$ds_tipoSTR = ($this->getDs_tipo()=='CAMBIODEDHS')?'CAMBIO EN LA DED. HORARIA':$this->getDs_tipo();
		$this->SetFillColor(200,200,200);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, $ds_tipoSTR." - IDENTIFICACION DEL ".$this->getDs_tipointegrante(),0,0,'',1);
		$this->ln(8);
		$this->SetFillColor(255,255,255);
		$this->Cell ( 40, 6, "Apellido y Nombres:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 145, 6, $this->encodeCharacters($this->getDs_investigador()), 'LTBR',0,'L',1);	
		$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 20, 6, "C.U.I.L.:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 30, 6, $this->getNu_cuil(), 'LTBR',0,'L',1);	
		$this->Cell ( 30, 6, "");
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 65, 6, $this->encodeCharacters("Categoría de Docente Investigador:"));
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 40, 6, $this->encodeCharacters($this->getDs_categoria()), 'LTBR',0,'L',1);	
		if (($this->getDs_tipo() == 'ALTA')||($this->getDs_tipo() == 'CAMBIO')){
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			if ($this->getDs_titulogrado()=='') {
				
				$this->Cell ( 30, 6, "Estudiante:");
				$this->SetFont ( 'Arial', '', 10 );
				$bl_estudiante = ($this->getNu_materias()>0)?'SI':'NO';
				$this->Cell ( 10, 6, stripslashes($bl_estudiante), 'LTBR',0,'L',1);
				$this->Cell ( 40, 6, '', 'L',0,'L',1);
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 40, 6, "Materias Adeudadas:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 20, 6, $this->getNu_materias(), 'LTBR',0,'L',1);
				$this->ln(8);
			}
			else{
				
				$this->Cell ( 40, 6, $this->encodeCharacters("Título de Grado:"));
				$this->SetFont ( 'Arial', '', 10 );
				$this->MultiCell( 145, 4, $this->encodeCharacters($this->getDs_titulogrado()), 'LTBR','L');	
				$this->ln(3);
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 40, 6, $this->encodeCharacters("Título de posgrado:"));
				$this->SetFont ( 'Arial', '', 10 );
				$this->MultiCell( 145, 4, $this->encodeCharacters($this->getDs_tituloposgrado()), 'LTBR','L');	
				$this->ln(3);
			}
		}
		else 
			$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 40, 6, "Cargo docente:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 80, 6, $this->encodeCharacters($this->getDs_cargo()), 'LTBR',0,'L',1);	
		$this->Cell ( 20, 6, "");
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 25, 6, $this->encodeCharacters("Dedicación:"));
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 20, 6, $this->encodeCharacters($this->getDs_deddoc()), 'LTBR',0,'L',1);	
		if (($this->getDs_tipo() == 'CAMBIO')||($this->getDs_tipo() == 'CAMBIODEDHS')) {
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 80, 6, $this->encodeCharacters("Fecha Obtención Cargo:"));
			$this->SetFont ( 'Arial', '', 10 );
			//$dt=(FuncionesComunes::fechaMysqlaPHP($dt_cargo)!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($dt_cargo):'';
			$this->Cell ( 20, 6, CYTSecureUtils::formatDateToView($this->getDt_cargo()), 'LTBR',0,'L',1);
		}
		$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 40, 6, "Carrera del Inv.:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 60, 6, $this->encodeCharacters($this->getDs_carrinv()), 'LTBR',0,'L',1);
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 22, 6, "Organismo:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 63, 6, $this->encodeCharacters($this->getDs_organismo()), 'LTBR',0,'L',1);	
		
		$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 20, 6, "Becario:");
		$this->SetFont ( 'Arial', '', 10 );
		$ds_becario = ($this->getDs_tipobeca()!='')?'SI':'NO';
		$this->Cell ( 10, 6, stripslashes($ds_becario), 'LTBR',0,'L',1);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 10, 6, "Tipo:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 60, 6, $this->encodeCharacters($this->getDs_tipobeca()), 'LTBR',0,'L',1);
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 22, 6, $this->encodeCharacters("Institución:"));
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 63, 6, $this->encodeCharacters($this->getDs_orgbeca()), 'LTBR',0,'L',1);
		if (($this->getDs_tipo() == 'CAMBIO')||($this->getDs_tipo() == 'CAMBIODEDHS')) {
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 80, 6, $this->encodeCharacters("Inicio Beca:"));
			$this->SetFont ( 'Arial', '', 10 );
			//$dt=(FuncionesComunes::fechaMysqlaPHP($dt_cargo)!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($dt_cargo):'';
			$this->Cell ( 20, 6, CYTSecureUtils::formatDateToView($this->getDt_beca()), 'LTBR',0,'L',1);
			//$this->Cell ( 40, 6, "");
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 65, 6, $this->encodeCharacters("Fin Beca:"));
			$this->SetFont ( 'Arial', '', 10 );
			//$dt=(FuncionesComunes::fechaMysqlaPHP($dt_beca)!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($dt_beca):'';
			$this->Cell ( 20, 6, CYTSecureUtils::formatDateToView($this->getDt_becaHasta()), 'LTBR',0,'L',1);
			
			
		}
		elseif ($this->getDs_tipo() == 'ALTA') {
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 80, 6, $this->encodeCharacters("Inicio Beca:"));
			$this->SetFont ( 'Arial', '', 10 );
			//$dt=(FuncionesComunes::fechaMysqlaPHP($dt_beca)!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($dt_beca):'';
			$this->Cell ( 20, 6, CYTSecureUtils::formatDateToView($this->getDt_beca()), 'LTBR',0,'L',1);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 65, 6, $this->encodeCharacters("Fin Beca:"));
			$this->SetFont ( 'Arial', '', 10 );
			//$dt=(FuncionesComunes::fechaMysqlaPHP($dt_beca)!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($dt_beca):'';
			$this->Cell ( 20, 6, CYTSecureUtils::formatDateToView($this->getDt_becaHasta()), 'LTBR',0,'L',1);
			
		}
		$this->ln(8);
		if (($this->getDs_tipo() == 'ALTA')||($this->getDs_tipo() == 'CAMBIO')){
			if ($this->getBl_becaEstimulo()) {
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 80, 6, $this->encodeCharacters("Beca de Estímulo a las Vocaciones Científicas:"));
				$this->SetFont ( 'Arial', '', 10 );
				
				$this->Cell ( 10, 6, 'SI', 'LTBR',0,'L',1);
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 25, 6, $this->encodeCharacters("Inicio Beca:"));
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 25, 6, CYTSecureUtils::formatDateToView($this->getDt_becaEstimulo()), 'LTBR',0,'L',1);
				
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 25, 6, $this->encodeCharacters("Fin Beca:"));
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 20, 6, CYTSecureUtils::formatDateToView($this->getDt_becaEstimuloHasta()), 'LTBR',0,'L',1);
				$this->ln(8);
			}
			
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 40, 6, "Lugar de trabajo:");
			$this->SetFont ( 'Arial', '', 10 );
			$this->MultiCell( 145, 4, $this->encodeCharacters($this->getDs_unidad()), 'LTBR','L');	
		}
		
		$this->ln(3);
		if (($this->getDs_tipo() == 'ALTA')||($this->getDs_tipo() == 'CAMBIO')||($this->getDs_tipo() == 'CAMBIODEDHS')){
			
			if ($this->getDs_tipo() != 'CAMBIODEDHS') {
				$this->SetFont ( 'Arial', 'B', 12 );
				$this->Cell ( 40, 6, "FECHA DE ALTA:");
				$this->SetFont ( 'Arial', '', 12 );
				$this->Cell ( 40, 6, CYTSecureUtils::formatDateToView($this->getDt_alta()), 'LTBR',0,'L',1);	
			}
			else{
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 40, 6, "FECHA DEL CAMBIO:");
				$this->SetFont ( 'Arial', '', 12 );
				$this->Cell ( 40, 6, CYTSecureUtils::formatDateToView($this->getDt_cambioHS()), 'LTBR',0,'L',1);	
			} 
			
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 24, 6, "Universidad:");
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell ( 81, 6, $this->encodeCharacters($this->getDs_universidad()), 'LTBR',0,'L',1);	
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			if ($this->getDs_tipo() != 'CAMBIODEDHS') {
				$this->Cell ( 52, 6, "Horas dedicadas al proyecto:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 10, 6, $this->getNu_horasinv(), 'LTBR',0,'L',1);	
			}
			else {
				$this->Cell ( 52, 6, "Hs. dedicadas actualmente:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 10, 6, $this->getNu_horasinvAnt(), 'LTBR',0,'L',1);	
			}
			$this->Cell ( 20, 6, "");
			$this->SetFont ( 'Arial', 'B', 10 );
			if ($this->getDs_tipo() != 'CAMBIODEDHS') {
				$this->Cell ( 40, 6, "Tipo de Investigador:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 63, 6, $this->encodeCharacters($this->getDs_tipoinvestigador()), 'LTBR',0,'L',1);	
			}
			else {
				$this->Cell ( 40, 6, "Hs. solicitadas:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 10, 6, $this->getNu_horasinv(), 'LTBR',0,'L',1);	
			}
			$this->ln(8);
			$this->SetFillColor(200,200,200);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 185, 6, "OTRO PROYECTO EN EL QUE PARTICIPA",0,0,'',1);
			$this->SetFillColor(255,255,255);
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 8 );
			$this->SetWidths(array(15, 75, 40, 20, 25, 10));
			$this->SetAligns(array('C', 'C','C','C','C','C'));
			$this->row(array($this->encodeCharacters('Código'),$this->encodeCharacters('Título'),'Director','Tipo',$this->encodeCharacters('Período'),'Hs. x Sem.'));
			$this->SetFont ( 'Arial', '', 8 );
			$this->SetAligns(array('L', 'L','L','L','L','C'));
			foreach ($this->getProyectos() as $oProyecto) {
				$oCriteria = new CdtSearchCriteria();
				$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
				$oCriteria->addFilter("$tDocente.cd_docente", $this->getDocente_oid(), '=');
				$oCriteria->addFilter("cd_proyecto", $oProyecto->getOid(), '=');
				$integranteManager = ManagerFactory::getIntegranteManager();
				$oIntegrante = $integranteManager->getEntity($oCriteria);
				$nu_horasinv = $oIntegrante->getNu_horasinv();
				$dt_baja = (($oIntegrante->getDt_baja())&&($oIntegrante->getDt_baja()!='0000-00-00'))?$oIntegrante->getDt_baja():$oProyecto->getDt_fin();
				$ds_tipo = $oIntegrante->getTipointegrante()->getDs_tipoinvestigador();
				$this->row(array($oProyecto->getDs_codigo(),$this->encodeCharacters($oProyecto->getDs_titulo()),$this->encodeCharacters($oProyecto->getDirector()->getDs_apellido()).', '.$this->encodeCharacters($oProyecto->getDirector()->getDs_nombre()),$ds_tipo,CYTSecureUtils::formatDateToView($oProyecto->getDt_ini()).' - '.CYTSecureUtils::formatDateToView($dt_baja),$nu_horasinv));
				
			}
			/*$count = count ( $proyectos );
			for($i = 0; $i < $count; $i ++) {
				if ($proyectos[$i]['ds_codigo']!=$ds_codigo){
					$this->row(array($proyectos[$i]['ds_codigo'],$proyectos[$i]['ds_titulo'],$proyectos[$i]['ds_director'],$proyectos[$i]['ds_tipoinvestigador'],FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).' - '.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']),$proyectos[$i]['nu_horasinv']));
				}
			}*/
			if ($this->getDs_tipo() == 'CAMBIODEDHS') {
				if ($this->getDs_reduccionHS()) {
					$this->SetFillColor(255,255,255);
					$this->ln(8);
					$this->SetFont ( 'Arial', 'B', 10 );
					$this->MultiCell( 185, 4, $this->encodeCharacters('En el caso de ser una reducción horaria, especificar las consecuencias que la misma tendrá¡ en el desarrollo del proyecto'), '','L');
					$this->ln(3);
					$this->SetFont ( 'Arial', '', 8 );
					$this->MultiCell( 185, 4, $this->encodeCharacters($this->getDs_reduccionHS()), 'LTBR','L');	
					$this->ln(3);
					$this->SetFont ( 'Arial', 'B', 10 );
					$this->MultiCell( 185, 4, $this->encodeCharacters('Considerando la reducción, el proyecto cumple con las pautas fijadas en la Acreditación: La suma de dedicaciones horarias de los miembros del proyecto es igual o mayor a ').$minhstotales.' hs. semanales', 'LTBR','L');	
					
				}
				
				
			}
		}
		else{
			//$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 12 );
			$this->Cell ( 40, 6, "FECHA DE BAJA:");
			$this->SetFont ( 'Arial', '', 12 );
			$this->Cell ( 40, 6, CYTSecureUtils::formatDateToView($this->getDt_baja()), 'LTBR',0,'L',1);	
			$this->SetFont ( 'Arial', 'B', 10 );
			/*$this->Cell ( 24, 6, "Universidad:");
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell ( 81, 6, stripslashes($ds_universidad), 'LTBR',0,'L',1);*/
			$this->ln(8);
			$this->SetFillColor(200,200,200);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 185, 6, "EN CASO DE OTORGARSE LA BAJA SOLICITADA",0,0,'',1);
			$this->SetFillColor(255,255,255);
			$this->ln(8);
			$this->MultiCell( 185, 4, $this->encodeCharacters('IMPORTANTE: con respecto a las solicitudes de bajas se debe tener en cuenta que, a los efectos del cobro de incentivos, el Ministerio no permite que los docentes investigadores cambien de proyecto. Cada docente investigador es asociado a un proyecto hasta su finalización y no puede solicitar incentivos por otro proyecto.'),'','L'); 
			$this->ln(2);
			$this->Cell ( 185, 6, $this->encodeCharacters("Explicar las consecuencias de la baja en el desenvolvimiento del proyecto"),0,0,'',1);
			$this->ln(8);
			$this->SetFont ( 'Arial', '', 8 );
			$this->MultiCell( 185, 4, $this->encodeCharacters($this->getDs_consecuencias()), 'LTBR','L');	
			$this->ln(3);
			if ($this->getDs_motivos()) {
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->SetFillColor(255,255,255);
				$this->Cell ( 185, 6, "Explicar los motivos de la baja",0,0,'',1);
				$this->ln(8);
				$this->SetFont ( 'Arial', '', 8 );
				$this->MultiCell( 185, 4, $this->encodeCharacters($this->getDs_motivos()), 'LTBR','L');	
				$this->ln(3);
			}
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 185, 6, "Considerando la baja, el proyecto cumple con los siguientes requisitos:",0,0,'',1);
			$this->ln(8);
			$this->SetFont ( 'Arial', '', 8 );
			$this->MultiCell( 185, 4, 'La suma de dedicaciones horarias de los miembros del proyecto es igual o mayor a 30 hs. semanales.', 'LTBR','L');	
			//$this->ln(3);
			$this->MultiCell( 185, 4, $this->encodeCharacters('Se cumple con las pautas fijadas en la Acreditación'), 'LTBR','L');	
			$this->ln(3);
		}	
		$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
	}
	
	
	
	function firma() {
		$this->SetFillColor(200,200,200);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, "CONSENTIMIENTO DEL INTERESADO",0,0,'',1);
		$this->SetFillColor(255,255,255);
		$this->ln(8);
		$ds_baja=($this->getDs_tipo()=='BAJA')?'a la presente baja':'';
		$this->Cell ( 185, 6, "Dejo constancia que otorgo mi conformidad ".$ds_baja,0,0,'',1);
		$this->SetFont ( 'Arial', '', 10 );
		$this->ln(10);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, 'Lugar y Fecha', '', 0, 'C');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, $this->encodeCharacters('Firma y Aclaración'), '', 0, 'C');
		$this->ln(1);
		$this->Cell ( 185, 8, '', 'B');
		$this->ln(10);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, 'Lugar y Fecha', '', 0, 'C');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, 'Firma del Director del Proyecto', '', 0, 'C');
		$this->ln(1);
		$this->Cell ( 185, 8, '', 'B');
		$this->ln(10);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, $this->encodeCharacters("La información detallada en esta solicitud tiene carácter de DECLARACION JURADA."),0,0,'',1);
		
	}
	/**
	 * (non-PHPdoc)
	 * @see CdtPDFPrint#Header()
	 */
	function Header(){
		
		$this->SetTextColor(100, 100, 100);
		$this->SetDrawColor(1,1,1);
		$this->SetLineWidth(.1);
		$this->SetFont('Arial','B',36);
		if (($this->getEstado_oid()==CYT_ESTADO_INTEGRANTE_ALTA_CREADA)||($this->getEstado_oid()==CYT_ESTADO_INTEGRANTE_BAJA_CREADA)||($this->getEstado_oid()==CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO)||($this->getEstado_oid()==CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO)) {
			$this->RotatedText($this->lMargin, $this->h - 10, $this->encodeCharacters('      '.CYT_MSG_SOLICITUD_PDF_PRELIMINAR_TEXT.'       '.CYT_MSG_SOLICITUD_PDF_PRELIMINAR_TEXT), 60);
		}
		
		$this->SetY(13);
		
		$this->SetTextColor(0, 0, 0);
		$this->ln(15);
			
		
		
		
		$this->Image(APP_PATH . 'css/images/image002.gif', $this->rMargin+10, $this->y-15);//, 60, 20);
	
	
		
		$this->SetFont ( 'Arial', 'B', 13 );
		
		
		$webtitulo='WEB GESTION DE PROYECTOS ';
		
		switch ($this->getEstado_oid()) {
			case CYT_ESTADO_INTEGRANTE_ALTA_CREADA:
				$ds_titulo='ALTA DE '.$this->getDs_tipointegrante().' - A';;
			break;
			case CYT_ESTADO_INTEGRANTE_ALTA_RECIBIDA:
				$ds_titulo='ALTA DE '.$this->getDs_tipointegrante().' - A';;
			break;
			case CYT_ESTADO_INTEGRANTE_BAJA_CREADA:
				$ds_titulo='BAJA DE '.$this->getDs_tipointegrante().' - B';
			break;
			case CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA:
				$ds_titulo='BAJA DE '.$this->getDs_tipointegrante().' - B';
			break;
			case CYT_ESTADO_INTEGRANTE_CAMBIO_CREADO:
				$ds_titulo='CAMBIO COLABORADOR - C';
			break;
			case CYT_ESTADO_INTEGRANTE_CAMBIO_RECIBIDO:
				$ds_titulo='CAMBIO COLABORADOR - C';
			break;
			case CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO:
				$ds_titulo='CAMBIO EN LA DED. HORARIA - D';
			break;
			case CYT_ESTADO_INTEGRANTE_CAMBIO_HS_RECIBIDO:
				$ds_titulo='CAMBIO EN LA DED. HORARIA - D';
			break;
		}
		
		
		
		$this->SetFillColor(0,0,0);
		$this->SetTextColor(255,255,255);
		$this->Cell ( 100, 6, $ds_titulo, '',0,'L',1);
		$this->Cell ( 85, 6, '0'.$this->getMes().'/'.$this->getYear().' '.CYT_MSG_PROYECTO_PDF_HEADER_TITLE, '',0,'R',1);
		
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(255,255,255);
		$this->ln(8);
	}
	
		
	

	/**
	 * (non-PHPdoc)
	 * @see CdtPDFPrint#Footer()
	 */
	function Footer(){
		
		$this->SetY(-15);
		
		
		$this->SetFont('Arial','I',8);

		$this->Cell(0,10,$this->encodeCharacters(CYT_MSG_PROYECTO_PDF_PAGINA).' '.$this->PageNo().' '.CYT_MSG_PROYECTO_PDF_PAGINA_DE.' {nb}',0,0,'C');
		
	}

	
	
	function initFontLabel(){
		$this->SetFillColor(218,218,218);
		$this->SetTextColor(0);
		$this->SetDrawColor(1,1,1);
		$this->SetLineWidth(.1);
		$this->SetFont('Arial','B',11);
	}
	
	function initFontValue(){
		$this->SetFillColor(245);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',10);
		
	}

	function addLineaLabelValue( $label, $value, $label_align="R", $value_align="L" ){

		$this->initFontLabel();
		   
	    $this->Cell(50,5, $label . ": ",1,0, $label_align);
	    
		$this->initFontValue();				
		$this->Cell(50,5, $value,1,0,$value_align);
	    $this->Ln();
	    
		//$this->LabelValue(50,10, $label, $value, $border=0, $align="R");
		
	}


	

	

	public function getYear()
	{
	    return $this->year;
	}

	public function setYear($year)
	{
	    $this->year = $year;
	}

	public function getEstado_oid()
	{
	    return $this->estado_oid;
	}

	public function setEstado_oid($estado_oid)
	{
	    $this->estado_oid = $estado_oid;
	}

	public function getMes()
	{
	    return $this->mes;
	}

	public function setMes($mes)
	{
	    $this->mes = $mes;
	}

	public function getTipo()
	{
	    return $this->tipo;
	}

	public function setTipo($tipo)
	{
	    $this->tipo = $tipo;
	}

	public function getDs_tipoinvestigador()
	{
	    return $this->ds_tipoinvestigador;
	}

	public function setDs_tipoinvestigador($ds_tipoinvestigador)
	{
	    $this->ds_tipoinvestigador = $ds_tipoinvestigador;
	}

	public function getMaxWidth()
	{
	    return $this->maxWidth;
	}

	public function setMaxWidth($maxWidth)
	{
	    $this->maxWidth = $maxWidth;
	}

	public function getDs_titulo()
	{
	    return $this->ds_titulo;
	}

	public function setDs_titulo($ds_titulo)
	{
	    $this->ds_titulo = $ds_titulo;
	}

	public function getDs_duracion()
	{
	    return $this->ds_duracion;
	}

	public function setDs_duracion($ds_duracion)
	{
	    $this->ds_duracion = $ds_duracion;
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

	public function getDs_facultad()
	{
	    return $this->ds_facultad;
	}

	public function setDs_facultad($ds_facultad)
	{
	    $this->ds_facultad = $ds_facultad;
	}

	public function getDs_director()
	{
	    return $this->ds_director;
	}

	public function setDs_director($ds_director)
	{
	    $this->ds_director = $ds_director;
	}

	public function getDs_tipo()
	{
	    return $this->ds_tipo;
	}

	public function setDs_tipo($ds_tipo)
	{
	    $this->ds_tipo = $ds_tipo;
	}

	public function getDs_investigador()
	{
	    return $this->ds_investigador;
	}

	public function setDs_investigador($ds_investigador)
	{
	    $this->ds_investigador = $ds_investigador;
	}

	public function getNu_cuil()
	{
	    return $this->nu_cuil;
	}

	public function setNu_cuil($nu_cuil)
	{
	    $this->nu_cuil = $nu_cuil;
	}

	public function getDs_categoria()
	{
	    return $this->ds_categoria;
	}

	public function setDs_categoria($ds_categoria)
	{
	    $this->ds_categoria = $ds_categoria;
	}

	public function getDs_titulogrado()
	{
	    return $this->ds_titulogrado;
	}

	public function setDs_titulogrado($ds_titulogrado)
	{
	    $this->ds_titulogrado = $ds_titulogrado;
	}

	public function getDs_tituloposgrado()
	{
	    return $this->ds_tituloposgrado;
	}

	public function setDs_tituloposgrado($ds_tituloposgrado)
	{
	    $this->ds_tituloposgrado = $ds_tituloposgrado;
	}

	public function getDs_cargo()
	{
	    return $this->ds_cargo;
	}

	public function setDs_cargo($ds_cargo)
	{
	    $this->ds_cargo = $ds_cargo;
	}

	public function getDs_deddoc()
	{
	    return $this->ds_deddoc;
	}

	public function setDs_deddoc($ds_deddoc)
	{
	    $this->ds_deddoc = $ds_deddoc;
	}

	public function getDs_universidad()
	{
	    return $this->ds_universidad;
	}

	public function setDs_universidad($ds_universidad)
	{
	    $this->ds_universidad = $ds_universidad;
	}

	public function getDs_carrinv()
	{
	    return $this->ds_carrinv;
	}

	public function setDs_carrinv($ds_carrinv)
	{
	    $this->ds_carrinv = $ds_carrinv;
	}

	public function getDs_organismo()
	{
	    return $this->ds_organismo;
	}

	public function setDs_organismo($ds_organismo)
	{
	    $this->ds_organismo = $ds_organismo;
	}

	public function getBl_becario()
	{
	    return $this->bl_becario;
	}

	public function setBl_becario($bl_becario)
	{
	    $this->bl_becario = $bl_becario;
	}

	public function getDs_tipobeca()
	{
	    return $this->ds_tipobeca;
	}

	public function setDs_tipobeca($ds_tipobeca)
	{
	    $this->ds_tipobeca = $ds_tipobeca;
	}

	public function getDs_orgbeca()
	{
	    return $this->ds_orgbeca;
	}

	public function setDs_orgbeca($ds_orgbeca)
	{
	    $this->ds_orgbeca = $ds_orgbeca;
	}

	public function getDs_unidad()
	{
	    return $this->ds_unidad;
	}

	public function setDs_unidad($ds_unidad)
	{
	    $this->ds_unidad = $ds_unidad;
	}

	public function getNu_horasinv()
	{
	    return $this->nu_horasinv;
	}

	public function setNu_horasinv($nu_horasinv)
	{
	    $this->nu_horasinv = $nu_horasinv;
	}

	public function getProyectos()
	{
	    return $this->proyectos;
	}

	public function setProyectos($proyectos)
	{
	    $this->proyectos = $proyectos;
	}

	public function getDt_baja()
	{
	    return $this->dt_baja;
	}

	public function setDt_baja($dt_baja)
	{
	    $this->dt_baja = $dt_baja;
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

	public function getDt_alta()
	{
	    return $this->dt_alta;
	}

	public function setDt_alta($dt_alta)
	{
	    $this->dt_alta = $dt_alta;
	}

	public function getDt_cargo()
	{
	    return $this->dt_cargo;
	}

	public function setDt_cargo($dt_cargo)
	{
	    $this->dt_cargo = $dt_cargo;
	}

	public function getDt_beca()
	{
	    return $this->dt_beca;
	}

	public function setDt_beca($dt_beca)
	{
	    $this->dt_beca = $dt_beca;
	}

	public function getNu_materias()
	{
	    return $this->nu_materias;
	}

	public function setNu_materias($nu_materias)
	{
	    $this->nu_materias = $nu_materias;
	}

	public function getNu_horasinvAnt()
	{
	    return $this->nu_horasinvAnt;
	}

	public function setNu_horasinvAnt($nu_horasinvAnt)
	{
	    $this->nu_horasinvAnt = $nu_horasinvAnt;
	}

	public function getDs_reduccionHS()
	{
	    return $this->ds_reduccionHS;
	}

	public function setDs_reduccionHS($ds_reduccionHS)
	{
	    $this->ds_reduccionHS = $ds_reduccionHS;
	}

	public function getMinhstotales()
	{
	    return $this->minhstotales;
	}

	public function setMinhstotales($minhstotales)
	{
	    $this->minhstotales = $minhstotales;
	}

	public function getDs_facultadintegrante()
	{
	    return $this->ds_facultadintegrante;
	}

	public function setDs_facultadintegrante($ds_facultadintegrante)
	{
	    $this->ds_facultadintegrante = $ds_facultadintegrante;
	}

	public function getDocente_oid()
	{
	    return $this->docente_oid;
	}

	public function setDocente_oid($docente_oid)
	{
	    $this->docente_oid = $docente_oid;
	}

	public function getDs_tipointegrante()
	{
	    return $this->ds_tipointegrante;
	}

	public function setDs_tipointegrante($ds_tipointegrante)
	{
	    $this->ds_tipointegrante = $ds_tipointegrante;
	}

	public function getDt_cambioHS()
	{
	    return $this->dt_cambioHS;
	}

	public function setDt_cambioHS($dt_cambioHS)
	{
	    $this->dt_cambioHS = $dt_cambioHS;
	}

	public function getDt_becaEstimulo()
	{
	    return $this->dt_becaEstimulo;
	}

	public function setDt_becaEstimulo($dt_becaEstimulo)
	{
	    $this->dt_becaEstimulo = $dt_becaEstimulo;
	}

	public function getBl_becaEstimulo()
	{
	    return $this->bl_becaEstimulo;
	}

	public function setBl_becaEstimulo($bl_becaEstimulo)
	{
	    $this->bl_becaEstimulo = $bl_becaEstimulo;
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
}