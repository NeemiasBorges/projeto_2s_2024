<?php 
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_item'])) {
    $id_item = $_POST['id_item'];

    $sql_item = "SELECT * FROM itens_pedido WHERE id_item = ?";
    $stmt = mysqli_prepare($conn, $sql_item);
    mysqli_stmt_bind_param($stmt, 'i', $id_item);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $item = mysqli_fetch_assoc($result);

    if (!$item) {
        $erro = "Item de pedido não encontrado!";
    } else {

        $sql_delete = "DELETE FROM itens_pedido WHERE id_item = ?";
        $stmt = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt, 'i', $id_item);
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Item de pedido excluído com sucesso!";
        } else {
            $erro = "Erro ao excluir item de pedido: " . mysqli_error($conn);
        }
    }
}

$sql = "
    SELECT 
        ip.id_item, 
        ip.qtde, 
        p.nome AS produto, 
        ped.id AS pedido 
    FROM 
        itens_pedido ip
    INNER JOIN produto p ON ip.id_produto = p.id
    INNER JOIN pedidos ped ON ip.id_pedido = ped.id
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Item de Pedido</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Excluir Item de Pedido</h1>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $sucesso; ?>
        </div>
        <a href="index_itens_pedido.php" class="btn btn-primary">Voltar para menu</a>
    <?php else: ?>
        <!-- Formulário para selecionar o item de pedido -->
        <form action="exclusao_itens_pedido.php" method="POST">
            <div class="form-group">
                <label for="id_item">Selecione o Item de Pedido</label>
                <select name="id_item" id="id_item" class="form-control" required>
                    <option value="">...</option>
                    <?php while ($item = mysqli_fetch_assoc($result)): ?>
                        <option value="<?php echo $item['id_item']; ?>">
                            <?php echo "Item: " . $item['id_item'] . " | Pedido: " . $item['pedido'] . " | Produto: " . $item['produto']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Excluir Item</button>
        </form>
        <li class="nav-item">
            <a class="nav-link" href="index_itens_pedido.php">Retornar</a>
        </li>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
