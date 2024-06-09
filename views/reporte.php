<?php

require_once '../db.php';

function obtenerReporte() {
    $conexion = Conexion::obtenerInstancia()->getConexion();

    // Consulta para obtener el total de cupones vendidos por empresa
    $sqlCuponesVendidos = "
        SELECT e.nombre AS empresa, SUM(o.cantidad_vendida) AS total_cupones_vendidos
        FROM Empresas e
        JOIN Ofertas o ON e.idEmpresa = o.idEmpresa
        GROUP BY e.idEmpresa, e.nombre
    ";

    // Consulta para obtener el total de ganancias obtenidas por empresa
    $sqlGananciasObtenidas = "
        SELECT e.nombre AS empresa, SUM(o.cantidad_vendida * o.precio_oferta) AS total_ganancias
        FROM Empresas e
        JOIN Ofertas o ON e.idEmpresa = o.idEmpresa
        GROUP BY e.idEmpresa, e.nombre
    ";

    try {
        // Ejecutar consulta de cupones vendidos
        $stmtCupones = $conexion->prepare($sqlCuponesVendidos);
        $stmtCupones->execute();
        $cuponesVendidos = $stmtCupones->fetchAll(PDO::FETCH_ASSOC);

        // Ejecutar consulta de ganancias obtenidas
        $stmtGanancias = $conexion->prepare($sqlGananciasObtenidas);
        $stmtGanancias->execute();
        $gananciasObtenidas = $stmtGanancias->fetchAll(PDO::FETCH_ASSOC);

        return [
            'cupones_vendidos' => $cuponesVendidos,
            'ganancias_obtenidas' => $gananciasObtenidas
        ];
    } catch (PDOException $e) {
        throw new Exception("Error al generar el reporte: " . $e->getMessage());
    }
}

// Generar el reporte y mostrarlo
try {
    $reporte = obtenerReporte();

    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Reporte</title>";
    // Incluir Bootstrap CSS
    echo "<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>";
    // Estilo personalizado para fondo oscuro
    echo "<style>";
    echo "body { background-color: #343a40; color: white; }";
    echo "</style>";
    echo "</head>";
    echo "<body>";

    echo "<div class='container'>";
    echo "<h1 class='mt-5'>Reporte de Cupones Vendidos y Ganancias Obtenidas</h1>";

    echo "<h2 class='mt-5'>Total de Cupones Vendidos por Empresa</h2>";
    echo "<table class='table table-dark table-striped'>";
    echo "<thead>";
    echo "<tr><th>Empresa</th><th>Total de Cupones Vendidos</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($reporte['cupones_vendidos'] as $fila) {
        echo "<tr><td>{$fila['empresa']}</td><td>{$fila['total_cupones_vendidos']}</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";

    echo "<h2 class='mt-5'>Total de Ganancias Obtenidas</h2>";
    echo "<table class='table table-dark table-striped'>";
    echo "<thead>";
    echo "<tr><th>Empresa</th><th>Total de Ganancias</th><th>Beneficio (15%)</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($reporte['ganancias_obtenidas'] as $fila) {
        $beneficio = $fila['total_ganancias'] * 0.15;
        echo "<tr><td>{$fila['empresa']}</td><td>{$fila['total_ganancias']}</td><td>{$beneficio}</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";

    // Botón de regresar
    echo "<a href='javascript:history.go(-1)' class='btn btn-primary mt-5'>Regresar</a>";

    echo "</div>"; // Cierre del contenedor

    echo "</body>";
    echo "</html>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
