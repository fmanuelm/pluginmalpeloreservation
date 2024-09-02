const addDate = document.getElementById("addDate");
const addBedroom = document.getElementById("addBedroom");
//const fechas = document.getElementById("fechas");
const habitaciones = document.getElementById("habitaciones");
let habitaciones_list = document.getElementById("habitaciones_json").value;
let create_reservation = document.getElementById('create_reservation');
let inputCount = 1;
let inputCountHab = 0;

if (document.querySelector("#no_fechas") !== null)
{
	inputCount = document.getElementById('no_fechas').value;
}

create_reservation.addEventListener("submit", function(event){
  
  let vacio = 0;
  const input_fechas = document.querySelectorAll('input.fecha[type="date"]');


  input_fechas.forEach((input_fecha) => {
    if (input_fecha.value === '')
    {
      vacio++;
    }
  });
  if (vacio > 0)
  {
    event.preventDefault();
    alert("Los campos fecha no estar vacíos");
  }
  else
  {
    //this.submit();
  }
});
addBedroom.addEventListener("click", function() {
	
	const newRoom = document.createElement("div");
	const mode = document.getElementById('mode').value;
  const fecha = document.createElement("input");
  
  let habitaciones_json = JSON.parse(habitaciones_list);
	let add_check_update = '';
	if (mode === 'update')
		add_check_update = "<select name='date_enable[]'><option value='1'>Enabled</option><option value='0'>Disabled</option> </select>";
    newRoom.classList.add("form-group");
    newRoom.style.margin = "10px 0px";
    newRoom.style.position = "relative";
    fecha.classList.add("form-control");
    fecha.classList.add("fecha");
    fecha.setAttribute("name", "fechas[]");
    fecha.setAttribute("id", "fecha" + inputCount);
    fecha.setAttribute("type", "date");
    fecha.style.marginRight = "20px";
    habitaciones.appendChild(newRoom);
    let saltoLine = document.createElement("br");
    newRoom.appendChild(fecha);
    
    let remove = document.createElement("button");
    
    remove.style.position = "absolute";
    remove.style.right = "10px";
    remove.style.top = "10px";
    remove.style.width = "30px";
    remove.style.fontSize = "20px";
    remove.classList.add("btn-danger");
    remove.classList.add("btn");
    remove.classList.add("remove-bedroom");
    remove.innerHTML = "x";

    habitaciones_json.map((val, index)=>{
      let span_fecha = document.createElement("span");
      
      span_fecha.style.marginRight = "10px";
      let input_hab = document.createElement("input");
      let label_hab = document.createElement("label");
      label_hab.innerHTML = val.room_name + " (Personas: <strong>" + val.people + "</strong> / Precio x Persona: <strong>" + val.price + "</strong>)";
      input_hab.setAttribute("type","checkbox");
      input_hab.setAttribute("name","habSelect" + `[${inputCount}][${val.id}]`);
      input_hab.classList.add("form-control");
      let saltoLinea = document.createElement("br");
      let saltoLinea2 = document.createElement("br");
      let disponibilidadSi = document.createElement("input");
      let disponibilidadNo = document.createElement("input");
      let txtDisponibilidad = document.createTextNode("Disponible: ");
      let txtDisponibilidadSi = document.createTextNode(" Si ");
      let txtDisponibilidadNo = document.createTextNode(" No ");
      disponibilidadSi.setAttribute("type", "radio");
      disponibilidadSi.setAttribute("name", "habDisponible" + `[${inputCount}][${val.id}]`);
      disponibilidadSi.setAttribute("type", "radio");
      disponibilidadSi.value = "1";
      disponibilidadSi.checked = true;
      disponibilidadNo.setAttribute("type", "radio");
      disponibilidadNo.value = "0";
      disponibilidadNo.setAttribute("name", "habDisponible" + `[${inputCount}][${val.id}]`);
      span_fecha.appendChild(saltoLinea);
      span_fecha.appendChild(input_hab);
      
      
      
      span_fecha.appendChild(label_hab);
      span_fecha.appendChild(saltoLinea2);
      span_fecha.appendChild(txtDisponibilidad);
      
      span_fecha.appendChild(txtDisponibilidadSi);
      span_fecha.appendChild(disponibilidadSi);
      span_fecha.appendChild(txtDisponibilidadNo);
      span_fecha.appendChild(disponibilidadNo);
      
      newRoom.appendChild(span_fecha);
      
    });
    newRoom.appendChild(remove);
  
    inputCount++;
  	
});


habitaciones.addEventListener("click", function(e) {
  if (e.target.classList.contains("remove-bedroom")) {
    e.target.parentElement.remove();
  }
});


const deletes = document.querySelectorAll('a.delete-id');

deletes.forEach((enlace) => {
  enlace.addEventListener('click', function(event) {
    const deleteId = enlace.getAttribute('data-id');
    /*if (deleteId === 'valor-esperado') {
      window.location = enlace.getAttribute('href');
    } else {
      event.preventDefault();
    }
    */
    
    if (confirm("¿Estás seguro de que deseas realizar esta acción?")) {
    	var xhr = new XMLHttpRequest();
		xhr.open("POST", ajaxurl, true);

		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function() {
		    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
		        alert("Se ha eliminado correctamente");
		        
		    }
		};
		xhr.send(`action=delete_destination&id=${deleteId}`);
		
    }
    else {
    	event.preventDefault();
    }
    
  });
});

