<?php

/**
 * Factory para TipoIntegrante
 *  
 * @author Marcos
 * @since 30-10-2013
 */
class TipoIntegranteFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('TipoIntegrante');
        $tipoIntegrante = parent::build($next);
   		if(array_key_exists('cd_tipoinvestigador',$next)){
        	$tipoIntegrante->setOid( $next["cd_tipoinvestigador"] );
        }
        
        

        return $tipoIntegrante;
    }

}
?>
