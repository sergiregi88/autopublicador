<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
<?php $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
$arr=array("group","user","event","page")
?>
    <?php echo $this->load->view('includes2/header');

	?>
       
			<form id="programar" action="<?php echo current_url(); ?>" method="POST">
			<div class="message"></div>
				<section class="col-lg-6">
					<div class="form-group ">
						<label class="col-lg-12" for="">Fecha y Hora</label>
						<div class="col-lg-6">
							<div class="input-group">
							<input class='form-control date'  name='date' type="date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="input-group">
							<input class='form-control time' value="<?php echo date('H:i'); ?>" name='time' type="time">
							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<label class="col-lg-12" for="">Frecuencia de borrado(opcional)</label>
						<div class="col-lg-12">
							<select class='form-control' name="fechaBorrado">
	               				<option value="">Seleccione borrado</option>
               	                    <option value="0.02">2 minutos</option>
								<option value="0.1">10 minutos</option>
								<option value="0.15">15 minutos</option>
								<option value="0.30">30 minutos</option>
								<option value="1">1 hora</option>
								<option value="2">2 horas</option>
								<option value="3">3 horas</option>
								<option value="4">4 horas</option>
								<option value="5">5 horas</option>
								<option value="6">6 horas</option>
								<option value="8">8 horas</option>
								<option value="10">10 horas</option>
								<option value="12">12 horas</option>
								<option value="14">14 horas</option>
								<option value="16">16 horas</option>
								<option value="18">18 horas</option>
								<option value="20">20 horas</option>
								<option value="22">22 horas</option>
								<option value="24">24 horas</option>
								<option value="30">30 horas</option>
								<option value="36">36 horas</option>
								<option value="40">40 horas</option>
								<option value="44">44 horas</option>
								<option value="48">48 horas</option>

							</select>
								
						</div>
						
					</div>
					

					<div class="form-group ">
						<label class="col-lg-12"for="">Texto a programar</label>
						<div class="col-lg-12">
							<textarea name="texto_facebook" class='form-control' ></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class=" col-lg-12 control-label">Imagen(jpg,png,gif):</label>
						<div class="col-lg-12">
				            <input class='filestyle' data-buttonText="Escoja una imagen" data-buttonName="btn-default" data-icon="false" class="filestyle" accept="image/x-png,image/png, image/gif, image/jpeg , image/jpg" type='file' id="filetoup"  name='imagen'>
				             <a href="" id="clearFile">Eliminar imagen a publicar</a>
				           </div>
					</div>
					<div class="form-group">
						<label class=" col-lg-12 control-label">Enlace:</label>
				           <div class="col-lg-12 ">
				           	<input class='form-control' type='text' name='link'>
				           </div>
					</div>
				</section>
				<div class="col-lg-6">
						<div class="form-group">
							<label class=" col-lg-12 control-label">Anuncios:</label>
					          <div class="col-lg-12">
					               <select data-typeselect="anuncis" class='form-control generate-select' name="anuncis" id="select-anuncis"  >
					        			<option value=''> Seleccione una base de datos de anuncios</option>
					           		<?php
					                    foreach ($anuncios as $anunci)
					                    {
					                         echo "<option value='".$anunci->id."'>".$anunci->name."</option>";
					                    }
					           		?>
					               </select>
					          	<div id="generate-anuncis"></div>
					          </div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-12 ">Bases de datos:</label>
					           <div class="col-lg-12">
					           
						           <select data-typeselect="bbdd" class='form-control generate-select' name="bbdd"  id="select-bbdd" >
							          <option value=''> Seleccione una base de datos</option>
						       		<?php
						               foreach ($basesdedatos as $bbdd)
						               {
						                   echo "<option value='".$bbdd->id."'>".$bbdd->name."</option>";
						             	}
						       		?>
						          </select>
						     	<div id="generate-bbdd"></div>
						     </div>
						</div>
						<div class="form-group col-lg-12">
						 <label class="control-label ">Cuentas:</label>
					  
							<section >
							<?php
											foreach($users as $page)
											{
												
												echo " <input type='checkbox' name='ck_group_ap[]' value='".$page->user_id."' /> <span >".$page->username."</span><br>";
											}
											?>
											
						   
						</section>
				
				
						</div>
						<section class="col-lg-12">
								<input type='submit' name='publicar' class="btn btn-primary" value='Enviar'/>
						</section>
						
					</div>	
					</form>
					<div>
						<?php if(count($programaciones)>0)
						{?>
						<table class="table table-striped">
							<thead>
								<tr>
									<td>Cuenta</td><td>Fecha</td><td>	Fecha Borrado</td><td>Estado</td><td></td>
								</tr>	
							</thead>
							<tbody>

								<?php foreach ($programaciones as $prog) {
								?>
									<tr>
									<td><?php echo $prog->name ?></td>
									<td><?php echo date('Y-m-d h:i:s',$prog->fecha)?></td>
									<td><?php echo (!empty($prog->fechaBorrado)?date('Y-m-d H:i:s',$prog->fechaBorrado):'-')?></td>
									<td><?php echo (($prog->state=='process')?"En proceso":'Terminado');?></td>
									<td> <a href="<?php echo base_url()?>panel/commonsocial/ver_programacion/<?php echo $prog->id;?>" data-toggle="ajaxModal" class="btn btn-primary" >Ver </a><a data-id="<?php echo $prog->id; ?>" class="btn deleteprog btn-danger" ><i class="fa fa-trash-o"></i></a></td>

									</tr>

								<?php } ?>
								

							</tbody>
						</table>
						<?php
						}
						?>
					</div>



<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>