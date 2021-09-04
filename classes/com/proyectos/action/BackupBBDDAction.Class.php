<?php
/**
 * Acci�n para hacer backup de la base.
 *  
 * @author marcos
 * @since 24-10-2012
 * 
 */
class BackupBBDDAction extends CdtOutputAction{



protected function getOutputContent(){
	
	$serv=DB_HOST; //nombre del servidor
	$bd=DB_NAME;  //nombre de la base de datos
	$usr=DB_USER; //usuario para conectarse a la base de datos
	$pwd=DB_PASSWORD; //password del usuario
	//hay que poner la ruta exacta en la que se encuentra el archivo mysqldump 
	//en mi caso es asi, primero va entre comillas simples y despu�s se ponen comillas dobles.
	$mysqldump='"D:/xampp/mysql/bin/mysqldump.exe"';
	//el nombre del backup llevara la fecha y hora del servidor:

	$fechaHora = date("Y-m-d-H-i-s");
	$name_back='"D:/Documents/Mis Webs/proyectos_mvc/backup/"'.$bd .'_'. $fechaHora . '.sql';
	
	system("$mysqldump $bd -h$serv -u$usr -p$pwd > $name_back", $resultado);
	
	$name_back='D:/Documents/Mis Webs/proyectos_mvc/backup/'.$bd .'_'. $fechaHora . '.sql';
	$name_back_destino='D:/Documents/Mis Webs/proyectos_mvc/backup/'.$bd .'_'. $fechaHora . '.gz';
	
	CYTSecureUtils::compact($name_back, $name_back_destino);
	
	unlink($name_back);
	
	$subjectMail = 'BackUp viajes';
	
	$bodyMail = "En el archivo adjunto se encuentra el BackUp de la BBDD viajes realizado el ".date('d/m/Y H:i:s');
	
	CYTSecureUtils::sendMail(CDT_POP_MAIL_FROM_NAME, CDT_POP_MAIL_FROM, $subjectMail, $bodyMail, $name_back_destino);
	unlink($name_back_destino);
	
}

	protected function getOutputTitle(){
		return MP3_MSG_ALBUM_TITLE_VIEW;
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtOutputAction::getXTemplate();
	 */
	public function getXTemplate(){ 
		return new XTemplate ( MP3_TEMPLATE_ALBUM_VIEW );
	}
	

	



}
?>