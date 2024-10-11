<!DOCTYPE html>
<html>

<head>
    <style>
        /* Adicione estilos básicos para o PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr style="background-color: blue; color: white">
                <th>Categoria</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $produto)
            <tr>
                <td>{{ $produto->categoria->nome}}</td>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->descricao }}</td>
                <td>R$ {{ $produto->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>