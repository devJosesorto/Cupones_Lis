<?php
require_once '../../db.php';

class Cupon {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::obtenerInstancia()->getConexion();
    }

    public function obtenerCuponesDisponibles() {
        $stmt = $this->conexion->prepare("SELECT * FROM ofertas WHERE estado = 'disponible'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$cuponModel = new Cupon();
$cupones = $cuponModel->obtenerCuponesDisponibles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cuponera SV</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Bienvenido a La Cuponera SV</h1>
    <div class="row">
        <?php if (count($cupones) > 0): ?>
            <?php foreach ($cupones as $cupon): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($cupon['titulo']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($cupon['descripcion']); ?></p>
                            <p class="card-text"><strong>Precio Regular:</strong> $<?php echo htmlspecialchars($cupon['precioRegular']); ?></p>
                            <p class="card-text"><strong>Precio Oferta:</strong> $<?php echo htmlspecialchars($cupon['precioOferta']); ?></p>
                            <a href="#" class="btn btn-primary">Comprar Ahora</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay cupones disponibles en este momento.</p>
        <?php endif; ?>
    </div>
</div>

<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
