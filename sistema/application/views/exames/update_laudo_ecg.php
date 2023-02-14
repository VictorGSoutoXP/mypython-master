<?php

$freq = $_POST['freq'];

//$selecionado = $_POST["selecionado"];

/*
$ritmo = implode(",", $_POST['ritmo']);
$normalidade = implode(",", $_POST['normalidade']);
$bloq_atrial = implode(",", $_POST['bloq_atrial']);
$bloq_intra = implode(",", $_POST['bloq_intra']);
$sobrecargas = implode(",", $_POST['sobrecargas']);


*/









$selecao = implode(",", $_POST['selecionado']);
//$bpm = "bpm";




$id = '825484'; //id da tabela pacientes_exames



/*

$conn = mysqli_connect('localhost','root','','damat172_sistema');


$sql="UPDATE `pacientes_exames` SET laudo_ecg = '$freq $selecao' WHERE `id` = '$id'";


$resultado_view = mysqli_query($conn, $sql);



mysqli_close($conn);

*/





echo "Alterado com sucesso";

echo "<script>location.href='dama_definitivo.php';</script>";





?>