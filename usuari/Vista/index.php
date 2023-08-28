<!DOCTYPE html>
<html>
<head>
    <title>Formulari Inscripció MOS</title>
    <link rel="stylesheet" type="text/css" href="Vista/styles.css">
    <script src="Vista/validacio.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<div class="container" >
    <h1>CERTIFICACIONS MOS</h1>
    <!-- Mostra un missatge d'èxit si la petició s'ha enviat amb èxit -->
    <?php if (isset($_GET['correuEnviat']) && $_GET['correuEnviat'] == 1) { ?>
        <div class="success-message">
            La petició ha sigut correctament enviada! <br> Verifica la teva bústia de correu electrònic
        </div><br>
    <?php } ?>
    <!-- Mostra els missatges d'error si hi ha hagut errors de validació per part del controlador.php a traves d'un GET-->
    <div id="error-messages" class="error-message">
        <?php if (isset($_GET['errors'])) {
            $error_messages = json_decode(urldecode($_GET['errors']), true);
            if (!empty(array_filter($error_messages))) { ?>
                <?php foreach ($error_messages as $error) { ?>
                    <?php echo $error; ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div><br>
    <!-- Formulari d'enviament per POST a Controlador/controlador.php -->
    <form id="formulari" action="Controlador/controlador.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="cognoms">Cognoms:</label>
            <input type="text" id="cognoms" name="cognoms" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="email">Correu electrònic:</label>
            <input type="email" id="correu" name="correu">
        </div>

        <div class="form-group">
            <label for="curs">Curs:</label>
            <select id="curs" name="curs" required>
                <option value=""></option>
                <option value="SMX1A">SMX1A</option>
                <option value="SMX1B">SMX1B</option>
                <option value="SMX1C">SMX1C</option>
                <option value="SMX1D">SMX1D</option>
                <option value="SMX1E">SMX1E</option>
                <option value="SMX2A">SMX2A</option>
                <option value="SMX2B">SMX2B</option>
                <option value="ASIX1">ASIX1</option>
                <option value="ASIX2">ASIX2</option>
                <option value="DAW1">DAW1</option>
                <option value="DAW2">DAW2</option>
                <option value="altres">Altres</option>
            </select>
        </div>

        <div class="form-group">
            <label for="certificacions">Certificacions:</label><br>
            <div class="certificacions-container">
                <div class="certificacions-column">
                    <label for="word">
                        <input type="checkbox" id="word" name="certificacions[]" value="Word">
                        Word
                    </label>

                    <label for="excel">
                        <input type="checkbox" id="excel" name="certificacions[]" value="Excel">
                        Excel
                    </label>

                    <label for="access">
                        <input type="checkbox" id="access" name="certificacions[]" value="Access">
                        Access
                    </label>
                </div>
                <div class="certificacions-column">
                    <label for="outlook">
                        <input type="checkbox" id="outlook" name="certificacions[]" value="Outlook">
                        Outlook
                    </label>

                    <label for="powerpoint">
                        <input type="checkbox" id="powerpoint" name="certificacions[]" value="Powerpoint">
                        Powerpoint
                    </label>
                </div>

            </div>
        </div>
        <div class="form-group">
            <label for="justificant">Justificant de pagament (PDF):</label>
            <label class="file-input-label">
                Selecciona un fitxer PDF
                <input type="file" id="justificant" name="justificant" accept="application/pdf" required>
            </label>
        </div>

        <!-- Botó d'enviament i reCAPTCHA -->
        <div class="form-group" style="display: flex; align-items: center;">
            <button class="submit-btn" type="button" onclick="return validarFormulari()">Enviar</button>
            <div class="g-recaptcha" data-sitekey="6LcB97QnAAAAAChOhqOQrv58_b9zFciFLzbbLV1y" style="margin-left: 10px;"></div>
        </div>
    </form>
</div>
<!-- DIV PER FER EL FONS  https://github.com/VincentGarreau/particles.js/ -->
<div id="particles-js"></div>
<script src="Vista/particles.js" async defer></script>
</body>
</html>
