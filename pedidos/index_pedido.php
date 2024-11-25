<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Produtos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
    
    <style>
    
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #6a0dad; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            color: #fff;
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); 
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 40px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline-block;
            margin: 10px;
        }

        nav ul li a {
            text-decoration: none;
            padding: 12px 25px;
            background-color: #6a0dad;
            color: white;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
            display: inline-block;
            width: 200px;
            text-align: center;
        }

        nav ul li a:hover {
            background-color: #0056b3;
            transform: translateY(-5px); 
        }

        nav ul li a:active {
            background-color: #004085;
            transform: translateY(1px); 
        }

        /* Responsividade */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            nav ul li a {
                font-size: 1rem;
                width: 150px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestão de Pedidos</h1>
    
    <nav class="mt-3">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="inclusao_pedido.php">Incluir Pedido</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="exclusao_pedido.php">Excluir Pedido</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="consulta_pedido.php">Consultar Pedido</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="relatorio_pedidos.php">Relatórios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Retornar</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
