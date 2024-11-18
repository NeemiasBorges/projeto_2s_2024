<?php
include('../config/conexao.php');

$erro = "";
$sucesso = "";


$nome = isset($_POST['nome']) ? mysqli_real_escape_string($conn, $_POST['nome']) : '';
$preco = isset($_POST['preco']) ? mysqli_real_escape_string($conn, $_POST['preco']) : '';

$result = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql = "SELECT id, nome, qtde_estoque, preco, unidade_medida, promocao FROM produto WHERE 1";

    if (!empty($nome)) {
        $sql .= " AND nome LIKE '%$nome%'";
    }
    if (!empty($preco)) {
        $sql .= " AND preco LIKE '%$preco%'";
    }

    $result = mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Produtos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet"> <!-- Seu CSS externo -->
</head>
<body>

<div class="container">
    <h1>Consulta de Produtos</h1>

    <form action="consulta_produto.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
        </div>
        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="text" class="form-control" id="preco" name="preco" value="<?php echo $preco; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade em Estoque</th>
                    <th>Preço</th>
                    <th>Unidade de Medida</th>
                    <th>Promoção</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($produto = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $produto['qtde_estoque']; ?></td>
                        <td><?php echo $produto['preco']; ?></td>
                        <td><?php echo $produto['unidade_medida']; ?></td>
                        <td><?php echo $produto['promocao']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>

        <p class="mt-3">Nenhum produto encontrado com os critérios informados.</p>
    <?php endif; ?>
    <li class="nav-item">
                <a class="nav-link" href="index_produto.php">Retornar</a>
            </li>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
