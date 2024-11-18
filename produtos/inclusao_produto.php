<?php
include('../config/conexao.php'); 

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $qtde_estoque = mysqli_real_escape_string($conn, trim($_POST['qtde_estoque']));
    $preco = mysqli_real_escape_string($conn, trim($_POST['preco']));
    $unidade_medida = mysqli_real_escape_string($conn, trim($_POST['unidade_medida']));
    $promocao = mysqli_real_escape_string($conn, trim($_POST['promocao']));

    if (empty($nome) || empty($qtde_estoque) || empty($preco) || empty($unidade_medida) || empty($promocao)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        $sql = "INSERT INTO produto (nome, qtde_estoque, preco, unidade_medida, promocao) 
                VALUES ('$nome', '$qtde_estoque', '$preco', '$unidade_medida', '$promocao')";
        
        if (mysqli_query($conn, $sql)) {
            $sucesso = "Produto cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar produto: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet">
    
    <style>
        .form-group input[type="number"] {
            padding: 12px;
            font-size: 1.2rem;
            border-radius: 8px;
            border: 2px solid #c8c8c8; 
            background-color: #f7f7f7;
            width: 100%;
            transition: all 0.3s ease;
        }

        .form-group input[type="number"]:focus {
            border-color: #007bff; 
            background-color: #e9ecef; 
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Cadastro de Produto</h1>

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

    <form action="inclusao_produto.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="qtde_estoque">Quantidade em Estoque</label>
            <input type="number" class="form-control" id="qtde_estoque" name="qtde_estoque" required>
        </div>
        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="text" class="form-control" id="preco" name="preco" required>
        </div>
        <div class="form-group">
            <label for="unidade_medida">Unidade de Medida</label>
            <input type="text" class="form-control" id="unidade_medida" name="unidade_medida" required>
        </div>
        <div class="form-group">
            <label for="promocao">Promoção</label>
            <select class="form-control" id="promocao" name="promocao" required>
                <option value="Sim">Sim</option>
                <option value="Não">Não</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
        <a href="../index.php" class="btn btn-secondary">Retornar</a>
    </form>
</div>

<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
