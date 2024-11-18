<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pedido'])) {
    $id_pedido = mysqli_real_escape_string($conn, trim($_POST['id_pedido']));

    if (empty($id_pedido)) {
        $erro = "ID do pedido é obrigatório!";
    } else {

        $sql = "DELETE FROM pedidos WHERE id = '$id_pedido'";

        if (mysqli_query($conn, $sql)) {
            $sucesso = "Pedido excluído com sucesso!";
        } else {
            $erro = "Erro ao excluir pedido: " . mysqli_error($conn);
        }
    }
}

$sql_pedidos = "SELECT id FROM pedidos";
$result_pedidos = mysqli_query($conn, $sql_pedidos);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão de Pedido</title>
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Excluir Pedido</h1>

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

    <form action="exclusao_pedido.php" method="POST">
        <div class="form-group">
            <label for="id_pedido">Selecione o ID do Pedido para Exclusão</label>
            <select class="form-control" id="id_pedido" name="id_pedido" required>
                <option value="">Selecione</option>
                <?php while ($pedido = mysqli_fetch_assoc($result_pedidos)): ?>
                    <option value="<?php echo $pedido['id']; ?>">
                        <?php echo $pedido['id']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Excluir Pedido</button>
        <a href="index_pedido.php" class="btn btn-secondary">Retornar</a>
    </form>
</div>
</body>
</html>
