<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Votación</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <script src="tu_archivo.js"></script>
</head>

<body>
    <h1>Formulario de Votación</h2>
    <form id="votacionForm" action="procesar_votacion.php" method="post" onsubmit="return validarFormulario()">
        <label for="nombre">Nombre y Apellido:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="alias">Alias (más de 5 caracteres, letras y números):</label>
        <input type="text" id="alias" name="alias" pattern="^[a-zA-Z0-9]{6,}$" required><br><br>

        <label for="rut">RUT (sin puntos con guión):</label>
        <input type="text" id="rut" name="rut" pattern="\d{1,8}-[\dkK]" title="Ingresa un RUT válido. Ejemplo: 12345678-9" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="region">Región:</label>
        <select id="region" name="region" required>
            <option value="">Selecciona una región</option>
        </select><br><br>

        <label for="comuna">Comuna:</label>
        <select id="comuna" name="comuna" required>
            <option value="">Selecciona una comuna</option>
        </select><br><br>

        <label for="candidato">Candidato:</label>
        <select id="candidato" name="candidato">
            <option value="">Selecciona un candidato</option>
            <?php foreach ($candidatos as $candidato): ?>
                <option value="<?php echo $candidato['id']; ?>"><?php echo $candidato['nombre']; ?></option>
            <?php endforeach; ?>
        </select>

        <p>¿Cómo se enteró de nosotros? (Selecciona al menos dos opciones)</p>
        <input type="checkbox" name="como_entero[]" value="internet" id="internet">
        <label class="checkbox-label" for="internet">Internet</label>

        <input type="checkbox" name="como_entero[]" value="tv" id="tv">
        <label class="checkbox-label" for="tv">TV</label>

        <input type="checkbox" name="como_entero[]" value="radio" id="radio">
        <label class="checkbox-label" for="radio">Radio</label>

        <input type="checkbox" name="como_entero[]" value="amigo" id="amigo">
        <label class="checkbox-label" for="amigo">Un amigo</label>

        <input type="checkbox" name="como_entero[]" value="otro" id="otro">
        <label class="checkbox-label" for="otro">Otro</label><br><br>


        <input type="submit" value="Enviar">
    </form>
    
</body>
</html>
