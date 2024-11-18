<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_produto = mysqli_real_escape_string($conn, trim($_POST['id_produto']));
    $id_pedido = mysqli_real_escape_string($conn, trim($_POST['id_pedido']));
    $qtde = mysqli_real_escape_string($conn, trim($_POST['qtde']));

    if (empty($id_produto) || empty($id_pedido) || empty($qtde)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        $verifica_estoque = "SELECT qtde_estoque FROM produto WHERE id = '$id_produto'";
        $resultado_estoque = mysqli_query($conn, $verifica_estoque);
        $produto = mysqli_fetch_assoc($resultado_estoque);

        if (!$produto) {
            $erro = "Produto não encontrado.";
        } elseif ($produto['qtde_estoque'] < $qtde) {
            $erro = "Quantidade insuficiente no estoque.";
        } else {
 
            $novo_estoque = $produto['qtde_estoque'] - $qtde;
            $atualiza_estoque = "UPDATE produto SET qtde_estoque = '$novo_estoque' WHERE id = '$id_produto'";
            mysqli_query($conn, $atualiza_estoque);

            $sql = "INSERT INTO itens_pedido (id_produto, id_pedido, qtde) 
                    VALUES ('$id_produto', '$id_pedido', '$qtde')";

            if (mysqli_query($conn, $sql)) {
                $sucesso = "Item adicionado ao pedido com sucesso!";
            } else {
                $erro = "Erro ao adicionar item ao pedido: " . mysqli_error($conn);
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
    <title>Incluir Item no Pedido</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Cadastro de Item no Pedido</h1>

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

    <form action="inclusao_itens_pedido.php" method="POST">
        <div class="form-group">
            <label for="id_produto">Produto</label>
            <select class="form-control" id="id_produto" name="id_produto" required>
                <option value="">Selecione o Produto</option>
                <?php
                $query_produtos = "SELECT id, nome FROM produto";
                $resultado_produtos = mysqli_query($conn, $query_produtos);
                while ($produto = mysqli_fetch_assoc($resultado_produtos)) {
                    echo "<option value='{$produto['id']}'>{$produto['nome']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_pedido">Pedido</label>
            <select class="form-control" id="id_pedido" name="id_pedido" required>
                <option value="">Selecione o Pedido</option>
                <?php
                $query_pedidos = "SELECT id, data FROM pedidos";
                $resultado_pedidos = mysqli_query($conn, $query_pedidos);
                while ($pedido = mysqli_fetch_assoc($resultado_pedidos)) {
                    echo "<option value='{$pedido['id']}'>Pedido #{$pedido['id']} - {$pedido['data']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="qtde">Quantidade</label>
            <input type="number" class="form-control" id="qtde" name="qtde" min="1" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Adicionar Item</button>
        <a href="index_itens_pedido.php" class="btn btn-secondary">Retornar</a>
    </form>
</div>

<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
