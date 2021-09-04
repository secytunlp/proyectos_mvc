<?php

/**
 * Factory para Integrante
 *  
 * @author Marcos
 * @since 30-10-2013
 */
class IntegranteFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('Integrante');
        $integrante = parent::build($next);
        //CYTSecureUtils::logObject($next);
    
       	if ($next["cyt_integrante_estado_dt_alta"]!='0000-00-00') {
       		$integrante->setDt_alta( $next["cyt_integrante_estado_dt_alta"] );
       	}
       	else $integrante->setDt_alta('');
       	//echo $next["cyt_integrante_estado_dt_baja"]."<br>";
       	if ($next["cyt_integrante_estado_dt_baja"]!='0000-00-00') {
       		$integrante->setDt_baja( $next["cyt_integrante_estado_dt_baja"] );
       	}
       	else $integrante->setDt_baja('');
       	
       
        
        $factory = new ProyectoFactory();
        $factory->setAlias( CYT_TABLE_PROYECTO . "_" );
        $integrante->setProyecto( $factory->build($next) );
        
        $factory = new DocenteFactory();
        $factory->setAlias( CYT_TABLE_DOCENTE . "_" );
        $integrante->setDocente( $factory->build($next) );
        
        $factory = new TipoIntegranteFactory();
        $factory->setAlias( CYT_TABLE_TIPO_INTEGRANTE . "_" );
        $integrante->setTipoIntegrante( $factory->build($next) );
        
        $factory = new EstadoFactory();
        $factory->setAlias( CYT_TABLE_ESTADOINTEGRANTE . "_" );
        $integrante->setEstado( $factory->build($next) );
        
       
        
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
        
        $factory = new UniversidadFactory();
        $factory->setAlias( CYT_TABLE_UNIVERSIDAD . "_" );
        $integrante->setUniversidad( $factory->build($next) );
        
        $factory = new LugarTrabajoFactory();
        $factory->setAlias( "LugarTrabajo_" );
        $integrante->setUnidad( $factory->build($next) );
        
        $factory = new TituloFactory();
        $factory->setAlias( CYT_TABLE_TITULO . "_" );
        $integrante->setTitulo( $factory->build($next) );
        
        $factory = new TituloFactory();
        $factory->setAlias( "Tituloposgrado_" );
        $integrante->setTitulopost( $factory->build($next) );
        
    	

        return $integrante;
    }

}
?>
