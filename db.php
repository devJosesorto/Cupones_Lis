<?php

class Conexion {
    private static $instancia = null;
    private $conexion;

    private function __construct() {
        $host = "localhost";
        $dbname = "cuponerasv";
        $usuario = "root";
        $password = "";

        try {
            $this->conexion = new PDO("mysql:host={$host};dbname={$dbname}", $usuario, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Error de conexi&oacute;n: " . $e->getMessage());
        }
    }

    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }

    public function getConexion() {
        return $this->conexion;
    }
}

?>
