
<?php
require_once 'tcpdf/tcpdf.php';

session_start();
include_once('config.php');
// print_r($_SESSION);
;
    
// $logado = $_SESSION['nome'];
if(!empty($_GET['search']))
{
    $data = $_GET['search'];
    $sql = "SELECT * FROM relatorio WHERE nome LIKE '%$data%' or identificacao LIKE '%$data%' or veiculo LIKE '%$data%' or placa LIKE '%$data%' or rua LIKE '%$data%' or numero LIKE '%$data%' or sit_escola LIKE '%$data%' or entrada LIKE '%$data%' or saida LIKE '%$data%' ORDER BY saida DESC";
}
else
{
    $sql = "SELECT * FROM relatorio ORDER BY saida DESC";
}
$result = $conexao->query($sql);
    
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Seu Nome');
$pdf->SetTitle('Relatório de Registros');
$pdf->SetSubject('Relatório');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Criar a página
$pdf->AddPage('L', 'A4');

// ... resto do código ...

while($user_data = mysqli_fetch_assoc($result)) {
    $nome_width = $pdf->GetStringWidth($user_data['nome']);
    if (!isset($max_nome_width) || $nome_width > $max_nome_width) {
        $max_nome_width = $nome_width;
    }
}

// Voltar para o início do resultado
mysqli_data_seek($result, 0);
// Definir a cor de fundo do cabeçalho
$pdf->SetFillColor(200, 200, 200); // Cinza claro

// Definir a cor do texto do cabeçalho
$pdf->SetTextColor(50, 50, 50); // Preto escuro

// Imprimir o cabeçalho
$pdf->Cell($max_nome_width + 10, 10, 'Nome', 1, 0, 'C', true); // Coluna 1
$pdf->Cell(30, 10, 'Identificação', 1, 0, 'C', true); // Coluna 2
$pdf->Cell(20, 10, 'Veículo', 1, 0, 'C', true); // Coluna 3
$pdf->Cell(17, 10, 'Placa', 1, 0, 'C', true); // Coluna 4
$pdf->Cell(57, 10, 'Rua', 1, 0, 'C', true); // Coluna 5
$pdf->Cell(10, 10, 'N°', 1, 0, 'C', true); // Coluna 6
$pdf->Cell(35, 10, 'Entrada', 1, 0, 'C', true); // Coluna 7
$pdf->Cell(37, 10, 'Saída', 1, 1, 'C', true); // Coluna 8

$pdf->SetFont('Helvetica', '', 10);

while($user_data = mysqli_fetch_assoc($result)) {
    $pdf->Cell($max_nome_width + 10, 10, $user_data['nome'], 1, 0, 'L'); // Coluna 1
    $pdf->Cell(30, 10, $user_data['identificacao'], 1, 0, 'L'); // Coluna 2
    $pdf->Cell(20, 10, $user_data['veiculo'], 1, 0, 'L'); // Coluna 3
    $pdf->Cell(17, 10, $user_data['placa'], 1, 0, 'L'); // Coluna 4
    $pdf->Cell(57, 10, $user_data['rua'], 1, 0, 'L'); // Coluna 5
    $pdf->Cell(10, 10, $user_data['numero'], 1, 0, 'L'); // Coluna 6
    $pdf->Cell(35, 10, date('d/m/Y H:i:s', strtotime($user_data['entrada'])), 1, 0, 'L'); // Coluna 7
    $pdf->Cell(37, 10, date('d/m/Y H:i:s', strtotime($user_data['saida'])), 1, 1, 'L'); // Coluna 8
}

$pdf->Output('relatorio.pdf', 'I');

?>
