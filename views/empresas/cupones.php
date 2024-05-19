<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Cupón</title>
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-0">Agregar Nuevo Cupón</h2>
                </div>
                <div class="card-body">
                    <form action="registrar_cupon.php" method="POST">
                        <div class="form-group">
                            <label for="idEmpresa">ID Empresa:</label>
                            <input type="number" class="form-control" id="idEmpresa" name="idEmpresa" value="<?php echo $_SESSION['id_usuario']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="form-group">
                            <label for="precio_regular">Precio Regular:</label>
                            <input type="number" step="0.01" class="form-control" id="precio_regular" name="precio_regular" required>
                        </div>
                        <div class="form-group">
                            <label for="precio_oferta">Precio de Oferta:</label>
                            <input type="number" step="0.01" class="form-control" id="precio_oferta" name="precio_oferta" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio:</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin:</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_limite_canje">Fecha Límite de Canje:</label>
                            <input type="date" class="form-control" id="fecha_limite_canje" name="fecha_limite_canje" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad_cupones">Cantidad de Cupones:</label>
                            <input type="number" class="form-control" id="cantidad_cupones" name="cantidad_cupones" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" class="form-control" required>
                                <option value="disponible">Disponible</option>
                                <option value="no disponible">No Disponible</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Registrar Cupón</button>
                    </form>
                </div>
            </div>
            <div class="mt-3">
                <a href="../../index.php" class="btn btn-secondary btn-block">Regresar</a>
            </div>
        </div>
    </div>
</div>

<script src="../../assets/js/bootstrap.min.js"></script>
</body>
</html>
