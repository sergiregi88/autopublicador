  <!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>

    <?php echo $this->load->view('includes2/header');

	?>
	    <div class="content">
              <div class="container">
        
	<div  id='crearbbdd' class="clearfix">
        <div class="col-sm-8 col-sm-offset-2">
	      <form action="<?php echo base_url(); ?>panel/basesdedatos/crear" method="post" id="addbbdd" > 
	        
	         
				<div id="message">

					
				</div>
	
	        		<div class="form-group col-sm-9">
	            		<label class="col-sm-4 control-label">Nombre</label>
	            		<div class="col-sm-8">
	            			<input type='text' class="form-control col-sm-7"  placeholder="Nombre" name='basededatos_create_name'>
	            		</div>
	        		</div>
	     		<div class="form-group col-sm-9">
	            		<label class="col-sm-4 control-label">Contenido:</label>
	            		<div class="col-sm-8">
	            			<select class="form-control" name="content">
	            				<option value="">Selecciona una opción</option>
	            				<option value="link">Enlaces</option>
	            				<option value='image'>Imágenes</option>
	            				<option value="sentence">Texto</option>
	            			</select>
	      			</div>
	      		</div>
	      		<div class="form-group col-md-9">
	            		<label class="control-label col-sm-4">Red social:</label>
	           		<div class="col-sm-8">
	             			<select class="form-control" name="basededatos_create_social">
	            				<option value="">Selecciona una opción</option>
	            				<option value="face">Facebook</option>
	            				<option value='twt'>Twitter</option>
	            				
	            			</select></div>
	           	</div>
	      			<div class="form-group col-md-9">
	      				<div class="col-sm-9 col-sm-offset-4">
	             				<input id="addbbdd-btn" type="submit"  class="btn btn-primary" name='addnew' value='Crear'>
	             				<input type='button' class="btn" id='cancel_crear_bbdd' value='Cancelar'>
	             			</div>
	     		     </div>      
				</div>
		     </div>
	     </form>
</div>
</div>
  <?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>