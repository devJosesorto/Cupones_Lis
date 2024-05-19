<?php
include '../db.php';

// Recibe los datos del formulario
$tipo_usuario = $_POST['tipo_usuario'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$oferta = $_POST['idOferta'];

try {
    $conexion = Conexion::obtenerInstancia()->getConexion();

    if ($tipo_usuario == 'usuario') {
        // Consulta para usuarios
        $query = "SELECT idCliente FROM Clientes WHERE usuario = :usuario AND contrasena = :contrasena";
    } else {
        // Consulta para empresas
        $query = "SELECT idEmpresa FROM Empresas WHERE usuario = :usuario AND contrasena = :contrasena";
    }

    $statement = $conexion->prepare($query);
    $statement->bindParam(':usuario', $usuario);
    $statement->bindParam(':contrasena', $contrasena);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo_usuario'] = $tipo_usuario;

        $_SESSION['id_usuario'] = $result[$tipo_usuario == 'usuario' ? 'idCliente' : 'idEmpresa']; // Selecciona el ID adecuado según el tipo de usuario

        echo "<script>alert('Inicio de sesión exitoso.');</script>";
        if (empty($oferta)) {
            echo "<script>window.location = '../index.php';</script>";
        } else {
            echo "<script>window.location = '../views/cupones/comprarcupon.php?idOferta=$oferta';</script>";
        }
    } else {
        // Error en el inicio de sesión
        echo "<script>alert('Nombre de usuario o contraseña incorrectos.');</script>";
        echo "<script>window.location = 'login.php';</script>";
    }
} catch (Exception $e) {
    echo "<script>alert('Error al intentar iniciar sesión.');</script>";
    echo "<script>window.location = 'login.php';</script>";
}
?>
