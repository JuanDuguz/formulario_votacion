// Función para cargar las opciones de Región y Comuna desde cargar_comunas.php
function cargarRegionesYComunas() {
    fetch('cargar_comunas.php') // Realiza una solicitud GET al archivo PHP
    .then(response => response.json()) // Convierte la respuesta a JSON
    .then(data => {
        // Obtiene los datos de Región y Comuna del archivo JSON
        var regiones = data.regiones;
        var comunas = data.comunas;

        // Obtiene los elementos select
        var regionSelect = document.getElementById("region");
        var comunaSelect = document.getElementById("comuna");

        // Llena el combo box de Región
        regiones.forEach(region => {
            var option = document.createElement("option");
            option.value = region.id;
            option.text = region.nombre;
            regionSelect.appendChild(option);
        });

        // Agrega un evento de cambio al combo box de Región
        regionSelect.addEventListener("change", function() {
            var selectedRegionId = regionSelect.value;
            // Borra las opciones anteriores del combo box de Comuna
            comunaSelect.innerHTML = '<option value="">Seleccione una comuna</option>';
            // Filtra las comunas basadas en la región seleccionada
            var comunasFiltradas = comunas.filter(comuna => comuna.id_region == selectedRegionId);
            // Llena el combo box de Comuna con las comunas filtradas
            comunasFiltradas.forEach(comuna => {
                var option = document.createElement("option");
                option.value = comuna.id;
                option.text = comuna.nombre;
                comunaSelect.appendChild(option);
            });
        });
    })
    .catch(error => {
        console.error('Error al cargar regiones y comunas:', error);
    });
}

// Llama a la función para cargar las opciones de Región y Comuna cuando se cargue la página
document.addEventListener("DOMContentLoaded", function() {
    cargarRegionesYComunas();
});


// Función para cargar las opciones del combo box de candidato desde cargar_comunas.php
function cargarCandidatos() {
    fetch('cargar_comunas.php')
        .then(response => response.json())
        .then(data => {
            // Obtiene los datos de candidatos del archivo JSON
            var candidatos = data.candidatos;

            // Obtiene el elemento select de candidato
            var candidatoSelect = document.querySelector('select[name="candidato"]');

            // Borra las opciones anteriores del combo box de candidato
            candidatoSelect.innerHTML = '<option value="">Selecciona un candidato</option>';

            // Llena el combo box de candidato con las opciones de candidatos
            candidatos.forEach(candidato => {
                var option = document.createElement("option");
                option.value = candidato.id;
                option.text = candidato.nombre;
                candidatoSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar candidatos:', error);
        });
}

// Llama a la función para cargar las opciones del combo box de candidato
cargarCandidatos();


function validarRut(rut) {
    // Elimina puntos y guiones y convierte la letra del dígito verificador a minúscula
    rut = rut.replace(/[.-]/g, '').toLowerCase();

    // Separa el Rut del dígito verificador
    var rutNumeros = rut.slice(0, -1);
    var digitoVerificadorIngresado = rut.slice(-1);

    var suma = 0;
    var multiplo = 2;

    // Recorre los dígitos del Rut de derecha a izquierda
    for (var i = rutNumeros.length - 1; i >= 0; i--) {
        suma += parseInt(rutNumeros.charAt(i)) * multiplo;
        multiplo = multiplo === 7 ? 2 : multiplo + 1;
    }

    var digitoCalculado = 11 - (suma % 11);

    // Si el dígito calculado es 11, se convierte a 0; si es 10, se convierte a 'k'
    digitoCalculado = (digitoCalculado === 11) ? 0 : (digitoCalculado === 10) ? 'k' : digitoCalculado.toString();

    return digitoCalculado == digitoVerificadorIngresado;
}


// Función para validar el formulario
function validarFormulario() {
    var nombre = document.getElementById('nombre').value;
    var alias = document.getElementById('alias').value;
    var rut = document.getElementById('rut').value;
    var email = document.getElementById('email').value;
    var region = document.getElementById('region').value;
    var comuna = document.getElementById('comuna').value;
    var candidato = document.querySelector('select[name="candidato"]').value;
    var checkboxes = document.querySelectorAll('input[name="como_entero[]"]:checked');

    // Validación del nombre y apellido (no deben estar en blanco)
    if (nombre.trim() === '') {
        alert('Por favor, ingresa tu nombre y apellido.');
        return false;
    }

    // Validación del alias (más de 5 caracteres, letras y números)
    if (!/^[a-zA-Z0-9]{6,}$/.test(alias)) {
        alert('El alias debe tener al menos 6 caracteres y contener solo letras y números.');
        return false;
    }

    // Validación del RUT (Formato Chile, sin puntos ni guión)
    if (!validarRut(rut)) {
        alert('Ingresa un RUT válido.');
        return false;
    }

    // Validación del correo electrónico (según estándar)
    if (!/^\S+@\S+\.\S+$/.test(email)) {
        alert('Ingresa una dirección de correo electrónico válida.');
        return false;
    }

    // Validación de Región y Comuna (no deben estar en blanco)
    if (region === '' || comuna === '') {
        alert('Por favor, selecciona una región y una comuna.');
        return false;
    }

    // Validación del candidato (debe seleccionar un candidato)
    if (candidato === '') {
        alert('Por favor, selecciona un candidato.');
        return false;
    }

    // Validación de "¿Cómo se enteró de nosotros?" (debe seleccionar al menos dos opciones)
    if (checkboxes.length < 2) {
        alert('Debes seleccionar al menos dos opciones en "¿Cómo se enteró de nosotros?".');
        return false;
    }

    // Si todas las validaciones pasan, el formulario se enviará
    return true;
}