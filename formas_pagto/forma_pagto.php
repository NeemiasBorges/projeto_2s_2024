<?php
include('../config/conexao.php'); // Inclui a conexão com o banco de dados

$erro = "";
$sucesso = "";

// Adiciona uma nova forma de pagamento
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome']) && isset($_POST['data'])) {
    $nome = $_POST['nome'];
    $data = $_POST['data'];

    // Verifica se os campos estão preenchidos
    if (empty($nome) || empty($data)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        // Insere a nova forma de pagamento
        $sql_insert = "INSERT INTO forma_pagto (data, nome) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt, 'ss', $data, $nome);

        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Forma de pagamento adicionada com sucesso!";
        } else {
            $erro = "Erro ao adicionar forma de pagamento: " . mysqli_error($conn);
        }
    }
}

// Exclui a forma de pagamento caso o formulário seja enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_forma_pagto_excluir'])) {
    $id_forma_pagto = $_POST['id_forma_pagto_excluir'];

    // Verifica se a forma de pagamento existe no banco antes de excluir
    $sql_pagto = "SELECT * FROM forma_pagto WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_pagto);
    mysqli_stmt_bind_param($stmt, 'i', $id_forma_pagto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $forma_pagto = mysqli_fetch_assoc($result);

    if (!$forma_pagto) {
        $erro = "Forma de pagamento não encontrada!";
    } else {
        // Executa a exclusão
        $sql_delete = "DELETE FROM forma_pagto WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt, 'i', $id_forma_pagto);
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Forma de pagamento excluída com sucesso!";
        } else {
            $erro = "Erro ao excluir forma de pagamento: " . mysqli_error($conn);
        }
    }
}

// Recupera todas as formas de pagamento para preencher o select
$sql = "SELECT id, data, nome FROM forma_pagto";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Forma de Pagamento</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Gerenciar Forma de Pagamento</h1>

    <!-- Exibe erro, se houver -->
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <!-- Exibe sucesso, se houver -->
    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $sucesso; ?>
        </div>
    <?php endif; ?>

    <!-- Div para a inclusão de nova forma de pagamento -->
    <div class="inclusao">
        <h3>Adicionar Nova Forma de Pagamento</h3>
        <form action="forma_pagto.php" method="POST">
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" name="data" id="data" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Adicionar Forma de Pagamento</button>
        </form>
    </div>

    <hr>

    <!-- Bloco para exibição das tabelas -->
    <div class="tabelas">
        <!-- Tabela de formas de pagamento cadastradas -->
        <div class="tabela-inclusao">
            <h4>Formas de Pagamento Cadastradas</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result = mysqli_query($conn, $sql); // Reexecuta a consulta após adicionar
                    while ($forma_pagto = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $forma_pagto['id']; ?></td>
                            <td><?php echo $forma_pagto['data']; ?></td>
                            <td><?php echo $forma_pagto['nome']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Bloco para o formulário de exclusão -->
        <div class="tabela-exclusao">
            <h3>Excluir Forma de Pagamento</h3>
            <form action="forma_pagto.php" method="POST">
                <div class="form-group">
                    <label for="id_forma_pagto_excluir">Selecione a Forma de Pagamento</label>
                    <select name="id_forma_pagto_excluir" id="id_forma_pagto_excluir" class="form-control" required>
                        <option value="">Escolha...</option>
                        <?php 
                        // Reexecuta a consulta para preencher o select de exclusão
                        $result = mysqli_query($conn, $sql); 
                        while ($forma_pagto = mysqli_fetch_assoc($result)): ?>
                            <option value="<?php echo $forma_pagto['id']; ?>">
                                <?php echo $forma_pagto['id'] . " - " . $forma_pagto['nome'] . " (" . $forma_pagto['data'] . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-danger">Excluir Forma de Pagamento</button>
            </form>
        </div>
    </div>

    <hr>

    <a href="../index.php" class="btn btn-secondary">Retornar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
