<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();

        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Error al traer los productos'
            ], 404);
        }

        $data = [
            'success' => true,
            'message' => 'Lista de productos',
            'data' => $product
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string|max:300',
            'price' => 'required|decimal:0,2',
            'stock' => 'required|integer'
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Error en los tipos de datos',
                'errors' => $validate->errors()
            ], 404);
        }

        $product = Product::create($request->all());

        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Error al crear producto',
            ], 404);
        }

        $data = [
            'success' => true,
            'messsage' => 'Producto creado',
            'data' => $product
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string|max:300',
            'price' => 'required|decimal:0,2',
            'stock' => 'required|integer'
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Error en los tipos de datos',
                'errors' => $validate->errors()
            ], 404);
        }

        $product->update([
            $product->name = $request->name,
            $product->description = $request->description,
            $product->price = $request->price,
            $product->stock = $request->stock,
            $product->category_id = $request->category_id,
        ]);

        $product->save();

        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Error al editar el producto',
            ], 404);
        }

        $data = [
            'success' => true,
            'message' => 'Producto editado',
            'data' => $product
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->delete();

        $data = [
            'success' => true,
            'message' => 'Producto eliminado'
        ];

        return response()->json($data, 200);
    }

    public function category():BelongsTo
    {
        return $this->belongTo(Category::class, 'category_id');
    }
}
