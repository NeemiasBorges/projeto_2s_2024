<?php
include('../config/conexao.php');

$erro = "";
$result = null;

// Variáveis de filtro
$id_pedido = isset($_POST['id_pedido']) ? mysqli_real_escape_string($conn, trim($_POST['id_pedido'])) : '';
$nome_cliente = isset($_POST['nome_cliente']) ? mysqli_real_escape_string($conn, trim($_POST['nome_cliente'])) : '';

// Consulta com filtro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT 
                pedidos.id AS numero_pedido,
                pedidos.data AS data_pedido,
                clientes.nome AS nome_cliente,
                vendedor.nome AS nome_vendedor,
                produto.id AS codigo_produto,
                produto.nome AS nome_produto,
                produto.preco AS preco_produto,
                itens_pedido.qtde AS quantidade_comprada
            FROM 
                itens_pedido
            INNER JOIN pedidos ON itens_pedido.id_pedido = pedidos.id
            INNER JOIN clientes ON pedidos.id_cliente = clientes.id
            INNER JOIN vendedor ON pedidos.id_vendedor = vendedor.id
            INNER JOIN produto ON itens_pedido.id_produto = produto.id
            WHERE 1";

    // Adiciona filtros conforme os valores fornecidos
    if (!empty($id_pedido)) {
        $sql .= " AND pedidos.id = '$id_pedido'";
    }
    if (!empty($nome_cliente)) {
        $sql .= " AND clientes.nome LIKE '%$nome_cliente%'";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $erro = "Erro ao executar a consulta: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Itens do Pedido</title>
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Consulta de Itens do Pedido</h1>

    <!-- Formulário de Filtros -->
    <form action="consulta_itens_pedido.php" method="POST">
        <div class="form-group">
            <label for="id_pedido">Número do Pedido</label>
            <input type="number" class="form-control" id="id_pedido" name="id_pedido" value="<?php echo $id_pedido; ?>">
        </div>
        <div class="form-group">
            <label for="nome_cliente">Nome do Cliente</label>
            <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="<?php echo $nome_cliente; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <!-- Exibe os resultados da consulta -->
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Número do Pedido</th>
                    <th>Data</th>
                    <th>Nome do Cliente</th>
                    <th>Nome do Vendedor</th>
                    <th>Código do Produto</th>
                    <th>Nome do Produto</th>
                    <th>Preço (R$)</th>
                    <th>Quantidade Comprada</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $item['numero_pedido']; ?></td>
                        <td><?php echo $item['data_pedido']; ?></td>
                        <td><?php echo $item['nome_cliente']; ?></td>
                        <td><?php echo $item['nome_vendedor']; ?></td>
                        <td><?php echo $item['codigo_produto']; ?></td>
                        <td><?php echo $item['nome_produto']; ?></td>
                        <td><?php echo number_format($item['preco_produto'], 2, ',', '.'); ?></td>
                        <td><?php echo $item['quantidade_comprada']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p class="mt-3">Nenhum item encontrado com os critérios informados.</p>
    <?php endif; ?>
    <a href="index_itens_pedido.php" class="btn btn-secondary">Retornar</a>
</div>

</body>
</html>
