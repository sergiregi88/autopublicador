
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<?php $arrayStates=array('process'=>'En proceso','finished'=>"Terminado",'finisherase'=>'Terminado','nocomplete'=>"No completado",'toerase'=>'Pendiente de borrar'); ?>
			<h4>Ver datos de la programacion #<?php echo $prog[0]->id." (".$arrayStates[$prog[0]->state].")"; ?></h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<?php if(isset($prog[0]->text) && $prog[0]->text!="")
					{
						?>
						<div class="col-lg-6">
								<strong>Texto</strong><br>
								<?php echo $prog[0]->text;?>								
						</div>
					<?php
					} ?>

					<?php if(isset($prog[0]->path) && $prog[0]->path!="")
					{
						?>
						<div class="col-lg-6">
								<strong>Imagen</strong><br>

								<?php $posuser=strpos($prog[0]->path,'@');
									echo $posuser;
									if($posuser)
									{

										$pos=strpos($prog[0]->path,'upload');	
										$imgsrc= substr($prog[0]->path,$pos );
										$imgsrc=$this->flexi_auth->get_user_identity()."/".$imgsrc;
									}
									else
									{
										$pos=strpos($prog[0]->path,'upload');	
										$imgsrc= substr($prog[0]->path,$pos );
									}

									echo "<img width='200' src='".base_url().$imgsrc."'>";
									?>								
						</div>
					<?php
					} ?>
					<?php if(isset($prog[0]->link) && $prog[0]->link!="")
					{
						?>
						<div class="col-lg-6">
								<strong>Enlace</strong><br>
								<?php echo "<a href='".$prog[0]->link."' >".$prog[0]->text."</a>";?>								
						</div>
					<?php
					} ?>
					<div class="col-lg-6">
						<strong>Fecha y hora</strong>
						<br>
						<?php echo date('d-m-Y H:i:s',$prog[0]->fecha)?>
					</div>
					<?php if(!empty($prog[0]->fechaBorrado) && $prog[0]->fechaBorrado!="")
					{
						?>
						<div class="col-lg-6">
								<strong>Fecha borrado</strong><br>
								<?php echo date('d-m-Y H:i:s',$prog[0]->fechaBorrado)?>								
						</div>
					<?php
					} ?>
					<?php if(isset($prog[0]->id_publish) && $prog[0]->id_publish!="" && $prog[0]->state!='finisherase')
					{
						?>
						<div class="col-lg-6">
								<strong>Fecha borrado</strong><br>
								<?php if($prog[0]->social_network=='fb')
								$url="http://www.facebook.com/";
								else
									$url="http://www.twitter.com/".$prog[0]->socialaccount."/status/";
								?>

								<?php echo "<a target='_blank' href='".$url.$prog[0]->id_publish."' >Url de la publiación</a>";?>						
						</div>
					<?php
					} ?>
					
					



			</div>
			
		</div>
		<div class="modal-footer">
	
		</div>
	
