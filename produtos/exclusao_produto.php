<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

// Exclui o produto caso o formulário seja enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_produto'])) {
    $id_produto = $_POST['id_produto'];

    // Verifica se o produto existe no banco antes de excluir
    $sql_produto = "SELECT * FROM produto WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_produto);
    mysqli_stmt_bind_param($stmt, 'i', $id_produto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produto = mysqli_fetch_assoc($result);

    if (!$produto) {
        $erro = "Produto não encontrado!";
    } else {
        // Executa a exclusão
        $sql_delete = "DELETE FROM produto WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt, 'i', $id_produto);
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Produto excluído com sucesso!";
        } else {
            $erro = "Erro ao excluir produto: " . mysqli_error($conn);
        }
    }
}

// Recupera todos os produtos para preencher o select
$sql = "SELECT id, nome FROM produto";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Produto</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Excluir Produto</h1>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $sucesso; ?>
        </div>
        <a href="index_produto.php" class="btn btn-primary">Voltar para menu</a>
    <?php else: ?>
        <!-- Formulário para selecionar o produto -->
        <form action="exclusao_produto.php" method="POST">
            <div class="form-group">
                <label for="id_produto">Selecione o Produto</label>
                <select name="id_produto" id="id_produto" class="form-control" required>
                    <option value="">... </option>
                    <?php while ($produto = mysqli_fetch_assoc($result)): ?>
                        <option value="<?php echo $produto['id']; ?>"><?php echo $produto['id'] . " - " . $produto['nome']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Excluir Produto</button>
        </form>
        <li class="nav-item">
            <a class="nav-link" href="index_produto.php">Retornar</a>
        </li>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
