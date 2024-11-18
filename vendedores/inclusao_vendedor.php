<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta e sanitiza os dados do formulário
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $endereco = mysqli_real_escape_string($conn, trim($_POST['endereco']));
    $cidade = mysqli_real_escape_string($conn, trim($_POST['cidade']));
    $estado = mysqli_real_escape_string($conn, trim($_POST['estado']));
    $celular = mysqli_real_escape_string($conn, trim($_POST['celular']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $perc_comissa = mysqli_real_escape_string($conn, trim($_POST['perc_comissa']));
    $setor = mysqli_real_escape_string($conn, trim($_POST['setor']));
    $sexo = mysqli_real_escape_string($conn, trim($_POST['sexo']));
    
    // Verifica se os campos obrigatórios não estão vazios
    if (empty($nome) || empty($endereco) || empty($cidade) || empty($estado) || empty($celular) || empty($email) || empty($perc_comissa) || empty($setor) || empty($sexo)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        // Prepara o SQL para inserir os dados na tabela de vendedores
        $sql = "INSERT INTO vendedor (nome, endereco, cidade, estado, celular, email, perc_comissa, setor, sexo) 
                VALUES ('$nome', '$endereco', '$cidade', '$estado', '$celular', '$email', '$perc_comissa', '$setor', '$sexo')";
        
        if (mysqli_query($conn, $sql)) {
            $sucesso = "Vendedor cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar vendedor: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incluir Vendedor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Cadastro de Vendedor</h1>

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

    <form action="inclusao_vendedor.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" required>
        </div>
        <div class="form-group">
            <label for="cidade">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" required>
        </div>
        <div class="form-group">
            <label for="celular">Celular</label>
            <input type="text" class="form-control" id="celular" name="celular" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="perc_comissa">Percentual de Comissão</label>
            <input type="text" class="form-control" id="perc_comissa" name="perc_comissa" required>
        </div>
        <div class="form-group">
            <label for="setor">Setor</label>
            <input type="text" class="form-control" id="setor" name="setor" required>
        </div>
        <div class="form-group">
            <label for="sexo">Sexo</label>
            <select class="form-control" id="sexo" name="sexo" required>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
                <option value="O">Outro</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Cadastrar Vendedor</button>
        <li class="nav-item">
                <a class="nav-link" href="index_vendedor.php">Retornar</a>
        </li>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
