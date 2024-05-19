<?php
session_start();
include '../db.php';

// Verificar si el usuario es administrador
if (!($_SESSION['usuario'] === 'admin')) {
    header('Location: ../index.php');
    exit();
}

$conexion = Conexion::obtenerInstancia()->getConexion();

// Manejar la aprobación o desaprobación de una empresa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && isset($_POST['idEmpresa'])) {
    $idEmpresa = $_POST['idEmpresa'];
    $accion = $_POST['accion'];
    $aprobada = ($accion == 'aprobar') ? 1 : 0;

    $query = "UPDATE Empresas SET aprobada = :aprobada WHERE idEmpresa = :idEmpresa";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':aprobada', $aprobada, PDO::PARAM_BOOL);
    $statement->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
    $statement->execute();

    header('Location: admin.php');
    exit();
}

// Obtener listas de empresas
$queryNoAprobadas = "SELECT * FROM Empresas WHERE aprobada = 0";
$queryAprobadas = "SELECT * FROM Empresas WHERE aprobada = 1";

$empresasNoAprobadas = $conexion->query($queryNoAprobadas)->fetchAll(PDO::FETCH_ASSOC);
$empresasAprobadas = $conexion->query($queryAprobadas)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Empresas</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40; /* Color de fondo oscuro */
            color: #fff; /* Texto en blanco */
        }
        .container {
            margin-top: 20px;
        }
        .table {
            background-color: #495057;
        }
        .table thead {
            background-color: #212529;
        }
    </style>
</head>
<body>

<!-- Encabezado -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">La Cuponera SV - Administración</a>
        <a class="nav-link" href="../views/logout.php">Cerrar sesión</a>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container">
    <h1>Administración de Empresas</h1>
    <div class="row">
        <div class="col-md-6">
            <h2>Empresas No Aprobadas</h2>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empresasNoAprobadas as $empresa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($empresa['idEmpresa']); ?></td>
                            <td><?php echo htmlspecialchars($empresa['nombre']); ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="idEmpresa" value="<?php echo $empresa['idEmpresa']; ?>">
                                    <button type="submit" name="accion" value="aprobar" class="btn btn-success">Aprobar</button>
                                    <button type="submit" name="accion" value="denegar" class="btn btn-danger">Denegar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h2>Empresas Aprobadas</h2>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empresasAprobadas as $empresa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($empresa['idEmpresa']); ?></td>
                            <td><?php echo htmlspecialchars($empresa['nombre']); ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="idEmpresa" value="<?php echo $empresa['idEmpresa']; ?>">
                                    <button type="submit" name="accion" value="desaprobar" class="btn btn-warning">Desaprobar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pie de página -->
<footer class="footer">
    <div class="container">
        <span>© <?php echo date("Y"); ?> La Cuponera SV. Todos los derechos reservados.</span>
    </div>
</footer>

<!-- Archivos JavaScript de Bootstrap -->
<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
