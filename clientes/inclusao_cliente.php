<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $endereco = mysqli_real_escape_string($conn, trim($_POST['endereco']));
    $numero = mysqli_real_escape_string($conn, trim($_POST['numero']));
    $bairro = mysqli_real_escape_string($conn, trim($_POST['bairro']));
    $cidade = mysqli_real_escape_string($conn, trim($_POST['cidade']));
    $estado = mysqli_real_escape_string($conn, trim($_POST['estado']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $cpf_cnpj = mysqli_real_escape_string($conn, trim($_POST['cpf_cnpj']));
    $rg = mysqli_real_escape_string($conn, trim($_POST['rg']));
    $telefone = mysqli_real_escape_string($conn, trim($_POST['telefone']));
    $celular = mysqli_real_escape_string($conn, trim($_POST['celular']));
    $data_nasc = mysqli_real_escape_string($conn, trim($_POST['data_nasc']));
    $salario = mysqli_real_escape_string($conn, trim($_POST['salario']));
    $sexo = mysqli_real_escape_string($conn, trim($_POST['sexo']));
    $estado_civil = mysqli_real_escape_string($conn, trim($_POST['estado_civil']));

    if (empty($nome) || empty($endereco) || empty($numero) || empty($bairro) || empty($cidade) || empty($estado) || empty($email) || empty($cpf_cnpj) || empty($rg) || empty($telefone) || empty($celular) || empty($data_nasc) || empty($salario) || empty($sexo) || empty($estado_civil)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        $sql = "INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario, sexo, estado_civil) 
                VALUES ('$nome', '$endereco', '$numero', '$bairro', '$cidade', '$estado', '$email', '$cpf_cnpj', '$rg', '$telefone', '$celular', '$data_nasc', '$salario', '$sexo', '$estado_civil')";
        
        if (mysqli_query($conn, $sql)) {
            $sucesso = "Cliente cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar cliente: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incluir Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">

</head>
<body>

<div class="container">
    <h1>Cadastro de Cliente</h1>

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

    <form action="inclusao_cliente.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" required>
        </div>
        <div class="form-group">
            <label for="numero">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" required>
        </div>
        <div class="form-group">
            <label for="bairro">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" required>
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
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="cpf_cnpj">CPF/CNPJ</label>
            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
        </div>
        <div class="form-group">
            <label for="rg">RG</label>
            <input type="text" class="form-control" id="rg" name="rg" required>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" required>
        </div>
        <div class="form-group">
            <label for="celular">Celular</label>
            <input type="text" class="form-control" id="celular" name="celular" required>
        </div>
        <div class="form-group">
            <label for="data_nasc">Data de Nascimento</label>
            <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
        </div>
        <div class="form-group">
            <label for="salario">Salário</label>
            <input type="text" class="form-control" id="salario" name="salario" required>
        </div>
        <div class="form-group">
            <label for="sexo">Sexo</label>
            <select class="form-control" id="sexo" name="sexo" required>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
                <option value="O">Outro</option>
            </select>
        </div>
        <div class="form-group">
            <label for="estado_civil">Estado Civil</label>
            <select class="form-control" id="estado_civil" name="estado_civil" required>
                <option value="Solteiro">Solteiro</option>
                <option value="Casado">Casado</option>
                <option value="Divorciado">Divorciado</option>
                <option value="Viúvo">Viúvo</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
        <li class="nav-item">
                <a class="nav-link" href="index_cliente.php">Retornar</a>
        </li>
    </form>

</div>
<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

