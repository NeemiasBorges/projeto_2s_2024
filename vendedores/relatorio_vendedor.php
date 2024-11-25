<?php
require_once(__DIR__ . '/../dompdf/vendor/autoload.php');  // Caminho para o autoload do Dompdf
include('../config/conexao.php');  // Inclui a conexão com o banco de dados

use Dompdf\Dompdf;
use Dompdf\Options;

$erro = "";

// Consulta para buscar os dados dos vendedores
$sql = "SELECT nome, perc_comissa FROM vendedor";
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
        <title>Relatório de Vendedores</title>
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
        <h1>Relatório de Vendedores</h1>
        <table>
            <thead>
                <tr>
                    <th>Nome do Vendedor</th>
                    <th>Comissão (%)</th>
                </tr>
            </thead>
            <tbody>';

if ($result && mysqli_num_rows($result) > 0) {
    while ($vendedor = mysqli_fetch_assoc($result)) {
        $html .= '<tr>
                    <td>' . $vendedor['nome'] . '</td>
                    <td>' . $vendedor['perc_comissa'] . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="2">Nenhum vendedor encontrado.</td></tr>';
}

$html .= '
            </tbody>
        </table>
    </body>
    </html>';

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("relatorio_vendedor.pdf", array("Attachment" => 0));
?>
