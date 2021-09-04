<?php

/**
 * Factory para Proyecto
 *  
 * @author Marcos
 * @since 12-11-2013
 */
class ProyectoDirectorFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('ProyectoDirector');
        $proyecto = parent::build($next);
        if(array_key_exists('cd_proyecto',$next)){
        	$proyecto->setOid( $next["cd_proyecto"] );
        }
        
        $factory = new DocenteFactory();
        $factory->setAlias( CYT_TABLE_DOCENTE . "_" );
        $proyecto->setDirector( $factory->build($next) );
        
        
        $factory = new FacultadFactory();
        $factory->setAlias( CYT_TABLE_FACULTAD . "_" );
        $proyecto->setFacultad( $factory->build($next) );
        
        $factory = new EstadoFactory();
        $factory->setAlias( CYT_TABLE_ESTADOPROYECTO . "_" );
        $proyecto->setEstado( $factory->build($next) );
        

        return $proyecto;
    }

}
?>
