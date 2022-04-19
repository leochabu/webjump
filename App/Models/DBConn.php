<?PHP 
    namespace App\Models;
    include_once("config.php");
    class DBConn{
        public static function getConn(){
            return new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
        }
    }