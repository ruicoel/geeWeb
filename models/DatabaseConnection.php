<?php
/**
 * Classe de conexão ao banco de dados usando PDO no padrão Singleton.
 * Modo de Usar:
 * require_once './Database.class.php';
 * $db = Database::conexao();
 * E agora use as funções do PDO (prepare, query, exec) em cima da variável $db.
 */
class DatabaseConnection
{
    protected static $db;
    private function __construct()
    {
        $db_host = "localhost";
        $db_nome = "gee";
        $db_usuario = "postgres";
        $db_senha = "";
        $db_driver = "pgsql";
        try
        {
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            die("Connection Error: " . $e->getMessage());
        }
    }
    public static function conexao()
    {
        if (!self::$db)
        {
            new DatabaseConnection();
        }
        return self::$db;
    }
}
