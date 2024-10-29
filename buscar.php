<?php
$conn = mysqli_connect("localhost", "root", "admin", "qrvila");

$nome = $_POST["nome"];

$query = "SELECT nome FROM cadastro WHERE nome LIKE '%$nome%'";

$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

echo json_encode($data);
?>
