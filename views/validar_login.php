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
        // Inicio de sesi&oacute;n exitoso
        session_start();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo_usuario'] = $tipo_usuario;

        $_SESSION['id_usuario'] = $result[$tipo_usuario == 'usuario' ? 'idCliente' : 'idEmpresa']; // Selecciona el ID adecuado seg&uacute;n el tipo de usuario

        echo "<script>alert('Inicio de sesi&oacute;n exitoso.');</script>";
        if (empty($oferta)) {
            echo "<script>window.location = '../index.php';</script>";
        } else {
            echo "<script>window.location = '../views/cupones/comprarcupon.php?idOferta=$oferta';</script>";
        }
    } else {
        // Error en el inicio de sesi&oacute;n
        echo "<script>alert('Nombre de usuario o contrase&ntilde;a incorrectos.');</script>";
        echo "<script>window.location = 'login.php';</script>";
    }
} catch (Exception $e) {
    echo "<script>alert('Error al intentar iniciar sesi&oacute;n.');</script>";
    echo "<script>window.location = 'login.php';</script>";
}
?>
