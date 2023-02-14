var uploader = {
    ajax: {
        upload: function(f){
            var formdata = new FormData();
            formdata.append("file1", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "file_upload_parser.php");
            ajax.send(formdata);
        }
    }
}

function fcount() {
    var id= $$("upl1").files.getFirstId();
    var count = 0;
    while(id){
        id = $$("upl1").files.getNextId(id);
        count++;
    }
    return count;
}

function uploadFiles(){

    if (!$$('mylist').getFirstId()){
        webix.message({type:"error", text:"A lista está vazia!"});
        return;
    }

    //if (fcount() > 20){
    //    webix.message({type:"error", text:"Máximo 20 arquivos por lote!"});
    //    return;
    //}

    webix.modalbox({
        title:"Enviando Arquivo(s)...",
        buttons:["Sim", "Não"],
        text:"Confirma esse envio?",
        width:300,
        callback: function(result){
            switch(result){
                case "0":

                    doUpload();

                    break;
                case "1":
                    //statement
                    break;
            }
        }
    });

}

function enableButtons(enable){
    if (!enable){
        $$('btnLimpar').disable();
        $$('btnEnviar').disable();
        $$('upl1').disable();
        return;
    }

    $$('btnLimpar').enable();
    $$('btnEnviar').enable();
    $$('upl1').enable();

}

function doUpload(){

    enableButtons(false);

    var fc = fcount();

    $$('upl1').files.data.each(function(f) {

        var data = new FormData();
        data.append("file", f.file);

        var ajax = new XMLHttpRequest();

        ajax.upload.addEventListener("progress", function(event) {

            updateProgress(f, event);

            if (f.status == 'server') {
                fc--;
                if (fc == 0) enableButtons(true);
            }

        }, false);

        ajax.open("POST", "/sistema/exames/lotes", true);
        ajax.send(data);

    });

    return;

    $.ajax({
        type: 'post',
        url: '/sistema/exames/lotes',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
            console.log('sucesso!');
        }
    });

    return;

    $$('upl1').files.data.each(function(f) {

        var fd = new FormData();

        fd.append(f.name, f.file);

        console.log(fd);

        $.ajax({
            type: 'post',
            url: '/sistema/exames/lotes',
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            success: function (data) {
                console.log('sucesso!');
            }
        });

        return;

        var ajax = new XMLHttpRequest();

        ajax.upload.addEventListener("progress", function(event) {

            updateProgress(f, event);

        }, false);

        ajax.open("POST", "/sistema/exames/lotes", true);
        ajax.send(fd);


    });

    return;

    ajax.post('/s3/credential', null, function(doc){
        var credential = JSON.parse(doc);
        AWS.config.region = credential.Region;
        AWS.config.credentials = new AWS.CognitoIdentityCredentials(credential);

        $$('upl1').files.data.each(function(f) {

            var s3 = new AWS.S3();

            var params = {Bucket: credential.BucketName, Key: 'afcabb050affaabbcc0120/' + f.name, Body: f.file, ACL: "public-read", StorageClass: "REDUCED_REDUNDANCY"};

            var upload = s3.putObject(params);

            upload.on('httpUploadProgress', function(progress){
                updateProgress(f, progress);
            });

            upload.send(function(err, data){
                if (err) {
                    console.log(err);
                    return;
                }
                console.log(data);
            });

        });
    });

}

function updateProgress(f, progress){
    f.percent = (!progress.total || progress.total == 0) ? 0 : parseInt(progress.loaded / progress.total * 100);
    f.status = f.percent == 100 ? 'server' : 'transfer';
    var type = $$('mylist').type;
    type.template(f,type);
    $$('mylist').render();
}

function clearList(){

    if (!$$('mylist').getFirstId()){
        webix.message({type:"error", text:"A lista já está vazia!"});
        return;
    }

    webix.modalbox({
        title:"Limpando Lista de Arquivos...",
        buttons:["Sim", "Não"],
        text:"Confirma limpeza?",
        width:300,
        callback: function(result){
            switch(result){
                case "0":

                    doClearList();

                    break;
                case "1":
                    //statement
                    break;
            }
        }
    });

}

function doClearList(){
   $$("upl1").files.clearAll();
}

function cancelUploads(){

    if (!$$('mylist').getFirstId()){
        webix.message({type:"error", text:"A lista está vazia!"});
        return;
    }

    webix.modalbox({
        title:"Cancelando envio(s)...",
        buttons:["Sim", "Não"],
        text:"Confirma cancelamento?",
        width:300,
        callback: function(result){
            switch(result){
                case "0":

                    doCancelUploads();

                    break;
                case "1":
                    //statement
                    break;
            }
        }
    });

}

function doCancelUploads(){
    var id= $$("upl1").files.getFirstId();
    while(id){
        $$("upl1").stopUpload(id);
        id = $$("upl1").files.getNextId(id);
    }
    onLabelUpdate();
}

var label = '<b>0</b> arquivo(s) na lista';

var onLabelUpdate = function(){
    $$('label').setValue('<b>' + fcount() + '</b> arquivo(s) na lista');
}

var close_window = function() {
    $$('upload_window').close();
    window.location = '/sistema/inicio/lista';
}

var ui = {
    view:"window",
    modal: true,
    move: true,
    id:"upload_window",
    position:"center",
    head:{
        view:"toolbar", cols:[
            { view:"label", label: "Somente extensões ZIP, WXML, MDT, DCM, OIT e EEG são permitidos" },
            { view:"button", label: 'Fechar', width: 100, click:"close_window();", icon:"times", type: "iconButton" }
        ]
    },
    body: {
        rows: [
            { type: "space",
                rows: [
                    { view:"label", id: "label", label: label, height: 20, align: "right" },
                    {
                        view: "form", width: 1000, maxHeight: 500, elements: [
                        {
                            view: "uploader", id:"upl1", height:37, align:"center", type:"iconButton",
                            icon:"plus-circle", label:"Incluir Arquivo" , autosend:false, link:"mylist",
                            on: {
                                'onBeforeFileAdd': function(item){
                                    var type = item.type.toLowerCase();
                                    return (type == "zip" || type == "oit" || type == "dcm" || type == "eeg" || type == "wxml" || type == "pdf" || type == "mdt");
                                },
                                'onAfterFileAdd': function(item){

                                    onLabelUpdate();

                                }
                            }
                        },
                        {
                            borderless: true,
                            view:"list", scroll:true, id:"mylist", type:"myUploader"
                        },
                        {
                            id: "uploadButtons",
                            cols:[
                                {view:"button", id: "btnEnviar", label: "Enviar Arquivo(s)", type:"iconButton", icon: "upload", click: "uploadFiles()"},
                                //{view:"button", id: "btnCancelar", label: "Cancelar Envio(s)", type:"iconButton", icon: "ban", click: "cancelUploads()"}
                                {view:"button", id: "btnLimpar", label: "Limpar Lista", type:"iconButton", icon: "trash-o", click: "clearList()"}
                            ]
                        }
                    ]

                    }
                ]
            }
        ]
    }
};

webix.ready(function(){

    webix.type(webix.ui.list, {
        name:"myUploader",
        template:function(f,type){
            var name = f.name.length > 100 ? f.name.substr(0,100) + '...' : f.name;
            var html = "<div class='overall'><div class='name'>" + name + "</div>";
            html += "<div class='remove_file'><span class='cancel_icon'></span></div>";
            html += "<div class='status'>";
            //html += "<div class='progress "+f.status+"' style='width:"+(f.status == 'transfer' || f.status=="server" ? f.percent+"%": "0px")+"'></div>";
            html += "<div class='progress "+f.status+"' style='width:"+(f.status == 'transfer' || f.status=="server" ? f.percent+"%": "0px")+"'></div>";
            //html += "<div class='" + f.status + "' style='width:30" + "%"+"'></div>";
            html += "<div class='message "+ f.status+"'>"+type.status(f)+"</div>";
            html +=	 "</div>";
            html += "<div class='size'>"+ type.size(f)+"</div></div>";
            return html;
        },
        size: function(f){
            var size = f.sizetext.substring(f.sizetext.length - 2);
            return size == ' b' ? f.sizetext + 'ytes' : f.sizetext;
        },
        status:function(f){
            var messages = {
                server: "ENVIADO",
                error: "erro",
                client: "0%",
                transfer: f.percent+"%"
            };
            return messages[f.status]
        },
        on_click:{
            "remove_file":function(ev, id){
                $$(this.config.uploader).files.remove(id);
                onLabelUpdate();
            }
        },
        height: 35
    });

    webix.ui(ui).show();

    //onLabelUpdate();

});
