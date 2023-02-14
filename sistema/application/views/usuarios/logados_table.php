<div class="row">
    <div class="span12">
        <table class="table-bordered table-list tablesorter table hasFilters tablesorter-bootstrap">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Logado em</th>
                <th>Tipo</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($logados as $logado){ ?>
                <tr>
                    <td><?php echo $logado['id'] ?></td>
                    <td><?php echo $logado['nome'] ?></td>
                    <td><?php echo $logado['email'] ?></td>
                    <td><?php echo $logado['logado'] ?></td>
                    <td><?php echo strtoupper($logado['tipo']) ?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    setInterval('window.location.reload()', 50000);
</script>