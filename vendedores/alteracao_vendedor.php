<?php
include('../config/conexao.php');

$erro = "";
$sucesso = "";

if (isset($_GET['id'])) {
    $id_vendedor = $_GET['id'];
    $sql = "SELECT * FROM vendedor WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_vendedor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $vendedor = mysqli_fetch_assoc($result);

    if (!$vendedor) {
        $erro = "Vendedor não encontrado!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $dados = [
        'nome' => $_POST['nome'],
        'endereco' => $_POST['endereco'],
        'cidade' => $_POST['cidade'],
        'estado' => $_POST['estado'],
        'celular' => $_POST['celular'],
        'email' => $_POST['email'],
        'perc_comissa' => $_POST['perc_comissa'],  
        'setor' => $_POST['setor'],
        'sexo' => $_POST['sexo']
    ];

    foreach ($dados as $key => $value) {
        if (empty($value)) {
            $erro = "Todos os campos são obrigatórios!";
            break;
        }
    }

    if (empty($erro)) {
        $sql = "UPDATE vendedor SET 
                nome = ?, endereco = ?, cidade = ?, estado = ?, celular = ?, email = ?, perc_comissa = ?, setor = ?, sexo = ? WHERE id = ?"; // Alterado para perc_comissa
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssssssi', $dados['nome'], $dados['endereco'], $dados['cidade'],
                               $dados['estado'], $dados['celular'], $dados['email'], $dados['perc_comissa'],
                               $dados['setor'], $dados['sexo'], $id_vendedor);
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Vendedor alterado com sucesso!";
        } else {
            $erro = "Erro ao alterar vendedor: " . mysqli_error($conn);
        }
    }
}

$sql_vendedores = "SELECT * FROM vendedor";
$result_vendedores = mysqli_query($conn, $sql_vendedores);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../config/style.css" rel="stylesheet">
    <title>Alterar Vendedor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
 
    </style>
</head>
<body>

<div class="container">
    <h1>Alterar Vendedor</h1>

    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php endif; ?>

    <?php if ($sucesso): ?>
        <div class="alert alert-success"><?= $sucesso ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Setor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($vendedor_db = mysqli_fetch_assoc($result_vendedores)): ?>
                <tr>
                    <td><?= $vendedor_db['id'] ?></td>
                    <td><?= $vendedor_db['nome'] ?></td>
                    <td><?= $vendedor_db['setor'] ?></td>
                    <td>
                        <a href="alteracao_vendedor.php?id=<?= $vendedor_db['id'] ?>" class="btn btn-warning btn-sm">Alterar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if (isset($vendedor)): ?>
        <h3>Alterar Vendedor ID: <?= $vendedor['id'] ?></h3>
        <form action="alteracao_vendedor.php?id=<?= $vendedor['id'] ?>" method="POST">
            <?php 
                $campos = [
                    'nome' => 'Nome',
                    'endereco' => 'Endereço',
                    'cidade' => 'Cidade',
                    'estado' => 'Estado',
                    'celular' => 'Celular',
                    'email' => 'Email',
                    'perc_comissa' => 'Percentual de Comissão',  // Alterado para perc_comissa
                    'setor' => 'Setor',
                    'sexo' => 'Sexo'
                ];
                
                foreach ($campos as $campo => $label): ?>
                    <div class="form-group">
                        <label for="<?= $campo ?>"><?= $label ?></label>
                        <input type="text" id="<?= $campo ?>" name="<?= $campo ?>" value="<?= $vendedor[$campo] ?>" required>
                    </div>
                <?php endforeach; ?>

            <button type="submit">Alterar Vendedor</button>
            <li class="nav-item">
                <a class="nav-link" href="index_vendedor.php">Retornar</a>
            </li>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
