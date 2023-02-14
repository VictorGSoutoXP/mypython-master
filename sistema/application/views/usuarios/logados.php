<?php echo $this->load->view('layouts/menu',false,true,false); ?>

<?php if($logados){?>
    <div class="tableContainer">
        <?php echo $this->load->view('usuarios/logados_table', $logados, true, false); ?>
    </div>
<?php }else{ ?>
    <div class="well">
        <h3 class="text-center">Nenhum usuário logado!</h3>
    </div>
<?php }?>

<script type="text/javascript">
</script>


