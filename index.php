<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Pedidos</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
 
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif;
            color: #fff;
            background-color: #6a0dad; 
        }

        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.8); 
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            color: #333;
            font-size: 2.8rem;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); 
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .menu a {
            text-decoration: none;
            padding: 15px 30px;
            background-color: #6a0dad;
            color: white;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            text-align: center;
            transform: scale(1); 
        }

        .menu a:hover {
            background-color: #0056b3;
            transform: scale(1.05); 
        }

        .menu a:active {
            transform: scale(0.98); 
        }

        p {
            font-size: 18px;
            color: #555;
            margin-top: 30px;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.2rem;
            }

            .menu a {
                font-size: 16px;
                padding: 12px 25px;
            }

            p {
                font-size: 16px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-cogs"></i> Gestão de Pedidos</h1>

        <div class="menu">
            <a class="nav-link" href="vendedores/index_vendedor.php"><i class="fas fa-users"></i> Vendedores</a> 
            <a class="nav-link" href="clientes/index_cliente.php"><i class="fas fa-users"></i> Clientes</a> 
            <a class="nav-link" href="produtos/index_produto.php"><i class="fas fa-box"></i> Produtos</a> 
            <a class="nav-link" href="pedidos/index_pedido.php"><i class="fas fa-file-invoice"></i> Pedidos</a> 
            <a class="nav-link" href="itens_pedido/index_itens_pedido.php"><i class="fas fa-file-invoice"></i> Itens do Pedido</a> 
            <a class="nav-link" href="formas_pagto/forma_pagto.php"><i class="fab fa-cc-mastercard"></i> Formas de Pagamento</a> 
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
