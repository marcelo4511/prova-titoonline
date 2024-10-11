<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    protected $categoria;

    public function __construct(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }
    public function index()
    {
        return view('categorias.index');
    }

    public function get()
    {
        return $this->categoria->all();
    }

    public function store(CategoriaRequest $request)
    {
        try {
            $data = $request->all();
            $categoria = $this->categoria->create($data);
            return response()->json($categoria, 201);
        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();
            $categoria =  $this->categoria->find($id);
            $categoria->update($data);

            return response()->json($categoria, 200);
        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $categoria = $this->categoria->find($id);
            $categoria->delete();
            return response()->json($categoria, 200);
        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
    }
}
