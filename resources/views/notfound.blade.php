<!-- resources/views/notfound.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Não Encontrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 2.5rem;
            color: #333;
        }
        p {
            font-size: 1.2rem;
            color: #666;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        a:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <h2>Página não encontrada</h2>
    <p>Desculpe, a página que você está tentando acessar não existe ou foi removida.</p>
    <a href="{{ url('/') }}">Voltar para a Página Inicial</a>
</body>
</html>
