


function integrante_filter_unidad_change(attr){
	
}

function integrante_filter_lugarTrabajo_change(attr){
	
}

function lugarTrabajo_filter_lugarTrabajo_change(attr){
	
}

function integrante_filter_universidad_change(attr){
	
}

function integrante_filter_titulo_change(attr){
	var valor = $("#autocomplete_integrante_filter_titulo_oid").val();

	if (valor){

		$('#item-div-ds_carrera').hide();
		$('#item-div-nu_totalMat').hide();
		$('#item-div-nu_materias').hide();
	}
	else{

		$('#item-div-ds_carrera').show();
		$('#item-div-nu_totalMat').show();
		$('#item-div-nu_materias').show();
	}
	
}

function integrante_filter_titulopost_change(attr){
	
}

function autocomplete_callback_ds_apellido( oid ){
	
	$("#autocomplete_spands_apellido").append("<span id='iconoLoading' style='position:absolute;'><img src='css/grid/loading.gif' /></span>")
	$("#hiddenApellido").val( oid );
	
	jQuery.ajax({
	      url:"doAction?action=add_integrante_docente&cd_docente=" + $("#hiddenApellido").val(),
	      dataType:"json",
	      success: function(data){
	      	
	      	if( data != null && data["error"]!=null){
	      		showMessageError( data["error"], true );
	      		//inhabilitar el submit.
	      		$("#edit_integrante_input_submit_ajax").hide();
	      	}
	      	
	      	else{
	      		$("#edit_integrante_input_submit_ajax").show();
	      		//ocultamos los div.
	      		$("#ds_orgbeca").val(data["ds_orgbeca"]);	
	      		$("#ds_orgbeca").change();
	      		$("#ds_nombre").val(data["nombre"]);
	      		$("#ds_apellido").val(data["apellido"]);
	      		$("#cuil").val(data["cuil"]);	
	      		$("#ds_mail").val(data["mail"]);	
	      		$("#categoria_oid").val(data["categoria_oid"]);		
	      		$("#carrerainv_oid").val(data["carrerainv_oid"]);		
	      		$("#organismo_oid").val(data["organismo_oid"]);		
	      		$("#cargo_oid").val(data["cargo_oid"]);	
	      		$("#dt_cargo").val(data["dt_cargo"]);	
	      		$("#deddoc_oid").val(data["deddoc_oid"]);		
	      		$("#facultad_oid").val(data["facultad_oid"]);		
	      		$("#integrante_filter_lugarTrabajo_oid").val(data["lugarTrabajo_oid"]);	
	      		$("#integrante_filter_lugarTrabajo_oid").blur();
	      		$("#integrante_filter_universidad_oid").val(data["universidad_oid"]);	
	      		$("#integrante_filter_universidad_oid").blur();
	      		$("#integrante_filter_titulo_oid").val(data["titulo_oid"]);	
	      		$("#integrante_filter_titulo_oid").blur();
	      		$("#integrante_filter_titulopost_oid").val(data["titulopost_oid"]);	
	      		$("#integrante_filter_titulopost_oid").blur();
	      		
	      		$("#ds_tipobeca").val(data["ds_tipobeca"]);
	      		$("#dt_beca").val(data["dt_beca"]);
	      		$("#dt_becaHasta").val(data["dt_becaHasta"]);
	      		$("#dt_becaEstimulo").val(data["dt_becaEstimulo"]);
	      		$("#dt_becaEstimuloHasta").val(data["dt_becaEstimuloHasta"]);
	      		var categoria = document.getElementById("categoria.oid");
	      		categoria.value = data["categoria_oid"];
	      		
	      	} 	
	      	 $("#iconoLoading").remove();
	      }
	});
}






