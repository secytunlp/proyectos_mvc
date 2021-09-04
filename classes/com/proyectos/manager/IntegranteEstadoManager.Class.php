<?php

/**
 * Manager para Integrante Estado
 *  
 * @author Marcos
 * @since 14-11-2016
 */
class IntegranteEstadoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getIntegranteEstadoDAO();
	}

	public function add(Entity $entity) {
    	
		parent::add($entity);
		
    }	
    
     public function update(Entity $entity) {
     	
     	
		parent::update($entity);
     }

    
    
    
	/**
     * se elimina la entity
     * @param int identificador de la entity a eliminar.
     */
    public function delete($id) {
        
		parent::delete( $id );
		
    	
    }
	
	
	
	
}
?>
