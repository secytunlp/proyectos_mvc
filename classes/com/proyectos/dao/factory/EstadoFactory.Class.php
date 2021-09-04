<?php

/**
 * Factory para Estado
 *  
 * @author Marcos
 * @since 21-10-2013
 */
class EstadoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('Estado');
        $tipoEstado = parent::build($next);
    	if(array_key_exists('cd_estado',$next)){
        	$tipoEstado->setOid( $next["cd_estado"] );
        }

        return $tipoEstado;
    }

}
?>
