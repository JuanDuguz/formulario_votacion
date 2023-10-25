<?php
// Establece los datos de conexión a la base de datos
$servidor = "localhost";
$baseDeDatos = "votacion";
$usuario = "root";
$contrasenia = "";

try {
    // Conéctate a la base de datos usando PDO
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos", $usuario, $contrasenia);

    // Consulta SQL para obtener todas las regiones
    $sql = "SELECT id, nombre FROM region";
    $stmt = $conexion->query($sql);
    $regiones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta SQL para obtener todas las comunas
    $sql = "SELECT id, nombre, id_region FROM comuna";
    $stmt = $conexion->query($sql);
    $comunas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //candidatos
    $sql = "SELECT id, nombre FROM candidato";
    $stmt = $conexion->query($sql);
    $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Arma un arreglo que contiene las regiones y las comunas
    $datos = [
        "regiones" => $regiones,
        "comunas" => $comunas,
        "candidatos" => $candidatos
    ];


    // Devuelve los datos en formato JSON
    header("Content-Type: application/json");
    echo json_encode($datos);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>
