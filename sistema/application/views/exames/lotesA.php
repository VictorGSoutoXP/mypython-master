<?php echo $this->load->view('layouts/menu',false,true,false); ?>

<script src="<?php echo base_url('assets/js/os/pages/lotes.js') ?>"></script>

<script type="text/javascript">

    function parseXml(xml) {
        parser = new DOMParser();
        xmlDoc = parser.parseFromString(xml,"text/xml");

        console.log(xmlDoc);

        var exame    = xmlDoc.getElementsByTagName("Exame")[0];
        var paciente = xmlDoc.getElementsByTagName("Paciente")[0];
        if (!paciente || !exame) return;

        var nome = paciente.getElementsByTagName("Nome")[0].childNodes[0].nodeValue;
        var sexo = paciente.getElementsByTagName("Sexo")[0].childNodes[0].nodeValue;
        var nascimento = paciente.getElementsByTagName("DataNascimento")[0].childNodes[0].nodeValue;

        var peso = exame.getElementsByTagName("Peso")[0].childNodes[0].nodeValue;
        var altura = exame.getElementsByTagName("Altura")[0].childNodes[0].nodeValue;
        var imc = exame.getElementsByTagName("IMC")[0].childNodes[0].nodeValue.replace(/\D/g, '');

        $('#paciente\\[nome\\]').attr('value', nome);
        $("#paciente\\[sexo\\]").attr('value', sexo);
        $("#paciente\\[nascimento\\]").attr('value', nascimento);
        $("#paciente\\[peso\\]").attr('value', peso);
        $("#paciente\\[altura\\]").attr('value', altura / 100);
        $("#paciente\\[imc\\]").attr('value', imc / 10);

    }

    function loadFileSelected() {
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
            console.log('The File APIs are not fully supported in this browser.');
            return;
        }

        input = document.getElementById('arquivo_exame');
        if (!input) {
            console.log("Um, couldn't find the fileinput element.");
            return;
        }
        else if (!input.files) {
            console.log("This browser doesn't seem to support the `files` property of file inputs.");
            return;
        }
        else if (!input.files[0]) {
            console.log("Please select a file before clicking 'Load'");
            return;
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

