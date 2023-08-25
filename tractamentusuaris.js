const enllaçosCorreu = document.querySelectorAll('.mail-link');
const dialeg = document.getElementById('enviarMail');
const botoTancarDialeg = document.getElementById('tancarMail');


enllaçosCorreu.forEach(enllaç => {
    enllaç.addEventListener('click', e => {
        e.preventDefault();

        let fila = enllaç.closest('tr'); // Obtindre la fila pare de l'enllaç
        let id = fila.querySelector('td:nth-child(1)').textContent;
        let nom = fila.querySelector('td:nth-child(2)').textContent;
        let cognoms = fila.querySelector('td:nth-child(3)').textContent;
        let correu = fila.querySelector('td:nth-child(4)').textContent;
        let curs = fila.querySelector('td:nth-child(5)').textContent;
        let certificacions = fila.querySelector('td:nth-child(6)').textContent;
        let credencialsEnviades = fila.querySelector('td:nth-child(8)').textContent;
        let dataInscripcio = fila.querySelector('td:nth-child(9)').textContent;
        let comentaris = fila.querySelector('td:nth-child(10) textarea').value;
        let dataExamen = fila.querySelector('td:nth-child(11)').textContent;
        // Asignar valores a los campos ocultos
        document.getElementById('id').value = id;
        document.getElementById('nom').value = nom;
        document.getElementById('cognoms').value = cognoms;
        document.getElementById('correu').value = correu;
        document.getElementById('curs').value = curs;
        document.getElementById('certificacions').value = certificacions;
        document.getElementById('credencialsEnviades').value = credencialsEnviades;
        document.getElementById('dataInscripcio').value = dataInscripcio;
        document.getElementById('comentaris').value = comentaris;
        document.getElementById('dataExamen').value = dataExamen;
        // Obtindre altres dades de la fila segons sigui necessari

        obrirDialegCorreu();

        // Afegir un esdeveniment al formulari per enviar les dades
        const formulari = dialeg.querySelector('form');
        formulari.addEventListener('submit', async () => {
            // Afegir lògica per enviar les dades a controlador.php
            const dadesFormulari = new FormData();
            dadesFormulari.append('id', id);
            dadesFormulari.append('nom', nom);
            dadesFormulari.append('cognoms', cognoms);
            dadesFormulari.append('correu', correu);
            dadesFormulari.append('curs', curs);
            dadesFormulari.append('certificacions', certificacions);
            dadesFormulari.append('credencialsEnviades', credencialsEnviades);
            dadesFormulari.append('dataInscripcio', dataInscripcio);
            dadesFormulari.append('comentaris', comentaris);
            dadesFormulari.append('dataExamen', dataExamen);

            try {
                const resposta = await fetch('controlador.php', {
                    method: 'POST',
                    body: dadesFormulari
                });

                // Gestionar la resposta del servidor si és necessari
                console.log(resposta);

                // Mostrar la notificación
                var notification = document.getElementById('notification');
                var message = document.getElementById('notification-message');
                message.textContent = 'Correu enviat!'; // Cambiar el mensaje
                notification.style.display = 'block';

                // Ocultar la notificación después de 3 segundos
                setTimeout(function() {
                    notification.style.display = 'none';
                    location.reload(); // Actualizar la página
                }, 7000); // 1000 milisegundos = 1 segundo
            } catch (error) {
                // Gestionar errores de la solicitud
                console.error(error);
            }
        });
    });
});




function obrirDialegCorreu() {
    dialeg.showModal();
}

function guardarComentari(botoGuardar) {
    let fila = botoGuardar.closest('tr');
    let comentarisInput = fila.querySelector('.comentaris');
    let comentaris = comentarisInput.value;
    let id = fila.querySelector('td:nth-child(1)').innerText;

    // Crear objeto FormData para enviar los datos por POST
    let formData = new FormData();
    formData.append('id', id);
    formData.append('comentaris', comentaris);

    fetch('guardarComentari.php', {
        method: 'POST',
        body: formData
    }).then(resposta => {
        // Gestionar la resposta del servidor si és necessari
// Mostrar la notificación de "Guardado"
        let notification = document.getElementById('notification');
        let message = document.getElementById('notification-message');
        message.textContent = 'Guardat!'; // Cambiar el mensaje
        notification.style.display = 'block';

        // Ocultar la notificación después de 3 segundos
        setTimeout(function() {
            notification.style.display = 'none';
            window.location.reload(); // Recargar la página
        }, 500); // 3000 milisegundos = 3 segundos
    }).catch(error => {
        // Gestionar errors de la sol·licitud
        console.error(error);
    });
}
function eliminarUsuari(botoEliminar) {
    let fila = botoEliminar.closest('tr');
    let id = fila.querySelector('td:nth-child(1)').innerText;
    let justificant = fila.querySelector('td:nth-child(7) a').getAttribute('download');

    // Mostrar ventana de confirmación
    if (window.confirm("Estas segur d'eliminar aquest usuari?")) {
        // Crear objeto FormData para enviar los datos por POST
        let formData = new FormData();
        formData.append('id', id);
        formData.append('justificant', justificant);

        fetch('eliminarUsuari.php', {
            method: 'POST',
            body: formData
        }).then(resposta => {
            let notification = document.getElementById('notification');
            let message = document.getElementById('notification-message');
            notification.style.backgroundColor = '#ff3333';
            message.textContent = 'Usuari Eliminat!'; // Cambiar el mensaje
            notification.style.display = 'block';
            // Ocultar la notificación después de 3 segundos
            setTimeout(function() {
                notification.style.display = 'none';
                window.location.reload(); // Recargar la página
            }, 2000); // 2000 milisegundos = 2 segundos
        }).catch(error => {
            // Gestionar errores de la solicitud
            console.error(error);
        });
    }
}
    function tancarDialegCorreu() {
    dialeg.close();
}

// Esperar a que se cargue el contenido de la página
document.addEventListener('DOMContentLoaded', function () {
    // Obtener la entrada de búsqueda y la tabla
    const inputBusqueda = document.getElementById('inputBusqueda');
    const tabla = document.querySelector('table');

    // Agregar un evento de escucha al campo de búsqueda
    inputBusqueda.addEventListener('input', function () {
        const valorBusqueda = inputBusqueda.value.toLowerCase();

        // Iterar a través de las filas de la tabla y mostrar u ocultar según la búsqueda
        const filas = tabla.querySelectorAll('tbody tr');
        filas.forEach(function (fila) {
            const contenidoFila = fila.innerText.toLowerCase();
            if (contenidoFila.includes(valorBusqueda)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    // Variables globales para paginación
    const tableRows = document.querySelectorAll('.table-container tbody tr');
    const itemsPerPage = 10;
    let currentPage = 1;
    let filteredRows = tableRows;
    let totalPages = Math.ceil(filteredRows.length / itemsPerPage); // Calcula el total de páginas inicial


    // Función para mostrar los elementos en la página actual
    function showPage(page) {
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        filteredRows.forEach((row, index) => {
            if (index >= startIndex && index < endIndex) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Función para actualizar la paginación y mostrar la página actual
    function updatePagination() {
        totalPages = Math.ceil(filteredRows.length / itemsPerPage); // Recalcula el total de páginas
        showPage(currentPage);
        document.getElementById('currentPage').textContent = currentPage;
        document.getElementById('totalPages').textContent = totalPages; // Actualiza el valor de totalPages en el HTML
    }
    // Manejar el evento de entrada en el buscador
    document.getElementById('inputBusqueda').addEventListener('input', event => {
        const searchText = event.target.value.trim();
        if (searchText !== '') {
            filterResults(searchText);
        } else {
            // Si el buscador está vacío, mostrar todos los resultados
            filteredRows = tableRows;
            updatePagination();
        }
    });

    // Evento para ir a la página anterior
    document.getElementById('prevPageBtn').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    });

// Evento para ir a la página siguiente
    document.getElementById('nextPageBtn').addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    });

    // Función para filtrar los resultados por búsqueda
    function filterResults(searchText) {
        filteredRows = [...tableRows].filter(row =>
            Array.from(row.cells).some(cell =>
                cell.textContent.toLowerCase().includes(searchText.toLowerCase())
            )
        );

        // Resetear la página actual cuando se realiza una búsqueda
        currentPage = 1;
        updatePagination();
    }

    // Manejar el evento de entrada en el buscador
    document.getElementById('inputBusqueda').addEventListener('input', event => {
        const searchText = event.target.value.trim();
        if (searchText !== '') {
            filterResults(searchText);
        } else {
            // Si el buscador está vacío, mostrar todos los resultados
            filteredRows = tableRows;
            updatePagination();
        }
    });

    // Mostrar la primera página al cargar la página
    updatePagination();
});