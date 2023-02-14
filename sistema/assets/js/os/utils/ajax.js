var ajax = {
    call: function(method,url,data,fn){
        switch (method){
            case ('post'):
                this.post(url,data,function(res){
                    fn(res);
                });
                break;
            case ('get'):
                this.get(url,data,function(res){
                    fn(res);
                });
                break;
            case ('put'):
                this.put(url,data,function(res){
                    fn(res);
                });
                break;
            case ('delete'):
                this.delete(url,data,function(res){
                    fn(res);
                });
                break;
        }
    },
    post: function(url, data, fn, stay){
        data = !data ? {} : data;
        loader.start();

        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: data,
            success: function(res){
                if (!stay) loader.stop();
                fn(res);

            },
            error: function(res){
                loader.stop();
                fn(res);
            }
        });

    },
    get: function(url, data, fn, stay){
        loader.start();
        webix.ajax().header({ "Content-type":"application/json"})
            .get(url, data, {
                error:function(res){
                    loader.stop();
                    fn(res);
                },
                success:function(res){
                    if (!stay) loader.stop();
                    fn(res);
                }
            });
    },
    put: function(url, data, fn, stay){
        data = !data ? {} : data;
        loader.start();
        webix.ajax().header({ "Content-type":"application/json"})
            .put(url, JSON.stringify(data), {
                error:function(res){
                    loader.stop();
                    fn(res);
                },
                success:function(res){
                    if (!stay) loader.stop();
                    fn(res);
                }
            });
    },
    delete: function(url, data, fn, stay){
        data = !data ? {} : data;
        loader.start();
        webix.ajax().header({ "Content-type":"application/json"})
            .del(url, JSON.stringify(data), {
                error:function(res){
                    loader.stop();
                    fn(res);
                },
                success:function(res){
                    if (!stay) loader.stop();
                    fn(res);
                }
            });
    }
}

