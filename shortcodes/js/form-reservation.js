var destino = document.querySelector("#destino");
var fecha = document.querySelector("#fecha");
var habitacion = document.querySelector("#habitacion");
var personas = document.querySelector("#personas");
let fechas_sectorizadas = {};
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
document.addEventListener("DOMContentLoaded", function() {
	var destino_logos = document.getElementsByClassName("destino-logo");
	for (var i = 0; i < destino_logos.length; i++) {
	    destino_logos[i].addEventListener("click", function(event) {
	    	document.getElementById("yearTabs").innerHTML = "";
	    	document.getElementById("yearContents").innerHTML = "";
	    	
	    	var destino_id = event.currentTarget.dataset.destino;
	    	destino.value = destino_id;
	    	var eventChange = new Event('change', { bubbles: true });
      
	      	// Dispara el evento 'change'
	      	destino.dispatchEvent(eventChange);
	    });
	}
});
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
		fechas_sectorizadas = {};
		Array.from(opciones).forEach((val, index)=>{
			//var opcion = opciones[i];
			var opcion = val;
			var option = document.createElement("option");
			//option.value = opcion.value;
			//option.text = opcion.text;
			console.log("opcion fecha: " + opcion.fecha);
			option.value = opcion.fecha;
			option.text = opcion.fecha;
			let fecha_ma = (opcion.fecha).split("-");
			let year = fecha_ma[0];
			let mes = fecha_ma[1];
			let dia = fecha_ma[2];
			console.log("****resultado fecha****");
			//console.log(`${year}-${mes}-${dia}`);
			if(!fechas_sectorizadas[year])
			{
				fechas_sectorizadas[year] = [];
			}
			fechas_sectorizadas[year].push(`${mes}-${dia}`);

			option.disabled = (opcion.status == 1)?false:true;
			fecha.appendChild(option);
			

		});
		
		const tabsContainer = document.getElementById('yearTabs');
	    const contentContainer = document.getElementById('yearContents');

	    // Nuevo: un Set para rastrear los años para los que ya se crearon botones
		const yearsAdded = new Set();

	    Object.keys(fechas_sectorizadas).forEach((year) => {
	        //if (!yearsAdded.has(year)) {
	        //    yearsAdded.add(year);

	            // Crear y añadir el botón del año
	            const yearButton = document.createElement('button');
	            yearButton.className = 'yearButton';
	            yearButton.textContent = year;
	            yearButton.onclick = () => showYear(year);
	            tabsContainer.appendChild(yearButton);

	        //}
	    });
		habitacion.innerHTML="<option value='0'></option>";
		
	}
};
	//xhr.open("GET", "http://locahost/fernando/wp-admin/admin-ajax.php?action=change_destination_form&destino=" + destino.value, true);
	xhr.open("POST", localhost + "/wp-admin/admin-ajax.php", true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send('action=change_destination&mi_destino=' + encodeURIComponent(valorDestino));
});

function showYear(selectedYear) {
	console.log("datos---");
	console.log(fechas_sectorizadas[selectedYear]);
	let dates = fechas_sectorizadas[selectedYear];
	let yearContents = document.getElementById("yearContents");
	yearContents.innerHTML = "";
	// Agrupar fechas por el mes
    const months = {};
    dates.forEach(date => {
        const month = date.split('-')[0]; // Extraer el mes como "09"
        if (!months[month]) {
            months[month] = [];
        }
        months[month].push(date);
    });

    // Crear un div para cada mes y añadirlo al contenedor
    Object.keys(months).forEach(monthNumber => {
        const monthName = getMonthName(monthNumber);
        const monthDiv = document.createElement('div');
        monthDiv.id = `month-${monthNumber}`;
        monthDiv.style.margin = "10px";
        //monthDiv.textContent = monthName; // Añadir el nombre del mes al div

        yearContents.appendChild(monthDiv);
        const labelMonth = document.createElement('div');
        labelMonth.textContent = monthName;
        monthDiv.appendChild(labelMonth);
    });

    let selectElement = document.getElementById('fecha');

    // Recorrer cada opción del select
    for (let i = 0; i < selectElement.options.length; i++) {
        let option = selectElement.options[i];
        
        if (option.value !== '0')
        {
        	//alert(option.value);
        	/*
        	let xhr2 = new XMLHttpRequest();
        	xhr2.onreadystatechange = function() {
        		alert();
				if (this.readyState == 4 && this.status == 200) {
					let result = JSON.parse(this.responseText);
					let opciones = result.datos;
					alert(opciones);
				}

				xhr2.open("POST", localhost + "/wp-admin/admin-ajax.php", true);
				xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr2.send('action=query_date&fecha=' + encodeURIComponent(option.value));
			};
			*/
			// Llamada AJAX usando fetch
			let dateLi = option.value;
        	dateLi = dateLi.split("-");
        	let dateLiMonth = dateLi[1];
        	//alert(dateLiMonth);
        	if (selectedYear === dateLi[0])
        	{
			
			fetch(localhost + '/wp-admin/admin-ajax.php?action=query_date', {
			    method: 'POST',
			    headers: {
			        'Content-Type': 'application/x-www-form-urlencoded',
			    },
			    body: new URLSearchParams({
			        'fecha': option.value
			    })
			})
			.then(response => response.json())
			.then(data => {

			    if (data.datos) {
			        const numeroReservas = data.datos;
			        console.log("fecha: " + option.value);
			        console.log('Número de reservas:', numeroReservas);
			        let monthContent = document.getElementById(`month-${dateLiMonth}`);
	        		let newdateToAdd = document.createElement("div");
	        		newdateToAdd.onclick = () => selectDate(option.value);
	        		newdateToAdd.innerHTML = option.value + "<span> Disponible</span>";
	        		monthContent.appendChild(newdateToAdd);
			    } if(data.datos === 0) {
			        const numeroReservas = data.datos;
			        console.log("fecha: " + option.value);
			        console.log('Número de reservas:', numeroReservas);
			        let monthContent = document.getElementById(`month-${dateLiMonth}`);
	        		let newdateToAdd = document.createElement("div");
	        		newdateToAdd.onclick = () => selectDate(option.value);
	        		newdateToAdd.innerHTML = option.value + "<span> Full</span>";
	        		monthContent.appendChild(newdateToAdd);
			    }
			})
			.catch(error => {
			    console.error('Error en la solicitud:', error);
			});
        	//alert(option.value);
        	
        		
        	}
        }
    }

	/*
    // Ocultar todos los contenedores de contenido
    document.querySelectorAll('.yearContent').forEach(content => {
        content.classList.add('hidden');
    });

    // Mostrar el contenedor del año seleccionado
    const contentToShow = document.getElementById('content' + selectedYear);
    if (contentToShow) {
        contentToShow.classList.remove('hidden');
    }
    */
}

function selectDate (valor)
{
	const select = document.getElementById('fecha');
    
    // Recorre todas las opciones del select
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === valor) {
            // Si encuentra la opción con el valor, la selecciona
        	select.selectedIndex = i;

            // Crear un evento 'change' y despacharlo para que se lance
            const event = new Event('change', {
                bubbles: true, // para que pueda propagarse
                cancelable: true // por si quieres que pueda ser prevenido
            });
            select.dispatchEvent(event);
            
            break;
        }
    }
}
// Función para obtener el nombre del mes a partir de un número
function getMonthName(monthNumber) {
    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    const index = parseInt(monthNumber, 10) - 1;
    return months[index];
}

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
					if (opcion2.disponible === '0')
					{
						option2.setAttribute("disabled","disabled");
					}
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