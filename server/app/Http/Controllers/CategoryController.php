<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();

        if(!$category){
            return response()->json( [
                'success' => false,
                'message' => 'Error al traer las categorias'
            ], 404);
        }

        $data = [
            'success' => true,
            'message' => 'Lista de categorias',
            'data' => $category
        ];

        return response()->json($data,200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string|max:300'
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Error al crear categoria',
                'errors' => $validate->errors()
            ], 404);
        }

        $category = Category::create($request->all());

        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'Error al crear categoria'
            ], 404);
        }

        $data = [
            'success' => true,
            'message' => 'Lista de categorias',
            'data' => $category
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'success' => false,
                'message' => "Categoria no encontrada"
            ], 404);
        }

        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string|max:300'
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Tipos de datos incorrectos',
                'errors' => $validate->errors()
            ], 404);
        }

        $category->update([
            $category->name = $request->name,
            $category->description = $request->description
        ]);

        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'Error al editar categoria',
            ], 404);
        }

        $data = [
            'success' => true,
            'message' => 'Categoria editada',
            'data' => $category
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'No se encontro la categoria'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoria eliminada'
        ], 200);
    }
}
