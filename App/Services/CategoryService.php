<?PHP

namespace App\Services;

use Exception;
use App\Models\Category;

class CategoryService
{
    public function get($id = null)
    {
        if ($id) {
            return Category::select($id);
        } else {
            return Category::selectAll();
        }
    }
    public function post()
    {
        if (isset($_POST['_method'])) {
            switch (strtolower($_POST['_method'])) {
                case 'put':
                    return Category::update($_POST);
                case 'delete':
                    return Category::delete($_POST);
            }
        } else {
            return Category::create($_POST);
        }
    }
}
