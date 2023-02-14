<?php echo $this->load->view('layouts/menu',false,true,false); ?>
<form action="" method="get">
    <fieldset>
        <legend>Manuais</legend>
        <div class="row">
            <div class="span2">
                <i class="fa fa-book fa-lg"></i>&nbsp;<a download href="<?php echo site_url("/downloads/teste.txt")?>"><b>Manual 1</b></a>
            </div>
        </div>
        <legend>Downloads</legend>
        <div class="row">
            <div class="span2">
                <i class="fa fa-download fa-lg"></i>&nbsp;<a download href="<?php echo site_url("/downloads/teste.txt")?>"><b>Arquivo 1</b></a>
            </div>
        </div>
    </fieldset>
</form>