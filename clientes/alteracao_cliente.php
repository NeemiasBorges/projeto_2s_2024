<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
    $sql = "SELECT * FROM clientes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_cliente);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cliente = mysqli_fetch_assoc($result);

    if (!$cliente) {
        $erro = "Cliente não encontrado!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $dados = [
        'nome' => $_POST['nome'],
        'endereco' => $_POST['endereco'],
        'numero' => $_POST['numero'],
        'bairro' => $_POST['bairro'],
        'cidade' => $_POST['cidade'],
        'estado' => $_POST['estado'],
        'email' => $_POST['email'],
        'cpf_cnpj' => $_POST['cpf_cnpj'],
        'rg' => $_POST['rg'],
        'telefone' => $_POST['telefone'],
        'celular' => $_POST['celular'],
        'data_nasc' => $_POST['data_nasc'],
        'salario' => $_POST['salario'],
        'sexo' => $_POST['sexo'],
        'estado_civil' => $_POST['estado_civil']
    ];

    foreach ($dados as $key => $value) {
        if (empty($value)) {
            $erro = "Todos os campos são obrigatórios!";
            break;
        }
    }

    if (empty($erro)) {
        $sql = "UPDATE clientes SET 
                nome = ?, endereco = ?, numero = ?, bairro = ?, cidade = ?, estado = ?, 
                email = ?, cpf_cnpj = ?, rg = ?, telefone = ?, celular = ?, data_nasc = ?, 
                salario = ?, sexo = ?, estado_civil = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssssssssssssi', $dados['nome'], $dados['endereco'], $dados['numero'], $dados['bairro'], 
                            $dados['cidade'], $dados['estado'], $dados['email'], $dados['cpf_cnpj'], $dados['rg'], $dados['telefone'],
                            $dados['celular'], $dados['data_nasc'], $dados['salario'], $dados['sexo'], $dados['estado_civil'], $id_cliente);
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Cliente alterado com sucesso!";
        } else {
            $erro = "Erro ao alterar cliente: " . mysqli_error($conn);
        }
    }
}

$sql_clientes = "SELECT * FROM clientes";
$result_clientes = mysqli_query($conn, $sql_clientes);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>
<body>

<div class="container">
    <h1>Alterar Cliente</h1>

    <!-- Exibe erro ou sucesso -->
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php endif; ?>

    <?php if ($sucesso): ?>
        <div class="alert alert-success"><?= $sucesso ?></div>
    <?php endif; ?>

    <!-- Tabela de clientes -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cliente_db = mysqli_fetch_assoc($result_clientes)): ?>
                <tr>
                    <td><?= $cliente_db['id'] ?></td>
                    <td><?= $cliente_db['nome'] ?></td>
                    <td><?= $cliente_db['endereco'] ?></td>
                    <td>
                        <a href="alteracao_cliente.php?id=<?= $cliente_db['id'] ?>" class="btn btn-warning btn-sm">Alterar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulário de alteração de cliente -->
    <?php if (isset($cliente)): ?>
        <h3 class="d-none">Alterar Cliente ID: <?= $cliente['id'] ?></h3>
        <form action="alteracao_cliente.php?id=<?= $cliente['id'] ?>" method="POST">
            <?php 
                $campos = [
                    'nome' => 'Nome',
                    'endereco' => 'Endereço',
                    'numero' => 'Número',
                    'bairro' => 'Bairro',
                    'cidade' => 'Cidade',
                    'estado' => 'Estado',
                    'email' => 'E-mail',
                    'cpf_cnpj' => 'CPF/CNPJ',
                    'rg' => 'RG',
                    'telefone' => 'Telefone',
                    'celular' => 'Celular',
                    'data_nasc' => 'Data de Nascimento',
                    'salario' => 'Salário',
                    'sexo' => 'Sexo',
                    'estado_civil' => 'Estado Civil'
                ];
                
                foreach ($campos as $campo => $label): ?>
                    <div class="form-group">
                        <label for="<?= $campo ?>"><?= $label ?></label>
                        <input type="text" id="<?= $campo ?>" name="<?= $campo ?>" value="<?= $cliente[$campo] ?>" required>
                    </div>
                <?php endforeach; ?>

            <button  type="submit">Alterar Cliente</button>
            <a class="nav-link btn btn-outline-success m-2" role="button" href="index_cliente.php">Retornar</a>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
