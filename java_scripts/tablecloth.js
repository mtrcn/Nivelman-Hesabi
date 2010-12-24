this.tablomaskele = function(){

	var tableover = false;
	this.start = function(){
		var tables = document.getElementsByTagName("table");
		for (var i=0;i<tables.length;i++){
			if(tables[i].id == "levelling-table"){
	  			rows(tables[i]);
			}
		};
	};
	
	this.rows = function(table){
		var css = "";
		var tr = table.getElementsByTagName("tr");
		for (var i=0;i<tr.length;i++){
			css = (css == "odd") ? "even" : "odd";
			tr[i].className = css;
		};
	};

	start();

};

window.onload = tablomaskele;
