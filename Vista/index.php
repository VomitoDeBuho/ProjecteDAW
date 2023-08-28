<!DOCTYPE html>
<html>
<head>
    <title>Taula d'usuaris</title>
    <link rel="stylesheet" type="text/css" href="Vista/styles.css">

</head>
<body>
<div class="container">
    <div class="titol">
        <h1>Administració Certificacions MOS</h1>
    </div>
    <!-- Requerir el controlador PHP -->
    <?php require 'Controlador/controlador.php'; ?>
    <!-- Verificar si l'usuari està autenticat -->
    <?php if (!isset($_SESSION['google_access_token'])): ?>
        <!-- Botó d'inici de sessió amb Google -->
        <div class="login-container">
            <a href="<?= $client->createAuthUrl() ?>" class="google-login-button">Iniciar sessió amb Google</a>
        </div>
    <?php else: ?>
        <!-- Botó de tancament de sessió -->
        <div class="logout-button-container">
            <a href="Controlador/logout.php" class="logout-button">Tancar sessió</a>
        </div>
    <?php endif; ?>
    <!-- Comprovar si hi ha alumnes registrats -->
    <?php if (empty($alumnes)): ?>
        <p class="no-records">No hi han alumnes registrats</p>
    <?php else: ?>
        <div class="table-container">
            <!-- Buscador i icona de cerca -->
            <input type="text" id="inputBusqueda" class="minimal-input" placeholder="Cerca">
            <img class="search-icon" src="Vista/lupa.svg" alt="Icona de buscar" width="30" height="30">

            <div id="notification" class="notification"><span id="notification-message" class="notification-message"></span></div>
            <!-- Taula d'alumnes -->
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Cognoms</th>
                    <th>Correu electrònic</th>
                    <th>Curs</th>
                    <th>Certificacions</th>
                    <th>Justificant</th>
                    <th>Credencials Enviades</th>
                    <th>Data d'inscripció</th>
                    <th>Comentaris<img class="edit-icon" src="Vista/edit.svg" alt="Icona de editar" width="30" height="30"></th>
                    <th>Data d'examen</th>
                    <th>Usuari</th>
                    <th>Contrasenya</th>
                    <th>Codi Practice Test</th>
                    <th colspan="3" class="opcions">Opcions</th>
                </tr>
                </thead>
                <tbody>
                <!-- Dades d'alumnes -->
                <?php foreach ($alumnes as $alumne): ?>
                    <tr>
                        <td><?= $alumne['id'] ?? '' ?></td>
                        <td><?= $alumne['nom'] ?? '' ?></td>
                        <td><?= $alumne['cognoms'] ?? '' ?></td>
                        <td><?= $alumne['correu_electronic'] ?? '' ?></td>
                        <td><?= $alumne['curs'] ?? '' ?></td>
                        <td><?= $alumne['certificacions'] ?? '' ?></td>
                        <td>
                            <?php
                            $justificant = explode(', ', $alumne['justificant']);
                            echo '<a href="' .'usuari/Controlador/'.$justificant[3] . '" download="' . $justificant[0] . '">Descarregar arxiu</a>';
                            ?>
                        </td>
                        <td><?= $alumne['credencials_enviades'] == 1 ? 'Si' : 'No' ?? '' ?></td>
                        <td><?= $alumne['data_inscripcio'] ?? '' ?></td>
                        <td><?= '<textarea class="comentaris" rows="1" cols="20" placeholder="">' . ($alumne['comentaris'] ?? '') . '</textarea>' ?></td>
                        <td><?= $alumne['dataExamen'] ?? '' ?></td>
                        <td><?= $alumne['usuari'] ?? '' ?></td>
                        <td><?= $alumne['contrasenya'] ?? '' ?></td>
                        <td><?= $alumne['codiPractice'] ?? '' ?></td>
                        <td><a href="#" class="mail-link" onclick="obrirDialegCorreu();"><img src="Vista/mail.svg" alt="Icona de correu" width="20" height="20"></a></td>
                        <td><a href="#" class="save-link" onclick="guardarComentari(this);"><img src="Vista/save.svg" alt="Icona de guardar" width="20" height="20"></a></td>
                        <td><a href="#" class="delete-link" onclick="eliminarUsuari(this);"><img src="Vista/delete.svg" alt="Icona de eliminar" width="20" height="20"></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <!-- Paginació -->
    <div class="pagination-container">
        <button id="prevPageBtn">Anterior</button>
        <span>Pàgina <span id="currentPage">1</span> de <span id="totalPages">1</span></span>
        <button id="nextPageBtn">Següent</button>
    </div>

</div>
<!-- Dialeg ocult per despres omplenar les dades amb js i enviarles per POST al controlador -->
<dialog id="enviarMail" class="minimal-dialog">
    <form action="Controlador/controlador.php" method="post">
        <input type="hidden" id="id" name="id">
        <input type="hidden" id="nom" name="nom">
        <input type="hidden" id="cognoms" name="cognoms">
        <input type="hidden" id="correu" name="correu">
        <input type="hidden" id="curs" name="curs">
        <input type="hidden" id="certificacions" name="certificacions">
        <input type="hidden" id="credencialsEnviades" name="credencialsEnviades">
        <input type="hidden" id="dataInscripcio" name="dataInscripcio">
        <input type="hidden" id="comentaris" name="comentaris">
        <input type="hidden" id="dataExamen" name="dataExamen">
        <div class="form-group">
            <label for="usuari">Usuari:</label>
            <input type="text" id="usuari" name="usuari" required>
        </div>

        <div class="form-group">
            <label for="contrasenya">Contrasenya:</label>
            <input type="text" id="contrasenya" name="contrasenya" required>
        </div>

        <div class="form-group">
            <label for="CodiPracticeTest">Codi Practice Test:</label>
            <input type="text" id="CodiPracticeTest" name="CodiPracticeTest" required>
        </div>

        <div class="form-group">
            <label for="dataExamen">Dia i hora de l'examen:</label>
            <input type="datetime-local" id="dataExamen" name="dataExamen" required>
        </div>

        <div class="button-container">
            <input type="submit" value="Enviar" class="green-button">
            <button id="tancarMail" onclick="tancarDialegCorreu()" class="green-button">Cerrar</button>
        </div>
    </form>
</dialog>
<!-- Script al final per evitar dades asincrones -->
<script src="Vista/tractamentusuaris.js"></script>
</body>
</html>
