<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Productos </h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Inicio</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>productos">Productos</a>
            </li>
           
            <li class="active">
                <strong>Editar Producto</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Editar Producto <small></small></h5>
				</div>
				<div class="ibox-content">
					<form id="form_productos" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Nombre *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="nombre" id="nombre" maxlength="150" value="<?php echo $editar[0]->nombre ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Referencia *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="referencia" id="referencia" maxlength="150" value="<?php echo $editar[0]->referencia ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Precio en Dólares *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="costo_dolar" id="costo_dolar" maxlength="11" value="<?php echo $editar[0]->costo_dolar ?>">
								<label id="label_precio_dolar" style="color:red;"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Precio en Bolívares *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="costo_bolivar" id="costo_bolivar" maxlength="11" value="<?php echo $editar[0]->costo_bolivar ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Unidades de medida *</label>
							<div class="col-sm-6">
								<select class="form-control m-b" name="unidad_medida" id="unidad_medida">
									<option value="0" selected="">Seleccione</option>
									<?php foreach ($listar_unidades as $unidad) { ?>
										<option value="<?php echo $unidad->id ?>"><?php echo $unidad->name." - ".$unidad->symbol; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Tienda *</label>
							<div class="col-sm-6">
								<select class="form-control m-b" name="tienda_id" id="tienda_id">
									<option value="0" selected="">Seleccione</option>
									<?php foreach ($listar_tiendas as $tienda) { ?>
										<option value="<?php echo $tienda->id ?>"><?php echo $tienda->nombre; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Se compra:</label>
							<div class="col-sm-1">
								<input type="checkbox" class="form-control" name="c_compra" id="c_compra" <?php if($editar[0]->c_compra == 1){ echo "checked='checked'"; }?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Se vende:</label>
							<div class="col-sm-1">
								<input type="checkbox" class="form-control" name="c_vende" id="c_vende" <?php if($editar[0]->c_vende == 1){ echo "checked='checked'"; }?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Se fabrica:</label>
							<div class="col-sm-1">
								<input type="checkbox" class="form-control" name="c_fabrica" id="c_fabrica" <?php if($editar[0]->c_fabrica == 1){ echo "checked='checked'"; }?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Modificado *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="modificado" id="modificado" readonly="true" value="<?php echo $editar[0]->modificado ?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								 <input class="form-control"  type='hidden' id="id" name="id" value="<?php echo $id ?>"/>
								 <input id="id_unidad_medida" type="hidden" value="<?php echo $editar[0]->unidad_medida ?>"/>
								 <input id="id_tienda" type="hidden" value="<?php echo $editar[0]->tienda_id ?>"/>
								<button class="btn btn-white" id="volver" type="button">Volver</button>
								<button class="btn btn-primary" id="edit" type="submit">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    $('input').on({
        keypress: function () {
            $(this).parent('div').removeClass('has-error');
        }
    });

    $('#volver').click(function () {
        url = '<?php echo base_url() ?>productos/';
        window.location = url;
    });
    
    // Auto-selección de combos con las opciones correspondientes
    $("#unidad_medida").select2('val', $("#id_unidad_medida").val());
    $("#tienda_id").select2('val', $("#id_tienda").val());
	
	$("#costo_dolar,#costo_bolivar").numeric(); //Valida solo permite valores numéricos
	
    // Indicamos el precio actual del dólar en la etiqueta informativa debajo del campo de Precio en Dólares
    $.get('https://s3.amazonaws.com/dolartoday/data.json', function (response) {  // Se produce un error si usamos $.post en vez de $.get
		//~ alert(response['USD']['transferencia']);
		var precio_dolar = response['USD']['transferencia'];
		$("#label_precio_dolar").text("**Precio actual del dólar("+precio_dolar+")");
	}, 'json');
	
	// Convertimos el valor en dólares a bolívares
	$("#costo_dolar").change(function (e) {
		e.preventDefault();  // Para evitar que se envíe por defecto
		
		$.get('https://s3.amazonaws.com/dolartoday/data.json', function (response) {  // Se produce un error si usamos $.post en vez de $.get
			//~ alert(response['USD']['transferencia']);
			var dolar_bolivar = parseFloat($("#costo_dolar").val()) * response['USD']['transferencia'];
			$("#costo_bolivar").val(dolar_bolivar.toFixed(2));
		}, 'json');
	});

    $("#edit").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#nombre').val().trim() === "") {
			swal("Disculpe,", "para continuar debe ingresar nombre");
			$('#nombre').parent('div').addClass('has-error');
			
        } else if ($('#referencia').val().trim() === "") {
			swal("Disculpe,", "para continuar debe ingresar la referencia");
			$('#referencia').parent('div').addClass('has-error');
			
        } else if ($('#costo_dolar').val().trim() === "") {
			swal("Disculpe,", "para continuar debe ingresar el costo en dólares");
			$('#costo_dolar').parent('div').addClass('has-error');
			
        } else if ($('#costo_bolivar').val().trim() === "") {
			swal("Disculpe,", "para continuar debe ingresar el costo en bolívares");
			$('#costo_bolivar').parent('div').addClass('has-error');
			
        } else if ($('#unidad_medida').val().trim() == "0") {
			swal("Disculpe,", "para continuar debe seleccionar la unidad de medida");
			$('#unidad_medida').parent('div').addClass('has-error');
			$('#unidad_medida').focus();
			
        } else if ($('#tienda_id').val().trim() == "0") {
			swal("Disculpe,", "para continuar debe seleccionar la tienda");
			$('#tienda_id').parent('div').addClass('has-error');
			
        } else {

            //~ $.post('<?php echo base_url(); ?>CProductos/update', $('#form_productos').serialize(), function (response) {
				//~ if (response[0] == '1') {
                    //~ swal("Disculpe,", "este nombre se encuentra registrado");
                //~ }else{
					//~ swal({ 
						//~ title: "Actualizar",
						 //~ text: "Guardado con exito",
						  //~ type: "success" 
						//~ },
					//~ function(){
					  //~ window.location.href = '<?php echo base_url(); ?>productos';
					//~ });
				//~ }
            //~ });
            
            // Formateamos los precios para usar coma en vez de punto
            //~ $("#costo_dolar").val(String($("#costo_dolar").val()).replace('.',','));
            //~ $("#costo_bolivar").val(String($("#costo_bolivar").val()).replace('.',','));
            //~ 
            //~ alert($("#costo_dolar").val());
            //~ alert($("#costo_bolivar").val());
            
            var formData = new FormData(document.getElementById("form_productos"));  // Forma de capturar todos los datos del formulario
			
			$.ajax({
				//~ method: "POST",
				type: "post",
				dataType: "html",
				url: '<?php echo base_url(); ?>CProductos/update',
				data: formData,
				cache: false,
				contentType: false,
				processData: false
			})
			.done(function(data) {
				if(data.error){
					console.log(data.error);
				} else {
					if (data[0] == '1') {
						swal("Disculpe,", "este producto se encuentra registrado");
					}else{
						swal({ 
							title: "Registro",
							 text: "Actualizado con exito",
							  type: "success" 
							},
						function(){
						  window.location.href = '<?php echo base_url(); ?>productos';
						});
					}
				}				
			}).fail(function() {
				console.log("error ajax");
			});
        }
    });
});

</script>