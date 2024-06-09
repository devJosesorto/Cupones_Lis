<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a La Cuponera SV</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40; /* Color de fondo oscuro */
            color: #fff; /* Texto en blanco */
        }
        .footer {
            background-color: #212529; /* Color de fondo del pie de página */
            color: #fff; /* Texto en blanco */
            padding: 20px 0;
            text-align: center;
        }
        .login-container {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }
        .login-option {
            width: 30%; /* Ajustado el ancho al 30% para mejor visualizaci&oacute;n */
            padding: 20px;
            background-color: #495057; /* Color de fondo del contenedor de login */
            border-radius: 10px;
        }
        .login-option h2 {
            text-align: center;
        }
        .navbar .nav-link {
            color: #fff;
        }
    </style>
</head>
<body>

<!-- Encabezado -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">La Cuponera SV</a>
        <?php if (isset($_SESSION['usuario'])): ?>
            <span class="navbar-text">
                Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> (<?php echo htmlspecialchars($_SESSION['tipo_usuario']); ?>) <br>
                <a href="views/compras.php" class="navbar-text">Ver cupones comprados</a>

            </span>
            <?php if ($_SESSION['usuario'] === 'admin'): ?>
                <a class="nav-link" href="views/admin.php">Administrar</a>
            <?php endif; ?>
            <?php if ($_SESSION['tipo_usuario'] === 'empresa'): ?>
                <a class="nav-link" href="views/empresas/cupones.php">Registrar cupon</a>
            <?php endif; ?>

            <a class="nav-link" href="views/logout.php">Cerrar sesi&oacute;n</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container mt-4">
    <h1>Bienvenido a La Cuponera SV</h1>
    <p>&iexcl;Encuentra las mejores ofertas y descuentos aqu&iacute;!</p>

    <?php if (!isset($_SESSION['usuario'])): ?>
        <!-- Opciones de ingreso y registro -->
        <div class="login-container">
            <div class="login-option">
                <h2><a href="views/login.php">Ingreso</a></h2>
                <!-- Aqu&iacute; ir&iacute;a el formulario de ingreso -->
            </div>
            <div class="login-option">
                <h2><a href="views/empresas/registrar.php">Registro Empresas</a></h2>
                <!-- Aqu&iacute; ir&iacute;a el formulario de registro -->
            </div>
            <div class="login-option">
                <h2><a href="views/usuarios/registrar.php">Registro Usuarios</a></h2>
                <!-- Aqu&iacute; ir&iacute;a el formulario de registro -->
            </div>
        </div>
    <?php endif; ?>



    <?php
include 'db.php';

try {
    $conexion = Conexion::obtenerInstancia()->getConexion();

    // Consulta para seleccionar las ofertas de las empresas aprobadas
    $query = "SELECT Empresas.idEmpresa, Ofertas.idOferta, Ofertas.titulo, Ofertas.precio_regular, Ofertas.precio_oferta, Ofertas.fecha_inicio, Ofertas.fecha_fin, Ofertas.fecha_limite_canje, Ofertas.cantidad_cupones, Ofertas.descripcion
              FROM Ofertas
              INNER JOIN Empresas ON Ofertas.idEmpresa = Empresas.idEmpresa
              WHERE Empresas.aprobada = 1 AND Ofertas.estado = 'disponible'";

    $statement = $conexion->prepare($query);
    $statement->execute();
    $ofertas = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar las ofertas en una cuadr&iacute;cula HTML
    echo '<div class="row">';
    foreach ($ofertas as $oferta) {
        echo '<div class="col-md-4">';
        echo '<div class="card mb-3" style="border-radius: 10px; background-color: #f8f9fa; width: 300px;">'; // Tama&ntilde;o fijo del recuadro
        echo '<div class="card-body">';
        echo '<h4 class="card-title" style="color: black;">' . $oferta['titulo'] . '</h4>'; // Letras negras
        echo '<p class="card-text" style="color: black;"><strong>Precio Regular:</strong> $' . $oferta['precio_regular'] . '</p>'; // Letras negras
        echo '<p class="card-text" style="color: black;"><strong>Precio Oferta:</strong> $' . $oferta['precio_oferta'] . '</p>'; // Letras negras
        echo '<p class="card-text" style="color: black;"><strong>Cantidad de Cupones:</strong> ' . $oferta['cantidad_cupones'] . '</p>'; // Letras negras
        
        // Verificar si el usuario es una empresa y el idEmpresa de la oferta coincide con el idUsuario en la sesi&oacute;n
        if ($_SESSION['tipo_usuario'] === 'empresa' && $oferta['idEmpresa'] === $_SESSION['id_usuario']) {
            echo '<a href="#" class="btn btn-danger">Eliminar</a>'; // Bot&oacute;n "Eliminar" para usuarios de tipo empresa y el idEmpresa coincide
        } elseif ($_SESSION['tipo_usuario'] !== 'empresa') {
            if ($_SESSION['tipo_usuario'] === 'usuario'){
            echo '<a href="views/cupones/comprarcupon.php?idOferta=' . $oferta['idOferta'] . '" class="btn btn-primary">Canjear</a>'; // Bot&oacute;n "Canjear" para otros tipos de usuario
            }else{
                echo '<a href="views/login.php?idOferta=' . $oferta['idOferta'] . '" class="btn btn-primary">Canjear</a>'; // Bot&oacute;n "Canjear" para otros tipos de usuario   
            }
        }
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    
    
} catch (Exception $e) {
    // Manejar errores
    echo 'Error: ' . $e->getMessage();
}
?>



</div>

<!-- Pie de página -->
<footer class="footer">
    <div class="container">
        <span>&copy; <?php echo date("Y"); ?> La Cuponera SV. Todos los derechos reservados.</span>
    </div>
</footer>

<!-- Archivos JavaScript de Bootstrap -->
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
