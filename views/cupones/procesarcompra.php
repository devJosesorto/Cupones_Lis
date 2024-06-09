<?php
session_start();

if (isset($_GET['idOferta'])) {
    $idOferta = $_GET['idOferta'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Compra</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #222;
            color: #000;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-0">Procesar Compra</h2>
                </div>
                <div class="card-body">
                    <?php
                    try {
                        // Incluir la clase de conexion
                        require_once '../../db.php';

                        // Obtener la instancia de la conexion
                        $conexion = Conexion::obtenerInstancia()->getConexion();

                        // Verificar si se ha recibido el ID de la oferta
                        if (isset($_GET['idOferta'])) {
                            $idOferta = $_GET['idOferta'];
                            echo "ID de la oferta recibido: " . $idOferta;
                            echo "ID USUARIO: " . $_SESSION['id_usuario'];

                            // Genera la fecha actual y la fecha de vencimiento en tres meses
                            $fecha_actual = date('Y-m-d');
                            $fecha_vencimiento = date('Y-m-d', strtotime($fecha_actual . ' +3 month'));

                            // Genera un codigo de cupon aleatorio
                            $codigo_cupon = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);

                            // Datos quemados para la tarjeta y CVV
                            $numero_tarjeta = "1234567890123456";
                            $cvv = "123";

                            // Inserta los datos en la tabla CuponesComprados
                            $query = "INSERT INTO CuponesComprados (idCliente, idOferta, numero_tarjeta, fecha_vencimiento, cvv, fecha_compra, codigo_cupon) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $conexion->prepare($query);
                            $stmt->bindParam(1, $_SESSION['id_usuario'], PDO::PARAM_INT);
                            $stmt->bindParam(2, $idOferta, PDO::PARAM_INT);
                            $stmt->bindParam(3, $numero_tarjeta, PDO::PARAM_STR);
                            $stmt->bindParam(4, $fecha_vencimiento, PDO::PARAM_STR);
                            $stmt->bindParam(5, $cvv, PDO::PARAM_STR);
                            $stmt->bindParam(6, $fecha_actual, PDO::PARAM_STR);
                            $stmt->bindParam(7, $codigo_cupon, PDO::PARAM_STR);
                            $stmt->execute();

                            echo "<p class='text-success'>¡Pago procesado correctamente!</p>";
                            echo "<p class='text-info'>El codigo de tu cupon es: <strong>$codigo_cupon</strong></p>";

                            echo "<p class='text-info'>Serás redirigido en unos segundos...</p>";
                            header("refresh:5;url=confirmacion.php"); // Redireccionar después de 5 segundos
                            
                            // Limpiar la variable de sesion para permitir otra compra
                            unset($_SESSION['compra_procesada']);
                        } else {
                            echo "<p class='text-danger'>Error: No se ha recibido el ID de la oferta.</p>";
                        }
                    } catch (Exception $e) {
                        echo "<p class='text-danger'>Error: " . $e->getMessage() . "</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="mt-3">
                <a href="../index.php" class="btn btn-secondary btn-block">Regresar</a>
            </div>
        </div>
    </div>
</div>

<script src="../../assets/js/bootstrap.min.js"></script>
</body>
</html>
