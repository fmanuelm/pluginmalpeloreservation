var destino = document.querySelector("#destino");
var fecha = document.querySelector("#fecha");
var habitacion = document.querySelector("#habitacion");
var personas = document.querySelector("#personas");
var opciones2;
let valorDestino = null;
var priceHab;
var localhost = window.location.hostname;
if(localhost === 'localhost')
{
	localhost = '/fernando';
}
else {
	localhost = window.location.protocol + '//' + localhost;
}
document.querySelector("#submit").disabled = true;
destino.addEventListener("change", function (event) {
	if (destino.value !== '0')
		valorDestino = destino.value;
	var xhr = new XMLHttpRequest();
	fecha.innerHTML = "";

var option0 = document.createElement("option");
option0.value = 0;
option0.text = "* Seleccion una fecha";
fecha.appendChild(option0);
xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		
		var result = JSON.parse(this.responseText);
		var opciones = result.datos;
		document.getElementById("total").value = "";
		//opciones2 = result.datos2;
		//var opciones = this.responseText;
		console.log("resultado: " + opciones);
		console.log("tamaño: " + opciones.length);
		//for (var i = 0; i < opciones.length; i++) {
		Array.from(opciones).forEach((val, index)=>{
			//var opcion = opciones[i];
			var opcion = val;
			var option = document.createElement("option");
			//option.value = opcion.value;
			//option.text = opcion.text;
			option.value = opcion.fecha;
			
			option.text = opcion.fecha;
			option.disabled = (opcion.status == 1)?false:true;
			fecha.appendChild(option);
   			//}
		});
		habitacion.innerHTML="<option value='0'></option>";
		/*
		Array.from(opciones2).forEach((val, index)=>{
			var opcion2 = val;
			var option2 = document.createElement("option");
			option2.value = opcion2.id;
			option2.text = opcion2.room_name;
			habitacion.appendChild(option2);
		});
		*/
	}
};
	//xhr.open("GET", "http://locahost/fernando/wp-admin/admin-ajax.php?action=change_destination_form&destino=" + destino.value, true);
	xhr.open("POST", localhost + "/wp-admin/admin-ajax.php", true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send('action=change_destination&mi_destino=' + encodeURIComponent(valorDestino));
});
fecha.addEventListener("change", function (event){
	valorDestino = destino.value;
	//fecha = fecha.value;
	var xhr = new XMLHttpRequest();
	habitacion.innerHTML="<option value='0'></option>";
	if (fecha.value !== 0 && fecha.value !== '0') {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var result = JSON.parse(this.responseText);
				
				opciones2 = result.datos;
				Array.from(opciones2).forEach((val, index)=>{
					var opcion2 = val;
					var option2 = document.createElement("option");
					option2.value = opcion2.id_room;
					option2.text = opcion2.room_name;
					option2.setAttribute("data-disponible", opcion2.disponible);
					habitacion.appendChild(option2);
				});
				
			}
		};
		xhr.open("POST", localhost + "/wp-admin/admin-ajax.php", true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.send('action=change_fecha&mi_destino=' + encodeURIComponent(valorDestino) + "&fecha="+fecha.value);
		
	}
	else {
		document.getElementById("total").value = "";
		
	}
});
habitacion.addEventListener("change", function (event) {
	if (personas.options.length < 2 && personas.value !== 0)
	{
		/*
		var option1 = document.createElement("option");
		option1.value = 1;
		option1.text = "1";
		personas.appendChild(option1);

		var option2 = document.createElement("option");
		option2.value = 2;
		option2.text = "2";
		personas.appendChild(option2);
		*/
	}
	document.querySelector("#personas").innerHTML = "";
	document.querySelector("#total").value = 0;
	var miHabitacion = habitacion.value;

	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			
			var result = JSON.parse(this.responseText);
			priceHab = result.price;
			let peopleHab =  parseInt(result.people) + 1;
			document.querySelector("#total").value = priceHab;
			for(let c = 1; c < peopleHab; c++)
			{
				var option = document.createElement("option");
				option.value = c;
				option.text = "" + c + "";
				personas.appendChild(option);
			}
			//document.querySelector("#total").value = priceHab * document.querySelector("#personas").value;
		}
	};

	xhr.open("POST", localhost + "/wp-admin/admin-ajax.php", true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send('action=change_habitacion&mi_habitacion=' + encodeURIComponent(miHabitacion));
	
	if (habitacion.value == 0)
	{
		document.querySelector("#total").value = "";
		document.querySelector("#submit").disabled = true;
	}
	else {
		document.querySelector("#submit").disabled = false;
	}
	
	
});
personas.addEventListener("change", function (event) {
	//document.getElementById("num").value = personas.value;
	document.querySelector("#total").value = priceHab * document.querySelector("#personas").value;
});