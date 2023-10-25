<?php
$servidor = "localhost";
$baseDeDatos = "votacion";
$usuario = "root";
$contrasenia = "";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos", $usuario, $contrasenia);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recupera los datos del formulario
    $nombre = $_POST['nombre'];
    $alias = $_POST['alias'];
    $rut = $_POST['rut'];
    $email = $_POST['email'];
    $region = $_POST['region'];
    $comuna = $_POST['comuna'];
    $candidato = $_POST['candidato'];
    $como_entero = $_POST['como_entero'];
    $comoen = implode(', ', $como_entero); // Combina las opciones en una cadena

    // Inicia una transacción
    $conexion->beginTransaction();

    // Inserta los datos del usuario en la tabla `usuario`
    $sql = "INSERT INTO usuario (nombre, alias, rut, email, id_region, id_comuna, comoen) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$nombre, $alias, $rut, $email, $region, $comuna, $comoen]);

    // Obtén el ID del usuario insertado
    $usuarioId = $conexion->lastInsertId();

    // Asegúrate de que tienes el `id_usuario` antes de insertar votos
    if (isset($usuarioId)) {
        $candidatoIDs = explode(', ', $candidato);

        foreach ($candidatoIDs as $opcion) {
            $sql = "INSERT INTO votos (id_usuario, id_candidato) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$usuarioId, $opcion]);
        }

    } else {
        // Manejar el caso en el que no se pudo obtener el `id_usuario`
        echo "Hubo un problema al obtener el ID de usuario.";
        // Revertir la transacción si algo sale mal
        $conexion->rollBack();
    }

    // Confirma la transacción
    $conexion->commit();

    if ($stmt->rowCount() > 0) {
        echo "Los datos se han guardado exitosamente. Su voto ha sido registrado.";
        echo '<br><a href="index.php">Volver al formulario de votación</a>';
    } else {
        echo "Hubo un problema al guardar los datos. Por favor, inténtelo de nuevo más tarde.";
        echo '<br><a href="index.php">Volver al formulario de votación</a>';
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit; // Detener la ejecución si no se puede conectar a la base de datos.
} finally {
    $conexion = null; // Cierra la conexión a la base de datos
}
?>
