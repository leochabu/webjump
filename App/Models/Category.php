<?PHP

namespace App\Models;

use Exception;
use Idearia\Logger;

class Category
{
    private static $table = 'categories';

    public static function create($post)
    {
        $connPdo = DBConn::getConn();
        $name = trim($post['category-name']);
        $code = trim($post['category-code']);

        if($name==''  || $code==''){
            Log::create('Categoria não pode ter campos vazios ', 'error');
            throw new \Exception("Erro ao cadastrar categoria. Campos vazios.");
            exit;
        }

        $sql  = " INSERT INTO " . self::$table . " (code_category, name_category) VALUES  (:code, :name)";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            Log::create("Categoria ".$name." criada",'info');
            return json_encode(array('status'=>'success', 'message'=>'Categoria criada com sucesso'), JSON_UNESCAPED_UNICODE); 
        } else {
            Log::create("Erro ao criar categoria ".$name,'error');
            throw new \Exception("Erro ao cadastrar categoria");
            exit;
        }
    }

    public static function select(int $id)
    {
        $connPdo = DBConn::getConn();

        $sql  = " SELECT * FROM " . self::$table . " WHERE id_category = :id";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            Log::create("Categoria ".$id." encontrada",'warning');
            throw new \Exception("Categoria não encontrada");
        }
    }

    public static function selectAll()
    {
        $connPdo = DBConn::getConn();

        $sql  = " SELECT * FROM " . self::$table;
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            Log::create("Nenhuma categoria encontrada",'warning');
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhuma produto encontrada");
        }
    }

    public static function update($post){
        $connPdo = DBConn::getConn();
        $id = $post['id'];
        $name = $post['category-name'];
        $code = $post['category-code'];

        $sql  = " UPDATE " . self::$table . " 
                  SET name_category=:name, code_category=:code
                  WHERE id_category = :id ";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            Log::create('Categoria '.$name.' alterada','info');
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            Log::create('Categoria '.$name.' não pode ser alterada','error');
            $e = $connPdo->errorCode();
            if($e[0]=='00000'){
                Log::create('Dados idênticos ao do registro','info');
                throw new \Exception('Categoria não alterada');
            }else{
                Log::create('Não foi possível atualizar a categoria '.$id,'error');
                throw new \Exception("Não foi possível atualizar a categoria ".$name);
            }
        }
    }

    public static function delete($post)
    {
        $connPdo = DBConn::getConn();
        $id = $post['id'];

        $sql  = " DELETE FROM " . self::$table . " 
                  WHERE id_category = :id ";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            Log::create('Categoria '.$id.' removida','delete');
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            Log::create('Categoria '.$id.' não pode ser removida','error');
            throw new \Exception("Categoria não encontrada");
        }
    }
}
