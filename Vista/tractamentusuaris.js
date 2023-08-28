//Constants que utilitzo a tot el codi per obtenir les dades generades
const enllaçosCorreu = document.querySelectorAll('.mail-link');
const dialeg = document.getElementById('enviarMail');
const botoTancarDialeg = document.getElementById('tancarMail');

// Afegir un esdeveniment a cada boto de correu
enllaçosCorreu.forEach(enllaç => {
    enllaç.addEventListener('click', e => {
        e.preventDefault();

        // Obtindre la fila pare de l'enllaç
        let fila = enllaç.closest('tr'); // Obtindre la fila pare de l'enllaç
        // Obtindre dades de les cel·les de la fila
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
        // Assignar els valors als camps ocults del diàleg
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

        obrirDialegCorreu();

        // Afegir un esdeveniment al formulari per enviar les dades
        let formulari = dialeg.querySelector('form');
        formulari.addEventListener('submit', async () => {
            // Afegir els camps del dialog per enviar les dades a controlador.php
            let dadesFormulari = new FormData();
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
                //Una vegada tinc totes les dades faig un fetch esperant la resposta del controlador.php
                let resposta = await fetch('Controlador/controlador.php', {
                    method: 'POST',
                    body: dadesFormulari
                });

                // Gestionar la resposta això ho utilitzo per depurar
                //console.log(resposta);

                // Mostro la notificació
                let notification = document.getElementById('notification');
                let message = document.getElementById('notification-message');
                message.textContent = 'Correu enviat!'; // Cambio el missatge
                notification.style.display = 'block';

                // Oculto la notificació i faig un reload de la pagina per aplicar els canvis
                setTimeout(function() {
                    notification.style.display = 'none';
                    location.reload();
                }, 7000); // 1000 milisegons = 1 sec
            } catch (error) {
                // En cas de error ho mostra per consola
                console.error(error);
            }
        });
    });
});




// Funció per a guarda el comentari
function guardarComentari(botoGuardar) {
    // Obtindre la fila pare del botó de guardar
    let fila = botoGuardar.closest('tr');
    // Obtindre l'entrada de comentaris
    let comentarisInput = fila.querySelector('.comentaris');
    let comentaris = comentarisInput.value;
    // Obtindre l'identificador de la fila
    let id = fila.querySelector('td:nth-child(1)').innerText;

    // Crear objecte FormData per enviar les dades per POST
    let formData = new FormData();
    formData.append('id', id);
    formData.append('comentaris', comentaris);

    // Fer una sol·licitud fetch per a guardar els comentaris
    fetch('Controlador/guardarComentari.php', {
        method: 'POST',
        body: formData
    }).then(resposta => {
        // Gestionar la resposta del servidor si és necessari
        // Mostrar la notificació de "Guardat"
        let notification = document.getElementById('notification');
        let message = document.getElementById('notification-message');
        message.textContent = 'Guardat!'; // Canviar el missatge
        notification.style.display = 'block';

        // Ocultar la notificació després de 3 segons i recarregar la pàgina
        setTimeout(function() {
            notification.style.display = 'none';
            window.location.reload(); // Recarregar la pàgina
        }, 500); // 500 mil·lisegons
    }).catch(error => {
        // Gestionar errors de la sol·licitud
        console.error(error);
    });
}

// Funció per a eliminar un usuari
function eliminarUsuari(botoEliminar) {
    // Obtindre la fila pare del botó d'eliminar
    let fila = botoEliminar.closest('tr');
    // Obtindre l'identificador i el justificant de la fila
    let id = fila.querySelector('td:nth-child(1)').innerText;
    let justificant = fila.querySelector('td:nth-child(7) a').getAttribute('download');

    // Mostrar finestra de confirmació
    if (window.confirm("Estàs segur d'eliminar aquest usuari?")) {
        // Crear objecte FormData per enviar les dades per POST
        let formData = new FormData();
        formData.append('id', id);
        formData.append('justificant', justificant);

        // Fer una sol·licitud fetch per a eliminar l'usuari
        fetch('Controlador/eliminarUsuari.php', {
            method: 'POST',
            body: formData
        }).then(resposta => {
            let notification = document.getElementById('notification');
            let message = document.getElementById('notification-message');
            notification.style.backgroundColor = '#ff3333';
            message.textContent = 'Usuari Eliminat!'; // Canviar el missatge
            notification.style.display = 'block';

            // Ocultar la notificació després de 2 segons i recarregar la pàgina
            setTimeout(function() {
                notification.style.display = 'none';
                window.location.reload(); // Recarregar la pàgina
            }, 2000); // 2000 mil·lisegons
        }).catch(error => {
            // Gestionar errors de la sol·licitud
            console.error(error);
        });
    }
}

// Funció per tancar el diàleg de correu
function tancarDialegCorreu() {
    dialeg.close();
}

// Esperar a que el contingut de la pàgina es carregui
document.addEventListener('DOMContentLoaded', function () {
    // Obtindre l'entrada de cerca i la taula
    const inputBusqueda = document.getElementById('inputBusqueda');
    const tabla = document.querySelector('table');

    // Afegir un esdeveniment d'escolta al camp de cerca
    inputBusqueda.addEventListener('input', function () {
        //passo tot a minuscules
        const valorBusqueda = inputBusqueda.value.toLowerCase();

        // Iterar a través de les files de la taula i mostrar o amagar segons la cerca
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

    // Variables globals per a paginació
    const tableRows = document.querySelectorAll('.table-container tbody tr');
    const itemsPerPage = 10;
    let currentPage = 1;
    let filteredRows = tableRows;
    let totalPages = Math.ceil(filteredRows.length / itemsPerPage); // Calcula el total de páginas inicial


    // Funció per a mostrar els elements a la pàgina actual
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

    // Funció per a actualitzar la paginació i mostrar la pàgina actual
    function updatePagination() {
        totalPages = Math.ceil(filteredRows.length / itemsPerPage); // Recalcula el total de págines
        showPage(currentPage);
        document.getElementById('currentPage').textContent = currentPage;
        document.getElementById('totalPages').textContent = totalPages; // Actualiza el valor de totalPages
    }
    // Tracto l'esdeveniment d'entrada al cercador
    document.getElementById('inputBusqueda').addEventListener('input', event => {
        //Trec els espais buits
        const searchText = event.target.value.trim();
        if (searchText !== '') {
            filterResults(searchText);
        } else {
            // Si el cercador està buit, mostrar tots els resultats
            filteredRows = tableRows;
            updatePagination();
        }
    });

    // Esdeveniment per anar a la pàgina anterior (boto)
    document.getElementById('prevPageBtn').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    });

    // Esdeveniment per anar a la pàgina següent (boto)
    document.getElementById('nextPageBtn').addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    });

// Funció per filtrar els resultats segons el text de cerca
    function filterResults(searchText) {
        // Filtra les files de la taula segons el text de cerca CREA UNA COPIA amb els ...
        // Faig una copia per que si no el filtra s'aplicava a les files
        filteredRows = [...tableRows].filter(row =>
            // Comprova si almenys una cel·la de la fila conté el text de cerca (en minúscules)
            Array.from(row.cells).some(cell =>
                cell.textContent.toLowerCase().includes(searchText.toLowerCase())
            )
        );

        // Reiniciar la pàgina actual quan es realitza una cerca
        currentPage = 1;
        updatePagination(); // Actualitza la paginació amb els nous resultats
    }


    // Mostrar la primera pàgina en carregar la pàgina
    updatePagination();
});