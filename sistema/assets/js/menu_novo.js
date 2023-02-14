webix.ui({
  rows:[
    { type:"header", template:"DAMA TELEMEDICINA" },
    { cols:[
      { view:"tree", data:tree_data, gravity:0.4, select:true },
      { view:"resizer" },
      { view:"datatable", autoConfig:true, data:grid_data }
    ]}
  ]
})

webix.ui({
  view:"datatable", data:grid_data, columns:[
    { id:"title" , fillspace:true , header:[
      "NOME", { content:"textFilter" }
    ]},
    { id:"rating", sort:"int", header:"ID",
    	}
  ], select:"row", navigation:true, ready:function(){
  	this.select(this.getFirstId());
  }
})

webix.ui({
  rows:[
    { type:"header", template:"DAMA TELEMEDICINA" },
    { cols:[
      { view:"tree", data:tree_data, gravity:0.4, select:true },
      { view:"resizer" },
      { view:"datatable", autoConfig:true, data:grid_data }
    ]}
  ]
})