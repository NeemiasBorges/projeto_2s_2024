<?php
require_once(__DIR__ . '/../dompdf/vendor/autoload.php'); 
include('../config/conexao.php'); 

use Dompdf\Dompdf;
use Dompdf\Options;

$erro = "";

$sql = "
    SELECT 
        p.id AS pedido_id,
        p.data AS pedido_data,
        p.id_cliente,
        p.observacao,
        p.forma_pagto,
        p.prazo_entrega,
        p.id_vendedor,
        i.qtde AS item_quantidade,
        pr.nome AS produto_nome,
        pr.preco AS produto_preco,
        pr.unidade_medida
    FROM pedidos p
    LEFT JOIN itens_pedido i ON p.id = i.id_pedido
    LEFT JOIN produto pr ON i.id_produto = pr.id
    ORDER BY p.id, pr.nome;
";

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
        <title>Relatório de Pedidos</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f9;
            }
            h1 {
                text-align: center;
                background-color: #6a0dad;
                color: white;
                padding: 10px 0;
                margin: 0;
            }
            .container {
                padding: 20px;
                margin: auto;
                width: 90%;
                background: white;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 14px;
            }
            th, td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }
            th {
                background-color: #6a0dad;
                color: white;
            }
            .pedido-header {
                background-color: #e9ecef;
                font-weight: bold;
                text-align: left;
                padding: 10px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <h1>Relatório de Pedidos</h1>
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Pedido ID</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Forma de Pagamento</th>
                        <th>Prazo de Entrega</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>';

if ($result && mysqli_num_rows($result) > 0) {
    $currentPedidoId = null;

    while ($row = mysqli_fetch_assoc($result)) {
        if ($currentPedidoId !== $row['pedido_id']) {
            $currentPedidoId = $row['pedido_id'];

            $html .= '
                <tr class="pedido-header">
                    <td>' . $row['pedido_id'] . '</td>
                    <td>' . date('d/m/Y', strtotime($row['pedido_data'])) . '</td>
                    <td>' . htmlspecialchars($row['id_cliente']) . '</td>
                    <td>' . htmlspecialchars($row['forma_pagto']) . '</td>
                    <td>' . ($row['prazo_entrega'] ? date('d/m/Y', strtotime($row['prazo_entrega'])) : 'Não informado') . '</td>
                    <td>' . htmlspecialchars($row['observacao']) . '</td>
                </tr>
                <tr>
                    <th colspan="6">Itens do Pedido</th>
                </tr>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Unidade de Medida</th>
                    <th>Subtotal</th>
                </tr>';
        }

        if ($row['produto_nome']) {
            $subtotal = $row['item_quantidade'] * $row['produto_preco'];
            $html .= '
                <tr>
                    <td>' . htmlspecialchars($row['produto_nome']) . '</td>
                    <td>' . $row['item_quantidade'] . '</td>
                    <td>R$ ' . number_format($row['produto_preco'], 2, ',', '.') . '</td>
                    <td>' . htmlspecialchars($row['unidade_medida']) . '</td>
                    <td>R$ ' . number_format($subtotal, 2, ',', '.') . '</td>
                </tr>';
        }
    }
} else {
    $html .= '<tr><td colspan="6">Nenhum pedido encontrado.</td></tr>';
}

$html .= '
                </tbody>
            </table>
        </div>
    </body>
    </html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("relatorio_pedidos.pdf", array("Attachment" => 0));
?>
