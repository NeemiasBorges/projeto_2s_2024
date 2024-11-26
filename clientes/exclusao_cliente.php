<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_cliente'])) {
    $id_cliente = $_POST['id_cliente'];

    $sql_cliente = "SELECT * FROM clientes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_cliente);
    mysqli_stmt_bind_param($stmt, 'i', $id_cliente);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cliente = mysqli_fetch_assoc($result);

    if (!$cliente) {
        $erro = "Cliente não encontrado!";
    } else {
        $sql_delete = "DELETE FROM clientes WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt, 'i', $id_cliente);
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Cliente excluído com sucesso!";
        } else {
            $erro = "Erro ao excluir cliente: " . mysqli_error($conn);
        }
    }
}

$sql = "SELECT id, nome FROM clientes";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Excluir Cliente</h1>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $sucesso; ?>
        </div>
        <a href="index_cliente.php" class="btn btn-primary">Voltar para menu</a>
    <?php else: ?>
        <!-- Formulário para selecionar o cliente -->
        <form action="exclusao_cliente.php" method="POST">
            <div class="form-group">
                <label for="id_cliente">Selecione o Cliente</label>
                <select name="id_cliente" id="id_cliente" class="form-control" required>
                    <option value="">... </option>
                    <?php while ($cliente = mysqli_fetch_assoc($result)): ?>
                        <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['id'] . " - " . $cliente['nome']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Excluir Cliente</button>
        </form>
        <li class="nav-item">
                <a class="nav-link" href="index_cliente.php">Retornar</a>
        </li>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
