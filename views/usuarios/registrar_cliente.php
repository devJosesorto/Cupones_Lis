<?php
include '../../db.php';

// Recibe los datos del formulario
$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$DUI = $_POST['DUI'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

try {
    $conexion = Conexion::obtenerInstancia()->getConexion();

    // Verifica si el nombre de usuario, el correo electr&oacute;nico o el DUI ya existen
    $query = "SELECT COUNT(*) FROM Clientes WHERE usuario = :usuario OR correo = :correo OR DUI = :DUI";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':usuario', $usuario);
    $statement->bindParam(':correo', $correo);
    $statement->bindParam(':DUI', $DUI);
    $statement->execute();
    $count = $statement->fetchColumn();

    if ($count > 0) {
        // Si el usuario, el correo o el DUI ya existen, muestra un mensaje de error y redirige al registro
        echo "<script>alert('El nombre de usuario, el correo electr&oacute;nico o el DUI ya están en uso.');</script>";
        echo "<script>window.location = 'registrar.php';</script>";
    } else {
        // Si el usuario, el correo y el DUI no existen, procede con la inserci&oacute;n
        $query = "INSERT INTO Clientes (usuario, correo, contrasena, nombre, apellidos, DUI, fecha_nacimiento) 
                  VALUES (:usuario, :correo, :contrasena, :nombre, :apellidos, :DUI, :fecha_nacimiento)";
        $statement = $conexion->prepare($query);

        // Bind de parámetros
        $statement->bindParam(':usuario', $usuario);
        $statement->bindParam(':correo', $correo);
        $statement->bindParam(':contrasena', $contrasena);
        $statement->bindParam(':nombre', $nombre);
        $statement->bindParam(':apellidos', $apellidos);
        $statement->bindParam(':DUI', $DUI);
        $statement->bindParam(':fecha_nacimiento', $fecha_nacimiento);

        // Ejecuta la consulta
        $statement->execute();

        // Muestra un mensaje emergente con el mensaje de &eacute;xito
        echo "<script>alert('Cliente registrado correctamente.');</script>";

        // Redirige al usuario a la página de inicio de sesi&oacute;n despu&eacute;s de que se cierre el mensaje emergente
        echo "<script>window.location = '../../index.php';</script>";
    }
} catch (Exception $e) {
    echo "<script>alert('Error al registrar el cliente.');</script>";

    // Redirige al usuario a la página de registro despu&eacute;s de que se cierre el mensaje emergente
    echo "<script>window.location = 'registrar.php';</script>";
}
?>
