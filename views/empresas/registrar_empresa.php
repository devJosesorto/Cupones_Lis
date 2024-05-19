<?php
include '../../db.php';

// Recibe los datos del formulario
$nombre = $_POST['nombre'];
$NIT = $_POST['NIT'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$aprobada = false; // La empresa no est� aprobada por defecto
$comision = 0.00; // Comisi�n inicial

try {
    $conexion = Conexion::obtenerInstancia()->getConexion();

    // Verifica si el nombre de usuario, el correo electr�nico o el NIT ya existen
    $query = "SELECT COUNT(*) FROM Empresas WHERE usuario = :usuario OR correo = :correo OR NIT = :NIT";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':usuario', $usuario);
    $statement->bindParam(':correo', $correo);
    $statement->bindParam(':NIT', $NIT);
    $statement->execute();
    $count = $statement->fetchColumn();

    if ($count > 0) {
        // Si el usuario, el correo o el NIT ya existen, muestra un mensaje de error y redirige al registro
        echo "<script>alert('El nombre de usuario, el correo electr�nico o el NIT ya est�n en uso.');</script>";
        echo "<script>window.location = 'registrar.php';</script>";
    } else {
        // Si el usuario, el correo y el NIT no existen, procede con la inserci�n
        $query = "INSERT INTO Empresas (nombre, NIT, direccion, telefono, correo, usuario, contrasena, aprobada, comision) 
                  VALUES (:nombre, :NIT, :direccion, :telefono, :correo, :usuario, :contrasena, :aprobada, :comision)";
        $statement = $conexion->prepare($query);

        // Bind de par�metros
        $statement->bindParam(':nombre', $nombre);
        $statement->bindParam(':NIT', $NIT);
        $statement->bindParam(':direccion', $direccion);
        $statement->bindParam(':telefono', $telefono);
        $statement->bindParam(':correo', $correo);
        $statement->bindParam(':usuario', $usuario);
        $statement->bindParam(':contrasena', $contrasena);
        $statement->bindParam(':aprobada', $aprobada, PDO::PARAM_BOOL);
        $statement->bindParam(':comision', $comision);

        // Ejecuta la consulta
        $statement->execute();

        // Muestra un mensaje emergente con el mensaje de �xito
        echo "<script>alert('Empresa registrada correctamente.');</script>";

        // Redirige al usuario a la p�gina de inicio de sesi�n despu�s de que se cierre el mensaje emergente
        echo "<script>window.location = '../../index.php';</script>";
    }
} catch (Exception $e) {
    echo "<script>alert('Error al registrar la empresa.');</script>";

    // Redirige al usuario a la p�gina de registro despu�s de que se cierre el mensaje emergente
    echo "<script>window.location = 'registrar.php';</script>";
}
?>
