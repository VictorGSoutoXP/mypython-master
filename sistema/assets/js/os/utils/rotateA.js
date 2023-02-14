var rotateMap = [];

function parseImageContainer(){
	for (var i=0; i < 10; i++){
		var obj = $("#imagem" + i + "_container");
		if (!obj.attr('id')) continue;
		var img = $("#imagem" + i);
		var h = img.height() > img.width() ? img.height(): img.width();
		obj.height(h);
		//obj.attr("style", "margin-top:100px;");
	}
}

function doRotate(id){

	var i = $("#imagem" + id);
	var c = $("#imagem" + id + "_container");

	rotateMap[id] = !rotateMap[id] ? 0 : rotateMap[id]; 
	rotateMap[id]+= 90;
	rotateMap[id] = rotateMap[id] > 270 ? 0 : rotateMap[id];

	i.attr("class", "rotate" + rotateMap[id]);

	//var height = (rotateMap[id] == 0 || rotateMap[id] == 180) ? i.height() : i.width(); 
	//c.attr("style", "margin-top:0px;height:" + height + "px");
	console.log('imagem' + id, '=>', rotateMap[id], i.height(), ' X ', i.width(), 'container.height:', c.height());
}

/* image rotate javascript */

/* This script and many more are available free online at
The JavaScript Source!! http://javascript.internet.com
Created by: Benoit Asselin | http://www.ab-d.fr */

var rotateMap=[];

function rotate(id) {
	if(document.getElementById('canvas' + id)) {
		/*
		Ok!: Firefox 2, Safari 3, Opera 9.5b2
		No: Opera 9.27
		*/
		if (typeof rotateMap[id] === 'undefined') rotateMap[id]=0;
		else rotateMap[id] += 90;
		
		rotateMap[id] = rotateMap[id] > 270 ? 0 : rotateMap[id];
		
		var p_deg = rotateMap[id];
		
		console.log('id:', id, 'p_deg:', p_deg);
		var image = document.getElementById('image' + id);
		var canvas = document.getElementById('canvas' + id);
		var canvasContext = canvas.getContext('2d');
		
		switch(p_deg) {
			default :
			case 0 :
				canvas.setAttribute('width', image.width);
				canvas.setAttribute('height', image.height);
				canvasContext.rotate(p_deg * Math.PI / 180);
				canvasContext.drawImage(image, 0, 0);
				break;
			case 90 :
				console.log('rotate90');
				canvas.setAttribute('width', image.height);
				canvas.setAttribute('height', image.width);
				canvasContext.rotate(p_deg * Math.PI / 180);
				canvasContext.drawImage(image, 0, -image.height);
				break;
			case 180 :
				canvas.setAttribute('width', image.width);
				canvas.setAttribute('height', image.height);
				canvasContext.rotate(p_deg * Math.PI / 180);
				canvasContext.drawImage(image, -image.width, -image.height);
				break;
			case 270 :
			case -90 :
				canvas.setAttribute('width', image.height);
				canvas.setAttribute('height', image.width);
				canvasContext.rotate(p_deg * Math.PI / 180);
				canvasContext.drawImage(image, -image.width, 0);
				break;
		};
		
	} else {
		/*
		Ok!: MSIE 6 et 7
		*/
		var image = document.getElementById('image' + id);
		switch(p_deg) {
			default :
			case 0 :
				image.style.filter = 'progid:DXImageTransform.Microsoft.BasicImage(rotation=0)';
				break;
			case 90 :
				image.style.filter = 'progid:DXImageTransform.Microsoft.BasicImage(rotation=1)';
				break;
			case 180 :
				image.style.filter = 'progid:DXImageTransform.Microsoft.BasicImage(rotation=2)';
				break;
			case 270 :
			case -90 :
				image.style.filter = 'progid:DXImageTransform.Microsoft.BasicImage(rotation=3)';
				break;
		};
		
	};
};
