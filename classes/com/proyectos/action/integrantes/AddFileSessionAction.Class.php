<?php 

/**
 * Acción para dar de alta un archivo de solicitud.
 * El alta es sólo en sesión para ir armando la solicitud.
 * 
 * @author Marcos
 * @since 09-01-2014
 * 
 */
class AddFileSessionAction extends CdtAction{

	
	public function getVariableSessionName(){
		return "archivos";
	}
	
	public function execute(){
		
		if(isset($_SESSION[$this->getVariableSessionName()]))
			$archivos = unserialize( $_SESSION[$this->getVariableSessionName()] );
		else 
			$archivos = array();
		/*print_r($_REQUEST);	
		print_r($_FILES);	*/
		$proyecto = $_REQUEST['proyecto'];
		$apellido = $_REQUEST['apellido'];
		$cuil = $_REQUEST['cuil'];
		$separarCUIL = explode('-',trim($cuil));
		if ($separarCUIL[1]) {
			foreach ($_FILES as $key => $value) {
				if ($value["size"]<=CYT_FILE_MAX_SIZE) {
					switch ($key) {
	            		case 'ds_curriculum':
	            		$nombre = CYT_LBL_INTEGRANTE_CURRICULUM;
	            		$sigla = CYT_LBL_INTEGRANTE_CURRICULUM_SIGLA;
	            		break;
	            		case 'ds_actividades':
	            		$nombre = CYT_LBL_INTEGRANTE_PLAN;
	            		$sigla = CYT_LBL_INTEGRANTE_PLAN_SIGLA;
	            		break;
	            		case 'ds_resolucionBeca':
	            		$nombre = CYT_LBL_INTEGRANTE_RESOLUCION_BECA;
	            		$sigla = CYT_LBL_INTEGRANTE_RESOLUCION_BECA_SIGLA;
	            		break;
	            		            	}
					$explode_name = explode('.', $value['name']);
		            //Se valida así y no con el mime type porque este no funciona par algunos programas
		            $pos_ext = count($explode_name) - 1;
		            if (in_array(strtolower($explode_name[$pos_ext]), explode(",",CYT_EXTENSIONES_PERMITIDAS))) {
		            	//CdtUtils::log("FILE: "   . $key.' - '.$value['name']);
		            	$dir = CYT_PATH_PDFS.'/';
						if (!file_exists($dir)) mkdir($dir, 0777); 
						$dir .= CYT_YEAR.'/';
						if (!file_exists($dir)) mkdir($dir, 0777); 
						$dir .= CYT_PERIODO.'/';
						if (!file_exists($dir)) mkdir($dir, 0777); 
						$dir .= $proyecto.'/';
						if (!file_exists($dir)) mkdir($dir, 0777); 
						
						$dir .= $separarCUIL[1].'/';
						if (!file_exists($dir)) mkdir($dir, 0777);
									
						$ds_apellido = CYTSecureUtils::stripAccents(stripslashes(str_replace("'","_",$apellido)));			
						$nuevo='TMP_'.$sigla.'_'.$ds_apellido.'_'.$separarCUIL[1].'_P'.CYT_PERIODO.CYT_YEAR.".".$explode_name[$pos_ext];
						
			     		$handle=opendir($dir);
						while ($archivo = readdir($handle))
						{
					        if ((is_file($dir.$archivo))&&((strchr($archivo,'TMP_'.$sigla.'_'))||(strchr($archivo,$sigla.'_'))))
					         {
					         	unlink($dir.$archivo);
							}
						}
						closedir($handle);
				
						
				        if (!move_uploaded_file($value['tmp_name'], $dir.$nuevo)){
							$error .='<span style="color:#FF0000; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_ERROR.$nombre.'</span>';
				        }
				        else{
				        	$error = '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$value["name"]."(".$value["size"].")".'</span>';
				        }
						
		            }
		            else {
		            	
		            	$error .='<span style="color:#FF0000; font-weight:bold">'.CYT_MSG_FORMATO_INVALIDO.$nombre.'</span>';
		            }
				CdtUtils::log("FILE: "   . $key.' => '.$value);
				$value['nuevo']=$nuevo;
				$archivos[$key]=$value;
				if ($error) {
					echo $error;
				}
			}
			else {
		            	
	            	$error .='<span style="color:#FF0000; font-weight:bold">'.$value['name'].CYT_MSG_FILE_MAX_SIZE.'</span>';
	            	echo $error;
	        }
		}        
		$_SESSION[$this->getVariableSessionName()] = serialize($archivos);
		//vamos a retornar por json los presupuestos de la solicitud.
		
		//usamos el renderer para reutilizar lo que mostramos de los presupuestos.
	}
	else{
		$error .='<span style="color:#FF0000; font-weight:bold">'.CYT_MSG_INTEGRANTE_CUIL_FORMAT.'</span>';
	    echo $error;
	}
		
		

	}


	
}