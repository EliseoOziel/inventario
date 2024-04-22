<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            "categories" => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Create a new category
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //VALIDAR DATOS
        $category = $request->validated();
        $category['slug'] = $this->createSlug($category['name']);
        //GUARDAR EL REQUEST VALIDADO
        Category::create($category);
        //RETORNAR MENSAJE GUARDADO
        return response()->json([
            "message" => "La Categoria fue registrada..!!!",
            "category" => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    /* public function show(Category $category) */
    public function show(string $term)
    {
        $category = Category::where('id', $term)
            ->orWhere('slug', $term)
            ->get();
        //VALIDAR QUE EXISTA LA CATEGORIA
        if (count($category) == 0) {
            return response()->json([
                "message" => "No se encontro la categoria",
            ], 404);
        }
        //RETORNANDO EL REGISTRO
        return response()->json([
            "category" => $category[0],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "No se encontro la categoria",
            ], 404);
        }

        if ($request['name']) {
            $request['slug'] = $this->createSlug($request['name']);
        }

        $category->update($request->all());
        
        //RETORNANDO RESPUESTA
        return response()->json([
            "message" => "La Categoria fue actualizada..!!!",
            "category" => $category,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "No se encontro la categoria",
            ], 404);
        }

        $category->delete();

        return response()->json([
            "message" => "La Categoria fue eliminada..!!!",
            "category" => $category,
        ], 200);
    }

    private function createSlug(string $text)
    {
        //convirtiendo a minusculas
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        //eliminando espacios
        $text = trim($text, '-');
        //si hay simbolo - se siguie manteniendo el guion
        $text = preg_replace('/-+/', '-', $text);
        return $text;
    }
}
