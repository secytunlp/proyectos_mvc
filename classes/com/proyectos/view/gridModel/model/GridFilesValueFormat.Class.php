<?php

/**
 * Formato para renderizar los archivos en las grillas
 *
 * @author Marcos
 * @since 17-11-2016
 *
 */
class GridFilesValueFormat extends GridValueFormat {

	public function __construct() {

		parent::__construct();
	}

	public function format($value, $item=null) {

		$oManagerIntegrante = ManagerFactory::getIntegranteManager();
		$oIntegrante = $oManagerIntegrante->getObjectByCode($value);
		$adjuntos = '';
		
		
		
		
		$dir = APP_PATH.CYT_PATH_PDFS.'/'.CYT_YEAR.'/'.CYT_PERIODO.'/'.$oIntegrante->getProyecto()->getOid().'/'.$oIntegrante->getDocente()->getNu_documento().'/';
		$dirREL = WEB_PATH.CYT_PATH_PDFS.'/'.CYT_YEAR.'/'.CYT_PERIODO.'/'.$oIntegrante->getProyecto()->getOid().'/'.$oIntegrante->getDocente()->getNu_documento().'/';
		
		if (file_exists($dir)){
				
		      
		     $handle=opendir($dir);
				while ($archivo = readdir($handle))
				{
			        if ((is_file($dir.$archivo))&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIO_'))&&(!strchr($archivo,'CAMBIODEDHS_')))
			         {
			         	$adjuntos .='<a href="'.$dirREL.$archivo.'" target="_blank"><img class="hrefImg" src="'.WEB_PATH.'css/images/file.jpg" title="'.$archivo.'" /></a>';
			         	
			         	}
						
				}
				closedir($handle);
			}
		
		
		
		 
		return $adjuntos ;
	}

}