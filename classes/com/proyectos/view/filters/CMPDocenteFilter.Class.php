<?php

/**
 * componente filter para docentes.
 *
 * @author Marcos
 * @since 06-09-2021
 *
 */
class CMPDocenteFilter extends CMPFilter{



	/**
	 * apellido
	 * @var string
	 */
	private $apellido;

	/**
	 * cuil
	 * @var string
	 */
	private $cuil;



	public function __construct( $id="filter_docentes"){



		parent::__construct($id);

		$this->setOrderBy('ds_apellido, ds_nombre');
		$this->setOrderType('ASC');
		$this->setComponent("CMPDocenteGrid");




		$fieldDocente = FieldBuilder::buildFieldText ( CYT_LBL_DOCENTE, "apellido"  );
		$this->addField( $fieldDocente);

		$fieldDocente = FieldBuilder::buildFieldText ( CYT_LBL_INTEGRANTE_CUIL, "cuil"  );
		$this->addField( $fieldDocente);

		$this->fillForm();

	}


	/**
	 * (non-PHPdoc)
	 * @see components/CMPComponent::show()
	 */
	public function show( ){

		//rellenamos los valores del formulario.
		$this->fillForm();

		//mostramos el formulario.
		return $this->getForm()->show();
	}


	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);


		$apellido = $this->getApellido();
		$cuil = $this->getCuil();
		/*$oUser = CdtSecureUtils::getUserLogged();*/
		if(!empty($apellido)){

            $filter = new CdtSimpleExpression("ds_apellido like '%".$apellido."%' OR ds_nombre like '%".$apellido."%'");
            $criteria->setExpresion($filter);

		}
        if(!empty($cuil)){


            $filter = new CdtSimpleExpression("CONCAT(nu_precuil,'-',nu_documento,'-',nu_postcuil) like '%".$cuil."%'");
            $criteria->setExpresion($filter);
        }






	}



	public function getApellido()
	{
	    return $this->apellido;
	}

	public function setApellido($apellido)
	{
	    $this->apellido = $apellido;
	}





	public function getCuil()
	{
	    return $this->cuil;
	}

	public function setCuil($cuil)
	{
	    $this->cuil = $cuil;
	}
}
