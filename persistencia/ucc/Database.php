<?php
/**
 * Clase que envuelve una instancia de la clase PDO
 * para el manejo de la base de datos
 */

//require_once('mysql_login.php');
include_once('IConnectInfo.php');

class Database
{

    /**
     * Inica instancia de la clase
     */
    private static $db = null;

    /**
     * Instancia de PDO
     */
    private static $pdo;

    final private function __construct()
    {
        try {
            // Crear nueva conexi�n PDO
            self::getDb();
        } catch (PDOException $e) {
            var_dump('Falló la conexión: ' . $e->getMessage());
        }


    }

    /**
     * Retorna en la �nica instancia de la clase
     * @return Database|null
     */
    public static function getInstance()
    {
        if (self::$db === null) {
            self::$db = new self();
        }
        return self::$db;
    }

    /**
     * Crear una nueva conexi�n PDO basada
     * en los datos de conexi�n
     * @return PDO Objeto PDO
     */
    public function getDb()
    {
        if (self::$pdo == null) {
            self::$pdo = new PDO(
                'mysql:dbname=' . BD_SQL .
                ';host=' . SERV_SQL .
                ';port:'.PORT_SQL.';', // Eliminar este elemento si se usa una instalaci�n por defecto
                USER_SQL,
                PDW_SQL,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );

            // Habilitar excepciones
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }

    /**
     * Evita la clonaci�n del objeto
     */
    final protected function __clone()
    {
    }

    function _destructor()
    {
        self::$pdo = null;
    }
}

?>