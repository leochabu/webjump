<?PHP

namespace App\Models;
use App\Services\ProductCategoryService;
use Exception;

class Product
{
    private static $table = 'products';

    public static function create($post)
    {
        $connPdo = DBConn::getConn();
        $sku = trim($post['sku']);
        $name = trim($post['name']);
        $price = trim($post['price']);
        $description = trim($post['description']);
        $quantity = trim($post['quantity']);
        $categories = $post['category-list'];

        $sql  = " INSERT INTO " . self::$table . "(sku_product, 
                                                   name_product, 
                                                   price_product, 
                                                   description_product, 
                                                   quantity_product) 
                                           VALUES  (:sku, 
                                                    :name, 
                                                    :price, 
                                                    :description, 
                                                    :quantity)";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
        $id = $connPdo->lastInsertId();
        if ($stmt->rowCount() > 0) {
            Log::create('Produto '.$name.' criado','info');

            $pc = ProductCategory::create($id, $categories);
            if ($pc) {
                Log::create('Categorias do produto '.$name.' cadastradas','info');
                return 'Produto criado com sucesso';
            } else {
                Log::create('Erro ao criar categorias para o produto '.$name,'error');
                throw new \Exception("Erro ao cadastrar categorias do produto");
            }
        } else {
            Log::create('Erro ao criar o produto '.$name,'error');
            throw new \Exception("Erro ao cadastrar produto");
        }
    }

    public static function select(int $id)
    {
        $connPdo = DBConn::getConn();
        $sql  = " SELECT * FROM " . self::$table . " WHERE id_product = :id";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $prodCats[] = '';
            $product = $stmt->fetch(\PDO::FETCH_ASSOC);

            $prodCats = ProductCategory::selectCategoryByProductId($id);

            for ($i = 0; $i < sizeof($prodCats); $i++) {
                $product['categories'][$i] = (Category::select($prodCats[$i]['id_category']));
            }
            return $product;
        } else {
            Log::create('Produto '.$id.' não econtrato','warning');
            throw new \Exception("Nenhum produto encontrado");
        }
    }

    public static function selectAll()
    {
        $connPdo = DBConn::getConn();

        $sql  = " SELECT * FROM " . self::$table;
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $prodCats[] = '';
            $prodImages[] = '';
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            for ($i = 0; $i < sizeof($products); $i++) {
                $prodCats = ProductCategory::selectCategoryByProductId($products[$i]['id_product']);
                for ($j = 0; $j < sizeof($prodCats); $j++) {
                    $products[$i]['categories'][$j] = (Category::select($prodCats[$j]['id_category']));
                }

                for ($k = 0; $k < sizeof($prodImages); $k++) {
                    $products[$i]['images'][$k] = $prodImages[$i];
                }
            }
            return $products;
        } else {
            Log::create('Nenhum produto encontrado','warning');
            throw new \Exception("Nenhum produto encontrado");
        }
    }

    public static function update($post)
    {
        $connPdo = DBConn::getConn();
        $id = $post['id'];
        $name = $post['name'];
        $sku = $post['sku'];
        $price = $post['price'];
        $quantity = $post['quantity'];
        $description = $post['description'];
        $categories = $post['category-list'];
        
        $sql  = " UPDATE " . self::$table . " 
                  SET name_product=:name, sku_product=:sku, price_product=:price, quantity_product=:quantity, description_product=:description
                  WHERE id_product = :id ";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        Log::create('Produto '.$name.' alterado','update');

        $pc = ProductCategory::update($id, $categories);
        if ($pc) {
            Log::create('Categorias do produto '.$name.' não foram atualizadas','error');
            return 'Produto atualizado com sucesso';
        } else {
            Log::create('Produto '.$name.' não pode ser alterado','error');
            throw new \Exception("Erro ao atualizar produto");
        }
    }

    public static function delete($post)
    {
        $id = $post['id'];

        $connPdo = DBConn::getConn();
        $sql  = " DELETE FROM " . self::$table . " 
                  WHERE id_product = :id ";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            Log::create('Produto '.$id.' removido','info');
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            Log::create('Produto '.$id.' não pode ser removido','error');
            throw new \Exception("Produto não encontrado");
        }
    }
}
