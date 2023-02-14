<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>
<div class="row">
	<div class="span12 page-header"><?php echo $modelo['id'] ? "Alterar Modelo" : "Novo Modelo"?></div>
</div>
<div class="row">
	<form action="<?php echo site_url("laudos/novo_modelo");?>" method="post" name="enviaExame" id="enviaExame" enctype="multipart/form-data">
		<input type="hidden" name="_id" value="<?php echo $modelo['id']?>" />
		<div class="span12">
			<label for="title">Titulo</label>
			<input type="text" id="title" class="span3 required" name="title" value="<?php echo $modelo['title']?>" />
		</div>
		<div class="span12">
			<label for="content">Conteúdo</label>
			<textarea class="ckeditor span12" cols="80" id="content" name="content" rows="10"><?php echo $modelo['content'];?></textarea>
		</div>
		
	    <div class="span12">
		    <div class="form-actions">
				<button type="reset" class="btn">Cancelar</button>
				<button type="submit" class="btn btn-primary pull-right">Salvar Modelo</button>
			</div>
	    </div>
	</form>
</div>