<!DOCTYPE html>
<html>
<head>
	<title>Autopublicador Social</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" />
	<?php echo $this->load->view('includes2/head');?>
</head>
<body>
	<?php $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
	?>
	<?php echo $this->load->view('includes2/header');
	$arraytypes=array(array("name"=>"user","title"=>"Usuarios"),array("name"=>"group","title"=>"Grupos"),array("name"=>"page","title"=>"Páginas"),array("name"=>"event","title"=>"Eventos"))
	?>
	<div class="clearfix ">
		<div class="col-lg-3"><a href="<?php echo base_url(); ?>panel/facebook/connectar_facebook" class="btn btn-primary">Connectar con Facebook</a></div>
		<div class="col-lg-2"><a class="btn btn-default showHide" >Crear Carpeta</a></div>

		<div  class="col-lg-6 clearfix  hidden"  >
			<form id="createFolder" action="" class="form-horitzonal">
				<div class="message"></div>
				<div class="col-lg-12 form-group">
					<label for="" class="label-control col-lg-4">Nombre:</label>
					<div class="col-lg-7">
						<input name="name" class="form-control" type="text">
					</div>
				</div>
				<div class="col-lg-12 form-group">
					<label for="" class="label-control col-lg-4">Carpeta para:</label>
					<div class="col-lg-7">
						<select name="type" class="select form-control">
							<option value="">Selecciona un tipo</option>
							<option value="event">Event</option>
							<option value="user">Usuario</option>
							<option value="group">Grupo</option>
							<option value="page">Página</option>
						</select>
					</div>
				</div>
				<div class="form-group  col-lg-12">
					<input type="submit"  class=" col-lg-offset-5  btn btn-primary" value="Crear carpeta"/>
				</div>
			</form>
		</div>
	</div>
	<div role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">,
			<?php for($i=0;$i<count($arraytypes);$i++){ 

				?>
				
				<li class="<?php echo (($i==0)?"active":""); ?>" role="presentation" >
					<a href="#<?php echo $arraytypes[$i]['name']; ?>" aria-controls="home"  role="tab" data-toggle="tab">
						<?php echo $arraytypes[$i]['title']; ?>
						<span class="badge">
							<?php
							$numc=0;
							for ($m=0;$m<count($arraydata[$arraytypes[$i]['name']]['folders']);$m++)
							{
								$numc=$numc+count($arraydata[$arraytypes[$i]['name']]['folders'][$m]['rows']);
							}
							echo (count($arraydata[$arraytypes[$i]['name']]['nofolder'])+$numc); ?>
						</span>
					</a>
				</li>
				<?php } ?>	
						    <!--!<li role="presentation" class="pages"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Páginas</a></li>
						    <li role="presentation"><a href="#groups" aria-controls="profile" role="tab" data-toggle="tab">Grupos</a></li>
						    <li role="presentation"><a href="#events" aria-controls="messages" role="tab" data-toggle="tab">Eventos</a></li>
					-->
		</ul>			
		<!-- Tab panes -->
		<div class="tab-content">
			<?php 
			for($i=0;$i<count($arraytypes);$i++){
				?>
				<div role="tabpanel" class="tab-pane <?php echo (($i==0)? "active":""); ?>" id="<?php echo $arraytypes[$i]['name'];?>">	
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<?php
							if(count($arraydata[$arraytypes[$i]['name']]['nofolder'])>=0)
							{		
								?>
								<div class="panel panel-default">
									<div class="panel-heading">Cuentas sin carpeta </div>

									<div class="panel-body">
										<table class="table table-striped">
											<?php
											foreach ($arraydata[$arraytypes[$i]['name']]['nofolder'] as $pagenofolder) {
												?>
												
												<tr >
													<td>
														<img src="http://graph.facebook.com/v2.2/<?php echo ((!isset($pagenofolder->idaccount))?$pagenofolder->user_id:$pagenofolder->idaccount); //$pagenofolder->idaccount ?>/picture?width=50&height=50">

													</td>
													<td >
														<?php echo ((!isset($pagenofolder->name))?$pagenofolder->username:$pagenofolder->name); ?>
													</td>
													<td>
														<a href="https:/www.facebook.com/<?php echo ((!isset($pagenofolder->idaccount))?$pagenofolder->user_id:$pagenofolder->idaccount); ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
														<a href="<?php echo base_url()?>panel/facebook/editar/<?php echo ((!isset($pagenofolder->idaccount))?$pagenofolder->id:$pagenofolder->idaccount); ?>" class="btn btn-default btn-ms"> <i  class="fa fa-edit"></i></a>
														<a data-user="<?php echo ((!isset($pagenofolder->idaccount))?'true':'false') ?>" data-id="<?php echo $pagenofolder->id ?>" class="btn btn-danger deleteaccount" data-type="false" data-social="fb"><i class="fa fa-trash-o"></i></a>
														
													</td>
												</tr>

												<?php   			

								        				# code...
											}
											?>
										</table>
									</div>
								</div>
								<?php
							}
							if(count($arraydata[$arraytypes[$i]['name']]['folders'])>0)
							{	

								?>
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<?php
									foreach ($arraydata[$arraytypes[$i]['name']]['folders'] as $folder) {
										?>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headerfold<?php echo $folder['data']->id; ?>">
												<h4 class=" clearfix panel-title">
													<a data-toggle="collapse" data-parent="#accordion" aria-expanded="false" href="#fold<?php echo $folder['data']->id; ?>"  aria-controls="fold<?php echo $folder['data']->id; ?>">
														<span><?php echo $folder['data']->name; ?><span class="badge"><?php echo count($folder['rows']); ?></span></span>
														<div class="pull-right btn btn-danger deleteaccount"  data-user="<?php echo (($arraytypes[$i]['name']=="user")?'true':'false'); ?>" data-type="true" data-social="fb"  data-id="<?php echo $folder['data']->id; ?>"><i class="fa fa-trash-o"></i></div>
													</a>

												</h4>
											</div>
											<div id="fold<?php echo $folder['data']->id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headerfold<?php echo $folder['data']->id; ?>">
												<div class="panel-body">


										<table class="table table-striped">
											<?php
												foreach ($folder['rows'] as $pagefolder) 
												{
											?>

											<tr id="line<?php echo $pagefolder->id ?>">
												<td>
													<img src="http://graph.facebook.com/v2.2/<?php echo ((!isset($pagefolder->idaccount))?$pagefolder->user_id:$pagefolder->idaccount);///$pagefolder->idaccount ?>/picture?width=50&height=50">

												</td>
												<td >
												<?php echo ((!isset($pagefolder->name))?$pagefolder->username:$pagefolder->name); ?>
													<!--<?php// echo $pagefolder->name; ?>-->
												</td>
												<td>
													<a href="https:/www.facebook.com/<?php echo ((!isset($pagefolder->idaccount))?$pagefolder->user_id:$pagefolder->idaccount);//$pagefolder->idaccount ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
													<a href="<?php echo base_url()?>panel/facebook/editar/<?php echo ((!isset($pagefolder->idaccount))?$pagefolder->id:$pagefolder->idaccount);//$pagefolder->idaccount ?>" class="btn btn-default btn-ms"> <i  class="fa fa-edit"></i></a>
												 	<a  data-user="<?php echo ((!isset($pagefolder->idaccount))?'true':'false') ?>" data-id="<?php echo $pagefolder->id ?>" data-type="false" data-social="fb" class="btn btn-danger deleteaccount"><i class="fa fa-trash-o"></i></a>
												</td>
											</tr>
											<?php   			
											}
											?>
										</table>
									</div>
								</div>
							</div>
							<?php		
							}
							?>
						</div>
						<?php   			
						}
						?>
					</div>
				</div>
			</div>		
			<?php
			}
			?>	    	
		</div>
	</div>

		<script type="text/javascript">
			var deletecontent_url='<?php echo base_url()?>panel/facebook/deletecontent';
			var current_url='<?php echo base_url().$this->uri->uri_string();?>';
		</script>
		<?php
		echo $this->load->view('includes2/footer');
		?>
		<?php echo $this->load->view('includes2/scripts');?>
	</body>
</html>