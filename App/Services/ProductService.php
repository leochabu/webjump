<?PHP

namespace App\Services;

use Exception;
use App\Models\Product;

class ProductService
{
    public function get($id = null)
    {
        if ($id) {
            return Product::select($id);
        } else {
            return Product::selectAll();
        }
    }
    public function post()
    {
        if (isset($_POST['_method'])) {
            switch (strtolower($_POST['_method'])) {
                case 'put':
                    return Product::update($_POST);
                case 'delete':
                    return Product::delete($_POST);
            }
        } else {
            return Product::create($_POST);
        }
    }
}
