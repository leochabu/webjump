<?PHP

namespace App\Services;

use Exception;
use App\Models\ProductCategory;

class ProductCategoryService
{
    public function get($id = null)
    {
        if($id){
            return ProductCategory::select($id);
        }else{
            return ProductCategory::selectAll();
        }
    }
    public function post()
    {
        if (isset($_POST['_method'])) {
            switch (strtolower($_POST['_method'])) {
                case 'put':
                    return ProductCategory::update($_POST,'');
                case 'delete':
                    return ProductCategory::delete($_POST['id'],'');
            }
        } else {
            return ProductCategory::create($_POST,'');
        }
    }
    
}
