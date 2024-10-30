<?php
    
    $conn = mysqli_connect("localhost", "root", "admin", "qrvila");

    $nome = $_POST["nome"];

    $query = "SELECT identificacao, veiculo, placa, sit_escola FROM cadastro WHERE nome = '$nome'";
    $result = mysqli_query($conn, $query);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    }

    echo json_encode($data[0]); // Retorna apenas o primeiro elemento do array

?>
