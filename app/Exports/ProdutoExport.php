<?php

namespace App\Exports;

use App\Models\Produto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProdutoExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Produto::with('categoria')->get();
    }

    public function headings(): array
    {
        return [
            'Categoria',
            'Nome',
            'Descrição',
            'Preço'
        ];
    }

    public function map($produto): array
    {
        return [
            $produto->categoria->nome,
            $produto->nome,
            $produto->descricao,
            number_format($produto->preco, 2, ",", ".")
        ];
    }
}
