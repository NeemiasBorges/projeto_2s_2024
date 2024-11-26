<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Produtos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
    </style>
</head>
<body>

<div class="container">
    <h1>Gestão de Pedidos</h1>
    
    <nav class="mt-3">
        <ul class="nav">
            <li class="nav-item">
                <a class="" href="inclusao_pedido.php">Incluir Pedido</a>
            </li>
            <li class="nav-item">
                <a class="" href="exclusao_pedido.php">Excluir Pedido</a>
            </li>
            <li class="nav-item">
                <a class="" href="consulta_pedido.php">Consultar Pedido</a>
            </li>
            <li class="nav-item">
                <a class="" href="#" data-bs-toggle="modal" data-bs-target="#relatorioModal">Relatórios</a>
            </li>
            <li class="nav-item">
                <a class="" href="../index.php">Retornar</a>
            </li>
        </ul>
    </nav>
</div>

<div class="modal fade" id="relatorioModal" tabindex="-1" aria-labelledby="relatorioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="relatorioModalLabel">Gerar Relatório</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="relatorio_pedidos.php" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="dataInicio" class="form-label">Data Início</label>
                        <input type="date" id="dataInicio" name="data_inicio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="dataFim" class="form-label">Data Fim</label>
                        <input type="date" id="dataFim" name="data_fim" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Gerar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
