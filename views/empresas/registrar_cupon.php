<?php
include '../../db.php';

// Recibe los datos del formulario
$idEmpresa = $_POST['idEmpresa'];
$titulo = $_POST['titulo'];
$precio_regular = $_POST['precio_regular'];
$precio_oferta = $_POST['precio_oferta'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$fecha_limite_canje = $_POST['fecha_limite_canje'];
$cantidad_cupones = $_POST['cantidad_cupones'];
$descripcion = $_POST['descripcion'];
$estado = $_POST['estado'];

try {
    $conexion = Conexion::obtenerInstancia()->getConexion();

    // Verifica si ya existe una oferta con el mismo título y empresa
    $query = "SELECT COUNT(*) FROM Ofertas WHERE titulo = :titulo AND idEmpresa = :idEmpresa";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':titulo', $titulo);
    $statement->bindParam(':idEmpresa', $idEmpresa);
    $statement->execute();
    $count = $statement->fetchColumn();

    if ($count > 0) {
        // Si ya existe una oferta con el mismo título y empresa, muestra un mensaje de error y redirige al registro
        echo "<script>alert('Ya existe una oferta con este título para esta empresa.');</script>";
        echo "<script>window.location = 'agregar_cupon.php';</script>";
    } else {
        // Si no existe una oferta con el mismo título y empresa, procede con la inserción
        $query = "INSERT INTO Ofertas (idEmpresa, titulo, precio_regular, precio_oferta, fecha_inicio, fecha_fin, fecha_limite_canje, cantidad_cupones, descripcion, estado) 
                  VALUES (:idEmpresa, :titulo, :precio_regular, :precio_oferta, :fecha_inicio, :fecha_fin, :fecha_limite_canje, :cantidad_cupones, :descripcion, :estado)";
        $statement = $conexion->prepare($query);

        // Bind de parámetros
        $statement->bindParam(':idEmpresa', $idEmpresa);
        $statement->bindParam(':titulo', $titulo);
        $statement->bindParam(':precio_regular', $precio_regular);
        $statement->bindParam(':precio_oferta', $precio_oferta);
        $statement->bindParam(':fecha_inicio', $fecha_inicio);
        $statement->bindParam(':fecha_fin', $fecha_fin);
        $statement->bindParam(':fecha_limite_canje', $fecha_limite_canje);
        $statement->bindParam(':cantidad_cupones', $cantidad_cupones);
        $statement->bindParam(':descripcion', $descripcion);
        $statement->bindParam(':estado', $estado);

        // Ejecuta la consulta
        $statement->execute();

        // Muestra un mensaje emergente con el mensaje de éxito
        echo "<script>alert('Cupón registrado correctamente.');</script>";

        // Redirige al usuario a la página de inicio después de que se cierre el mensaje emergente
        echo "<script>window.location = '../../index.php';</script>";
    }
} catch (Exception $e) {
    echo "<script>alert('Error al registrar el cupón.');</script>";

    // Redirige al usuario a la página de registro después de que se cierre el mensaje emergente
    echo "<script>window.location = 'agregar_cupon.php';</script>";
}
?>
