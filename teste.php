<?php
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
    
    // Função para apagar as informações que passarem da validade de 90 dias
    function apagarInformacoes() {
      $dataExpiracao = date('Y-m-d', strtotime('-90 days'));

      $query = "DELETE FROM relatorio WHERE data < '$dataExpiracao'";
      $conexao->query($query);

      if ($conexao->affected_rows > 0) {
        echo "Informações apagadas com sucesso!";
      }
    }
