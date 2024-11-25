<?php
include('../config/conexao.php');

$erro = "";
$sucesso = "";

$nome = isset($_POST['nome']) ? mysqli_real_escape_string($conn, $_POST['nome']) : '';
$endereco = isset($_POST['endereco']) ? mysqli_real_escape_string($conn, $_POST['endereco']) : '';
$cidade = isset($_POST['cidade']) ? mysqli_real_escape_string($conn, $_POST['cidade']) : '';

$result = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql = "SELECT id, nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario, sexo, estado_civil FROM clientes WHERE 1";

    if (!empty($nome)) {
        $sql .= " AND nome LIKE '%$nome%'";
    }
    if (!empty($endereco)) {
        $sql .= " AND endereco LIKE '%$endereco%'";
    }
    if (!empty($cidade)) {
        $sql .= " AND cidade LIKE '%$cidade%'";
    }

    $result = mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Clientes</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../config/style.css" rel="stylesheet"> <!-- Seu CSS externo -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>

<div class="container">
    <h1>Consulta de Clientes</h1>

    <!-- Formulário de filtro, sempre visível -->
    <form action="consulta_cliente.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
        </div>
        <div class="form-group">
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $endereco; ?>">
        </div>
        <div class="form-group">
            <label for="cidade">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $cidade; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <!-- Se houver clientes encontrados, exibe a tabela -->
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered mt-3 table-responsive" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Número</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>E-mail</th>
                    <th>CPF/CNPJ</th>
                    <th>RG</th>
                    <th>Telefone</th>
                    <th>Celular</th>
                    <th>Data Nascimento</th>
                    <th>Salário</th>
                    <th>Sexo</th>
                    <th>Estado Civil</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cliente = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $cliente['id']; ?></td>
                        <td><?php echo $cliente['nome']; ?></td>
                        <td><?php echo $cliente['endereco']; ?></td>
                        <td><?php echo $cliente['numero']; ?></td>
                        <td><?php echo $cliente['bairro']; ?></td>
                        <td><?php echo $cliente['cidade']; ?></td>
                        <td><?php echo $cliente['estado']; ?></td>
                        <td><?php echo $cliente['email']; ?></td>
                        <td><?php echo $cliente['cpf_cnpj']; ?></td>
                        <td><?php echo $cliente['rg']; ?></td>
                        <td><?php echo $cliente['telefone']; ?></td>
                        <td><?php echo $cliente['celular']; ?></td>
                        <td><?php echo $cliente['data_nasc']; ?></td>
                        <td><?php echo $cliente['salario']; ?></td>
                        <td><?php echo $cliente['sexo']; ?></td>
                        <td><?php echo $cliente['estado_civil']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <li class="nav-item">
            <a class="nav-link" href="index_cliente.php">Retornar</a>
        </li>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p class="mt-3">Nenhum cliente encontrado com os critérios informados.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

