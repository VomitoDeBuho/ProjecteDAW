function esOpcioValida(valor, opcionsValidas) {
    return opcionsValidas.includes(valor);
}

function sanitizeString(str) {
    return str.replace(/[^\w\sáéíóúüñÁÉÍÓÚÜÑ%]/gi, '');
}

function validarCorreu(correu) {
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(correu);
}

function sanitizeEmail(email) {
    // Elimina espacios en blanco al principio y al final del correo
    var trimmedEmail = email.trim();
    // Remueve caracteres no permitidos excepto '@', '.', '-' y '_'
    var sanitizedEmail = trimmedEmail.replace(/[^\w\s.@-]/gi, '');
    return sanitizedEmail;
}

function validarFormulari() {
    var errorMessages = document.getElementById('error-messages');
    errorMessages.innerHTML = '';

    var nom = sanitizeString(document.getElementById('nom').value);
    var cognoms = sanitizeString(document.getElementById('cognoms').value);
    var cursSelect = document.getElementById('curs');
    var curs = sanitizeString(cursSelect.value);
    var justificantInput = document.getElementById('justificant');
    var justificant = justificantInput.value;
    var correu = sanitizeEmail(document.getElementById('correu').value);
    var checkboxes = document.querySelectorAll('input[name="certificacions[]"]');
    var isChecked = false;
    var hasError = false;

    if (nom === '') {
        hasError = true;
        errorMessages.innerHTML += 'El camp Nom és obligatori.<br>';
    } else if (nom.length > 50) {
        hasError = true;
        errorMessages.innerHTML += 'El camp Nom ha de tenir menys de 50 caràcters.<br>';
    }

    // Validación de longitud y no vacío para 'Cognoms'
    if (cognoms === '') {
        hasError = true;
        errorMessages.innerHTML += 'El camp Cognoms és obligatori.<br>';
    } else if (cognoms.length > 50) {
        hasError = true;
        errorMessages.innerHTML += 'El camp Cognoms ha de tenir menys de 50 caràcters.<br>';
    }

    for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                isChecked = true;
                if (!esOpcioValida(checkboxes[i].value, ["Word", "Excel", "Access", "Outlook", "Powerpoint"])) {
                    hasError = true;
                    errorMessages.innerHTML += 'Certificació no vàlida: ' + checkboxes[i].value + '<br>';
                }
            }
        }

    if (!isChecked) {
        hasError = true;
        errorMessages.innerHTML += "S'ha de marcar com a mínim una certificació.<br>";
    }

    var opcionsValides = ["SMX1A", "SMX1B", "SMX1C", "SMX1D", "SMX1E", "SMX2A", "SMX2B", "ASIX1", "ASIX2", "DAW1", "DAW2", "altres"];
    if (curs === '' || !esOpcioValida(curs, opcionsValides)) {
        hasError = true;
        errorMessages.innerHTML += 'Curs seleccionat no vàlid.<br>';
    }

    if (correu === '' || !validarCorreu(correu)) {
        hasError = true;
        errorMessages.innerHTML += 'Correu electrònic no vàlid.<br>';
    }

    if (justificant === '') {
        hasError = true;
        errorMessages.innerHTML += "Has d'adjuntar un Justificant de pagament (PDF).<br>";
    } else {
        var fileExtension = justificant.split('.').pop().toLowerCase();
        if (fileExtension !== 'pdf') {
            hasError = true;
            errorMessages.innerHTML += "L'arxiu adjuntat ha de ser un PDF.<br>";
        } else if (justificantInput.files[0].size > 2 * 1024 * 1024) {
            hasError = true;
            errorMessages.innerHTML += "El PDF no pot superar els 2 MB.<br>";
        }
    }
    var response = grecaptcha.getResponse();
    if (response.length === 0) {
        // No se ha completado el reCAPTCHA
        alert('Si us plau, completa el CAPTCHA.');
        hasError = true;
        errorMessages.innerHTML += "El captcha no s'ha completat<br>";
        return false;
    }

    if (!hasError) {
        document.getElementById('formulari').submit();
    }
}
