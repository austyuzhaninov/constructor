<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConstructorController extends Controller
{

    /**
     * @var - выборка из БД ингредиентов
     */
    public $ingredients;

    /**
     * @var array - массив с id ингредиентами (все возможные комбинации)
     */
    public array $result = [];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Выборку сделал разовую и заранее, напрямую через DB, хотя сам предпочитаю работу с моделями и Eloquent'ом
        $query = DB::select('select i.id as id, i.title as title, i.price as price, it.title as type, it.code as code from ingredient i inner join ingredient_type it on i.type_id = it.id;');

        // Группирую ингредиенты по коду
        $this->ingredients = collect($query)->groupBy('code');

        // Логическую часть решил вынести в отдельный метод
        $this->generator($request->route('code'));


        // Преобразование в json массив, лучше использовать коллекции в Laravel, так же сразу предоставлять данные в методе generator()
        $toJson = [];
        $groupId = collect($query)->keyBy('id');
        foreach ($this->result as $recipe) {
            $price = 0;
            $ingredients = [];
            foreach ($recipe as $ingredientId) {
                $ingredients[] = ['type' => $groupId[$ingredientId]->type, 'value' => $groupId[$ingredientId]->title];
                $price += $groupId[$ingredientId]->price;
            }
            $toJson[] = [
                'products' => $ingredients,
                'price' => $price
            ];
        }
        return json_encode($toJson, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Метод генерации массива с id ингредиентов
     * Использует комбинаторику и рекурсивный вызов самого себя
     *
     * @param string $code - код рецепта
     * @param array $addedIngredients - массив добавленных ингредиентов (id)
     * @return void
     */
    public function generator(string $code, array $addedIngredients = []): void
    {
        // Добавляем ингредиент
        if(strlen($code) < 1) {
            // Для предотвращения дублей создаём проверку
            foreach ($this->result as $old) {
                if (empty(array_diff($old, $addedIngredients))) {
                    return;
                }
            }
            $this->result[] = $addedIngredients;
            return;
        }

        // Находим каждый ингредиент из базы
        foreach ($this->ingredients[$code[0]] as $ingredient) {
            $continue = false;

            // Проверяем на добавленный ингредиент
            foreach ($addedIngredients as $added) {
                if($added == $ingredient->id){
                    $continue = true;
                }
            }

            // Если ингридиент уже есть в списке, то его не добавляем
            if ($continue) {
                continue;
            }

            // Создаем массив добавленных элементов
            $newIngredients = $addedIngredients;
            $newIngredients[] = $ingredient->id;
            // Убираем первый ингредиент из рецепта, передаем в рекурсию
            $this->generator(substr($code, 1), $newIngredients);
        }

    }

}
