const deletesHabitacion = document.querySelectorAll('a.delete-hab-id');

deletesHabitacion.forEach((enlace) => {
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
		xhr.send(`action=delete_habitacion&id=${deleteId}`);
		
    }
    else {
    	event.preventDefault();
    }
    
  });
});