<?php

namespace App\Http\Controllers;

use App\Exports\ProdutoExport;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProdutoController extends Controller
{
    protected $produto;

    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }
    public function index()
    {
        return view('produtos.index');
    }

    public function get()
    {
        return $this->produto->with('categoria')->get();
    }

    public function store(ProdutoRequest $request)
    {
        try {
            $data = $request->all();
            $produto = $this->produto->create($data);
            return response()->json($produto->load('categoria'), 201);
        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();
            $produto =  $this->produto->find($id);
            $produto->update($data);

            return response()->json($produto->load('categoria'), 200);
        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $produto = $this->produto->find($id);
            $produto->delete();
            return response()->json($produto->load('categoria'), 200);
        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    public function excel()
    {
        return Excel::download(new ProdutoExport, 'produtos.xlsx');
    }

    public function pdf()
    {
        $produtos = $this->produto->all();

        $pdf = PDF::loadView('produtos.pdf', array('produtos' =>  $produtos))
            ->setPaper('a4', 'portrait');

        return $pdf->download('produtos.pdf');
    }

    public function txt()
    {
        $produtos = $this->produto->all();

        $content = "\n";

        foreach ($produtos as $produto) {
            $content .= "{$produto->categoria->nome}; {$produto->nome}; {$produto->descricao}; {$produto->price}\n";
        }

        $fileName = 'produtos.txt';

        return Response::make($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
