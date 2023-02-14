<script type="text/javascript">

function parseXml(xml) {
    parser = new DOMParser();
    xmlDoc = parser.parseFromString(xml,"text/xml");
    var paciente = xmlDoc.getElementsByTagName("Paciente")[0];

    var nome = paciente.getElementsByTagName("Nome")[0].childNodes[0].nodeValue;
    var sexo = paciente.getElementsByTagName("Sexo")[0].childNodes[0].nodeValue;
    var nascimento = paciente.getElementsByTagName("DataNascimento")[0].childNodes[0].nodeValue;

    $('#paciente\\[nome\\]').attr('value', nome);
    $("#paciente\\[sexo\\]").attr('value', sexo);
    $("#paciente\\[nascimento\\]").attr('value', nascimento);

    }

function loadFileSelected() {
    if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
    alert('The File APIs are not fully supported in this browser.');
    return;
    }

    input = document.getElementById('arquivo_exame');
    if (!input) {
    alert("Um, couldn't find the fileinput element.");
    }
    else if (!input.files) {
    alert("This browser doesn't seem to support the `files` property of file inputs.");
    }
    else if (!input.files[0]) {
    alert("Please select a file before clicking 'Load'");
    }
    else {
    file = input.files[0];
    fr = new FileReader();
    fr.onload = function(){
    parseXml(fr.result);
    }
    fr.readAsText(file);
    //fr.readAsDataURL(file);
    }
    }

$(document).ready(function(){
    $("#arquivo_exame").change(function() {
        loadFileSelected();
    });
    });


</script>

