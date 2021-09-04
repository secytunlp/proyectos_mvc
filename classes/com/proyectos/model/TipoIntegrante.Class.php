<?php

/**
 * Tipo de Integrantes 
 *  
 * @author Marcos
 * @since 02-11-2016
 */


class TipoIntegrante  extends Entity{

    //variables de instancia.

	private $cd_tipoinvestigador;
	
    private $ds_tipoinvestigador;
    
   
    
    
	
    public function __construct(){
    	
    	$this->ds_tipoinvestigador = "";
    	
    	
    }
    
    
    

		public function getDs_tipoinvestigador()
		{
		    return $this->ds_tipoinvestigador;
		}

		public function setDs_tipoinvestigador($ds_tipoinvestigador)
		{
		    $this->ds_tipoinvestigador = $ds_tipoinvestigador;
		}

	public function getCd_tipoinvestigador()
	{
	    return $this->cd_tipoinvestigador;
	}

	public function setCd_tipoinvestigador($cd_tipoinvestigador)
	{
	    $this->cd_tipoinvestigador = $cd_tipoinvestigador;
	}
}
?>