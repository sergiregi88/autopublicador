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
            <div class="sep"></div>
            <div class="page-head">
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                  <h2>Editar base de datos: <?php echo $anuncio->name; ?></h2>

                  </div>
                </div>
              </div>


            </div>
            <div class="content">
              <div class="container">
            		<div class='namebd'>
    <p>Inserte imágenes en: <span class='bold'> <?php echo $anuncio->name."</span> <span class='right'> Tiene ".$total." imágenes creadas. El máximo de imágenes son ".$this->config->item('max-images').".</span>";?></p>
</div>

<div id="message"></div>
<form  method="post"  enctype='multipart/form-data'>	
	<div id="uploader">
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                
        </div>
    <input type='hidden' id='image_add_id' name='anuncio_add' value='<?php echo $anuncio->id; ?>'>
</form>
<br class='clearfix'>
<script type="text/javascript">
var url_plupload='<?php echo base_url()?>admin/anuncios/editar/<?php echo $anuncio->id; ?>';
var flash_swf_urlfile='<?php echo base_url()?>public/js/Moxie.swf';
var silverlight_xap_urlfile='<?php echo base_url()?>public/js/Moxie.xap';
var idUploader='#uploader'
var checkmaxelements_url="<?php echo base_url()?>admin/anuncios/ismaxelementsimages/<?php echo $anuncio->id; ?>"
var deletecontent_url='<?php echo base_url()?>admin/anuncios/deletecontent/<?php echo $anuncio->id; ?>'
var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>
		<div class="row">
				<div class="col-sm-12 text-right">
	                	
	                	<input type="button" class="btn btn-danger deletemulti" value="Borrar">
	              </div>
			</div>
			<div class "row" id="contenido">
				<?php if(count($elements)>0){
					?>
				<div class='namebd'>
				<p>Elimine frases de: <span class='bold'><?php echo $anuncio->name;?></span></p>    
				</div>

				<div class="row">
				    <?php
				    foreach ($elements as $element)
				    {
				        ?>
				        <div class="col-sm-2">
				        	<img width="60" height="60" src="<?php echo base_url()?>upload/<?php echo $element->filename;?>"/>
						<a data-id='<?php echo $element->id; ?>' class='btn btn-danger deletecontent'><i class='fa fa-trash-o'></i></a> 
						<input type='checkbox' value='<?php echo $element->id; ?>' name='hk_group_bf[]'>
				        </div>
				        <?php
				    }
				    ?>
				    </div>
				    <div class="row">
						<?php echo $link_pager; ?>
					</div>
				    <?php
				 }else{
				    ?>
				
				   
				    		<td colspan="4">No hay ningún elemento en esta base de datos</td>
				   

				 	<?php
				 } ?>
	

                    
                   
                </div>
            </div>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>