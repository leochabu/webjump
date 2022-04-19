<?PHP

namespace App\Models;

use Exception;

class Log
{
    private static $table = 'logs';

    public static function create($txt, $type)
    {
        $connPdo = DBConn::getConn();

        $sql  = " INSERT INTO " . self::$table . " (txt_log, type_log) VALUES  (:txt, :type)";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindParam(':txt', $txt);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
    }

    public static function selectLogByType($type)
    {
        $connPdo = DBConn::getConn();

        $sql  = " SELECT * FROM " . self::$table . " WHERE type_log = :type";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':type', $type);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return "Nenhum registro encontrado para o tipo: " . $type;
        }
    }

    public static function selectAll()
    {
        $connPdo = DBConn::getConn();

        $sql  = " SELECT * FROM " . self::$table;
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return "Nenhum registro encontrado";
        }
    }
}
