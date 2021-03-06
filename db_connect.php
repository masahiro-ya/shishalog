<?php
function connect()
{
    //require
    require_once __DIR__.'/vendor/autoload.php';

    //for .env
    // use Dotenv\Dotenv;

   $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
   $dotenv->load(); //.envが無いとエラーになる
	$host = $_ENV["DB_HOST"];
	$db   = $_ENV["DB_NAME"];
	$user = $_ENV["DB_USER"];
	$pass = $_ENV["DB_PASS"];
	$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

	try {
		$pdo = new PDO($dsn, $user, $pass, [
		  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);
		return $pdo;
	} catch(PDOException $e) {
		echo '接続失敗です!'. $e->getMessage();
		exit();
	}
}
