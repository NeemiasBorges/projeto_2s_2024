<?php
include('../config/conexao.php');

$erro = "";
$sucesso = "";
$dataFiltro = "";

// Verifica se o filtro por data foi enviado
if (isset($_GET['dataFiltro'])) {
    $dataFiltro = $_GET['dataFiltro'];
}

// Inicializa a variável que armazena os resultados da consulta
$result = null;

// Monta a query para buscar os pedidos, considerando o filtro de data
$sql = "
    SELECT 
        pedidos.id, pedidos.data, pedidos.observacao, pedidos.forma_pagto, 
        pedidos.prazo_entrega, clientes.nome AS cliente_nome, 
        vendedor.nome AS vendedor_nome
    FROM 
        pedidos
    JOIN 
        clientes ON pedidos.id_cliente = clientes.id
    JOIN 
        vendedor ON pedidos.id_vendedor = vendedor.id
";

// Se o filtro de data foi aplicado, adiciona a condição na query
if (!empty($dataFiltro)) {
    $sql .= " WHERE DATE(pedidos.data) = '" . mysqli_real_escape_string($conn, $dataFiltro) . "'";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Erro na consulta: ' . mysqli_error($conn)); // Adicionada verificação de erro na consulta
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Pedidos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet"> <!-- Seu CSS externo -->
</head>
<body>

<div class="container">
    <h1>Consulta de Pedidos</h1>

    <div class="form-group">
        <label for="dataFiltro">Filtrar por Data:</label>
        <form method="get" action="">
            <input type="date" id="dataFiltro" name="dataFiltro" class="form-control" value="<?php echo $dataFiltro; ?>">
            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
        </form>
    </div>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered mt-3" id="tabelaPedidos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Observação</th>
                    <th>Forma de Pagamento</th>
                    <th>Prazo de Entrega</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($pedido['data'])); ?></td>
                        <td><?php echo $pedido['observacao']; ?></td>
                        <td><?php echo $pedido['forma_pagto']; ?></td>
                        <td><?php echo ($pedido['prazo_entrega'] == '0000-00-00') ? 'Não definido' : date('d/m/Y', strtotime($pedido['prazo_entrega'])); ?></td>
                        <td><?php echo $pedido['cliente_nome']; ?></td>
                        <td><?php echo $pedido['vendedor_nome']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="mt-3">Nenhum pedido encontrado.</p>
    <?php endif; ?>
    <li class="nav-item">
                <a class="nav-link" href="index_pedido.php">Retornar</a>
            </li>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
