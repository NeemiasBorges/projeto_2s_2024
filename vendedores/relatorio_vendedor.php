<?php 
require_once(__DIR__ . '/../dompdf/vendor/autoload.php');
include('../config/conexao.php');

use Dompdf\Dompdf;
use Dompdf\Options;

// Recebe as datas via GET ou POST
$dataInicio = $_GET['dataInicio'] ?? date('Y-m-d', strtotime('-7 days'));
$dataFim = $_GET['dataFim'] ?? date('Y-m-d');

$erro = "";

$sql = "SELECT 
    v.nome AS nome_vendedor,
    SUM(i.qtde * p.preco) AS total_vendido,
    v.perc_comissa AS percentual_comissao,
    SUM(i.qtde * p.preco * (v.perc_comissa / 100)) AS valor_comissao 
FROM 
    pedidos pe
JOIN 
    itens_pedido i ON pe.id = i.id_pedido
JOIN 
    produto p ON i.id_produto = p.id
JOIN 
    vendedor v ON pe.id_vendedor = v.id
WHERE 
    pe.data BETWEEN '$dataInicio' AND '$dataFim'
GROUP BY 
    v.id, v.nome, v.perc_comissa;";

$result = mysqli_query($conn, $sql);

if (!$result) {
   $erro = "Erro ao executar a consulta: " . mysqli_error($conn);
}
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

$html = '
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Comissões por Vendedor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Relatório de Comissões por Vendedor</h1>
    <p>Período: ' . date('d/m/Y', strtotime($dataInicio)) . ' a ' . date('d/m/Y', strtotime($dataFim)) . '</p>
    <table>
        <thead>
            <tr>
                <th>Nome do Vendedor</th>
                <th>Total Vendido</th>
                <th>% Comissão</th>
                <th>Valor Comissão</th>
            </tr>
        </thead>
        <tbody>';

if ($result && mysqli_num_rows($result) > 0) {
    while ($vendedor = mysqli_fetch_assoc($result)) {
        $html .= '
            <tr>
                <td>' . htmlspecialchars($vendedor['nome_vendedor']) . '</td>
                <td>R$ ' . number_format($vendedor['total_vendido'], 2, ',', '.') . '</td>
                <td>' . number_format($vendedor['percentual_comissao'], 2, ',', '.') . '%</td>
                <td>R$ ' . number_format($vendedor['valor_comissao'], 2, ',', '.') . '</td>
            </tr>';
    }
} else {
    $html .= '<tr><td colspan="4">Nenhuma venda encontrada no período.</td></tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("relatorio_comissoes.pdf", array("Attachment" => 0));
?>