<?php
// Carregar o autoload corretamente
require_once(__DIR__ . '/dompdf/vendor/autoload.php');

// Usar as classes do Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

// Inicializar o Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// Criar conteúdo HTML para o PDF
$html = '<h1>Teste de Relatório PDF</h1>';
$html .= '<p>Esse é um teste simples usando Dompdf.</p>';

// Carregar o HTML
$dompdf->loadHtml($html);

// Definir o tamanho do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();

// Exibir o PDF no navegador
$dompdf->stream("teste_relatorio.pdf", array("Attachment" => 0)); // 0 exibe no navegador, 1 força o download
?>
