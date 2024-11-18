<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];
    $sql = "SELECT * FROM produto WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_produto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produto = mysqli_fetch_assoc($result);

    if (!$produto) {
        $erro = "Produto não encontrado!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $dados = [
        'nome' => $_POST['nome'],
        'qtde_estoque' => $_POST['qtde_estoque'],
        'preco' => $_POST['preco'],
        'unidade_medida' => $_POST['unidade_medida'],
        'promocao' => $_POST['promocao']
    ];

    foreach ($dados as $key => $value) {
        if (empty($value)) {
            $erro = "Todos os campos são obrigatórios!";
            break;
        }
    }

    if (empty($erro)) {
        $sql = "UPDATE produto SET 
                nome = ?, qtde_estoque = ?, preco = ?, unidade_medida = ?, promocao = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sidssi', $dados['nome'], $dados['qtde_estoque'], $dados['preco'], 
                               $dados['unidade_medida'], $dados['promocao'], $id_produto);
        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Produto alterado com sucesso!";
        } else {
            $erro = "Erro ao alterar produto: " . mysqli_error($conn);
        }
    }
}

$sql_produtos = "SELECT * FROM produto";
$result_produtos = mysqli_query($conn, $sql_produtos);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../config/style.css" rel="stylesheet">
    <title>Alterar Produto</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
   
<body>

<div class="container">
    <h1>Alterar Produto</h1>


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
                <th>Quantidade em Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($produto_db = mysqli_fetch_assoc($result_produtos)): ?>
                <tr>
                    <td><?= $produto_db['id'] ?></td>
                    <td><?= $produto_db['nome'] ?></td>
                    <td><?= $produto_db['qtde_estoque'] ?></td>
                    <td>
                        <a href="alteracao_produto.php?id=<?= $produto_db['id'] ?>" class="btn btn-warning btn-sm">Alterar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if (isset($produto)): ?>
        <h3>Alterar Produto ID: <?= $produto['id'] ?></h3>
        <form action="alteracao_produto.php?id=<?= $produto['id'] ?>" method="POST">
            <?php 
                $campos = [
                    'nome' => 'Nome',
                    'qtde_estoque' => 'Quantidade em Estoque',
                    'preco' => 'Preço',
                    'unidade_medida' => 'Unidade de Medida',
                    'promocao' => 'Promoção (0 ou 1)'
                ];
                
                foreach ($campos as $campo => $label): ?>
                    <div class="form-group">
                        <label for="<?= $campo ?>"><?= $label ?></label>
                        <input type="text" id="<?= $campo ?>" name="<?= $campo ?>" value="<?= $produto[$campo] ?>" required>
                    </div>
                <?php endforeach; ?>

            <button type="submit">Alterar Produto</button>
            <li class="nav-item">
                <a class="nav-link" href="index_produto.php">Retornar</a>
        </li>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
