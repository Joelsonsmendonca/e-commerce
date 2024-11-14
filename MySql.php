<?php
class MySql {
    private static $pdo;

    // Método estático para obter a conexão com o banco de dados
    public static function getConn() {
        // Verifica se a conexão ainda não foi estabelecida
        if (self::$pdo == null) {
            // Cria uma nova conexão PDO com o banco de dados
            self::$pdo = new PDO('mysql:host=localhost;dbname=e-commerce', 'root', '');
            return self::$pdo;
        } else {
            // Retorna a conexão existente
            return self::$pdo;
        }
    }
}