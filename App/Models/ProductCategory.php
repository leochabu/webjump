<?PHP

namespace App\Models;

use Exception;

class ProductCategory
{
    private static $table = 'product_category';

    public static function create(int $id, $categories)
    {
        $connPdo = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
        foreach ($categories as $cat=>$v) {
            $sql  = " INSERT INTO ".self::$table." (id_product, id_category) values (:idp, :idc) ";
            $stmt = $connPdo->prepare($sql);
            $stmt->bindParam(':idp', $id);
            $stmt->bindParam(':idc', $v);
            $stmt->execute();
        }
        if ($stmt->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function select(int $id)
    {
        $connPdo = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
        $sql  = " SELECT * FROM " . self::$table . " WHERE id_pc = :id";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("ProdutoCategoria não encontrado");
        }
    }
    public static function selectCategoryByProductId(int $id)
    {
        $connPdo = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
        $sql  = " SELECT id_category, id_product FROM " . self::$table . " WHERE id_product = :id  ";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        exit;
        if ($stmt->rowCount() > 0) {
        } else {
            throw new \Exception("Produto não encontrado");
        }
    }

    public static function selectAll()
    {
        $connPdo = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        $sql  = " SELECT * FROM " . self::$table;
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } else {
            throw new \Exception("Nenhuma relação encontrada");
        }
    }

    public static function update($id, $categories){
        self::delete($id);
        return self::create($id, $categories);
    }
    
    public static function delete($id){
        $connPdo = DBConn::getConn();
        $sql  = " DELETE FROM " . self::$table . "
        WHERE id_product=:id ";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


}
