<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

$clientes = mysqli_query($conn, "SELECT id, nome FROM clientes");
$formas_pagto = mysqli_query($conn, "SELECT id, nome FROM forma_pagto");
$vendedores = mysqli_query($conn, "SELECT id, nome FROM vendedor");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = mysqli_real_escape_string($conn, trim($_POST['data']));
    $id_cliente = mysqli_real_escape_string($conn, trim($_POST['id_cliente']));
    $observacao = mysqli_real_escape_string($conn, trim($_POST['observacao']));
    $forma_pagto = mysqli_real_escape_string($conn, trim($_POST['forma_pagto']));
    $prazo_entrega = mysqli_real_escape_string($conn, trim($_POST['prazo_entrega']));
    $id_vendedor = mysqli_real_escape_string($conn, trim($_POST['id_vendedor']));

    if (empty($data) || empty($id_cliente) || empty($forma_pagto) || empty($prazo_entrega) || empty($id_vendedor)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        if (empty($erro)) {

            $sql = "INSERT INTO pedidos (data, id_cliente, observacao, forma_pagto, prazo_entrega, id_vendedor) 
                    VALUES ('$data', '$id_cliente', '$observacao', '$forma_pagto', '$prazo_entrega', '$id_vendedor')";
            
            if (mysqli_query($conn, $sql)) {
                $sucesso = "Pedido cadastrado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar pedido: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incluir Pedido</title>
    <link href="../config/style.css" rel="stylesheet">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background-color: #fff;
        color: #333;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        height: 100vh;
        overflow-y: auto;
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }

    .container {
        width: 80%;
        max-width: 960px;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        max-height: 80vh;
    }

    h1 {
        font-size: 30px;
        font-weight: 500;
        color: #6a0dad;
        margin-bottom: 20px;
        text-align: center;
        transition: color 0.3s ease;
    }

    h1:hover {
        color: #0056b3;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-size: 16px;
        font-weight: 600;
        color: #555;
        display: block;
        margin-bottom: 8px;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        padding: 14px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 25px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="date"]:focus,
    select:focus,
    textarea:focus {
        border-color: #6a0dad;
        outline: none;
        box-shadow: 0 0 8px rgba(0, 86, 179, 0.5);
        background-color: #fff;
    }

    textarea {
        height: 100px;
        resize: vertical;
        padding: 12px;
    }

    button {
        display: inline-block;
        background-color: #A020F0;
        color: #fff;
        padding: 14px 22px;
        font-size: 16px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    button:hover {
        background-color: #006f98;
        transform: translateY(-3px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    }

    .alert {
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        opacity: 0;
        animation: fadeInAlert 1s forwards;
    }

    @keyframes fadeInAlert {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        animation-delay: 0.3s;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        animation-delay: 0.3s;
    }
</style>
<body>

<div class="container">
    <h1>Cadastro de Pedido</h1>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $sucesso; ?>
        </div>
    <?php endif; ?>

    <form action="inclusao_pedido.php" method="POST">
        <div class="form-group">
            <label for="data">Data</label>
            <input type="date" class="form-control" id="data" name="data" required>
        </div>

        <div class="form-group">
            <label for="id_cliente">Cliente</label>
            <select class="form-control" id="id_cliente" name="id_cliente" required>
                <option value="">Selecione um cliente</option>
                <?php while ($cliente = mysqli_fetch_assoc($clientes)): ?>
                    <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['nome']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea class="form-control" id="observacao" name="observacao" placeholder="Observações adicionais..."></textarea>
        </div>

        <div class="form-group">
            <label for="forma_pagto">Forma de Pagamento</label>
            <select class="form-control" id="forma_pagto" name="forma_pagto" required>
                <option value="">Selecione uma forma de pagamento</option>
                <?php while ($forma = mysqli_fetch_assoc($formas_pagto)): ?>
                    <option value="<?php echo $forma['id']; ?>"><?php echo $forma['nome']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="prazo_entrega">Prazo de Entrega</label>
            <input type="date" class="form-control" id="prazo_entrega" name="prazo_entrega" required>
        </div>

        <div class="form-group">
            <label for="id_vendedor">Vendedor</label>
            <select class="form-control" id="id_vendedor" name="id_vendedor" required>
                <option value="">Selecione um vendedor</option>
                <?php while ($vendedor = mysqli_fetch_assoc($vendedores)): ?>
                    <option value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nome']; ?></option>
                <?php endwhile; ?>
            </select>

        </div>

        <button type="submit">Cadastrar Pedido</button>
    </form>
    <li class="nav-item">
                <a class="nav-link" href="index_pedido.php">Retornar</a>
            </li>
</div>

</body>
</html>
