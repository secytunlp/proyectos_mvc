<?php

/**
 * Factory para IntegranteEstado
 *  
 * @author Marcos
 * @since 03-11-2016
 */
class IntegranteEstadoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('IntegranteEstado');
        $integrante = parent::build($next);
        
        $factory = new IntegranteFactory();
        $factory->setAlias( CYT_TABLE_INTEGRANTE . "_" );
        $integrante->setIntegrante( $factory->build($next) );
        
        $factory = new TipoIntegranteFactory();
        $factory->setAlias( CYT_TABLE_TIPO_INTEGRANTE . "_" );
        $integrante->setTipoIntegrante( $factory->build($next) );
        
        $factory = new EstadoFactory();
        $factory->setAlias( CYT_TABLE_ESTADOINTEGRANTE . "_" );
        $integrante->setEstado( $factory->build($next) );
        
      	$factory = new DocenteFactory();
        $factory->setAlias( CYT_TABLE_DOCENTE . "_" );
        $integrante->setDocente( $factory->build($next) );
        
        $factory = new CategoriaFactory();
        $factory->setAlias( CYT_TABLE_CATEGORIA . "_" );
        $integrante->setCategoria( $factory->build($next) );
        
    	if ($next["cd_carrerainv"]!=11) {
        	$factory = new CarrerainvFactory();
        	$factory->setAlias( CYT_TABLE_CARRERAINV . "_" );
        	$integrante->setCarrerainv( $factory->build($next) );
        }
        
        if ($next["cd_carrerainv"]!=11) {
	        $factory = new OrganismoFactory();
	        $factory->setAlias( CYT_TABLE_ORGANISMO . "_" );
	        $integrante->setOrganismo( $factory->build($next) );
        }
        
        $factory = new CargoFactory();
        $factory->setAlias( CYT_TABLE_CARGO . "_" );
        $integrante->setCargo( $factory->build($next) );
        
        $factory = new DeddocFactory();
        $factory->setAlias( CYT_TABLE_DEDDOC . "_" );
        $integrante->setDeddoc( $factory->build($next) );
        
        $factory = new FacultadFactory();
        $factory->setAlias( CYT_TABLE_FACULTAD . "_" );
        $integrante->setFacultad( $factory->build($next) );
        
        $factory = new ProyectoFactory();
        $factory->setAlias( CYT_TABLE_PROYECTO . "_" );
        $integrante->setProyecto( $factory->build($next) );
        
    	if(array_key_exists('ds_username',$next)){
			
			$factory = new CdtUserFactory();
        	//$factory->setAlias( CYT_TABLE_CDT_USER . "_" );
        	$integrante->setUser( $factory->build($next) );
        	
		}

        return $integrante;
    }

}
?>
