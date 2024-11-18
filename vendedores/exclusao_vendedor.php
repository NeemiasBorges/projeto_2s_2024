<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

// Exclui o vendedor caso o formulário seja enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_vendedor'])) {
    $id_vendedor = $_POST['id_vendedor'];

    // Verifica se o vendedor existe no banco antes de excluir
    $sql_vendedor = "SELECT * FROM vendedor WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_vendedor);
    mysqli_stmt_bind_param($stmt, 'i', $id_vendedor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $vendedor = mysqli_fetch_assoc($result);

    if (!$vendedor) {
        $erro = "Vendedor não encontrado!";
    } else {
        // Executa a exclusão
        $sql_delete = "DELETE FROM vendedor WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt, 'i', $id_vendedor);
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Vendedor excluído com sucesso!";
        } else {
            $erro = "Erro ao excluir vendedor: " . mysqli_error($conn);
        }
    }
}

// Recupera todos os vendedores para preencher o select
$sql = "SELECT id, nome FROM vendedor";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Vendedor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Excluir Vendedor</h1>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $sucesso; ?>
        </div>
        <a href="index_vendedor.php" class="btn btn-primary">Voltar para menu</a>
    <?php else: ?>
        <!-- Formulário para selecionar o vendedor -->
        <form action="exclusao_vendedor.php" method="POST">
            <div class="form-group">
                <label for="id_vendedor">Selecione o Vendedor</label>
                <select name="id_vendedor" id="id_vendedor" class="form-control" required>
                    <option value="">... </option>
                    <?php while ($vendedor = mysqli_fetch_assoc($result)): ?>
                        <option value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['id'] . " - " . $vendedor['nome']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Excluir Vendedor</button>
        </form>
        <li class="nav-item">
            <a class="nav-link" href="index_vendedor.php">Retornar</a>
        </li>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
