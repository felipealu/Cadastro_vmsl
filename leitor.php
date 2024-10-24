<?php
    
    //     print_r($_POST['nome']);
    //     print_r('<br>');
    //     print_r($_POST['identificacao']);
    //     print_r('<br>');
    //     print_r($_POST['veiculo']);
    //     print_r('<br>');
    //
    require_once '/Users/felip/Desktop/Faculdade/cadastro_qr/start/config.php';

    // if(!$conexao){
    //     die("Erro de conexão:" . $conexao->connect_error);
    // }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $identificacao = $_POST["identificacao"];
        $veiculo = $_POST["veiculo"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $sit_escola = $_POST["sit_escola"];
        
    
        $result = mysqli_query($conexao, "INSERT INTO entrada_saida (idcadastro, nome, identificacao, veiculo, rua, numero, sit_escola, horario, dia) VALUES (NULL, '$nome', '$identificacao', '$veiculo', '$rua', '$numero', '$sit_escola', NOW(), CURDATE())");

        // if (!$result) {
        //     die("Erro ao inserir dados: " . mysqli_error($conexao));
        // }
    }
       
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leitor de QR Code com Cadastro</title>
    <link rel="stylesheet" href="leitor.css" />
</head>

<body>
    <div>
        <button id="irparagerar">Ir para o Gerador</button>
    </div>
    <h1>Leitor de QR Code e Cadastro</h1>
    <video id="video" width="200" height="200" autoplay></video>
    <canvas id="canvas" hidden></canvas>
    <p id="outputData">Aponte para um QR code</p>

    <!-- Formulário de Cadastro -->
    <div id="cadastro">
        <h3>Cadastro</h3>
        <form action="leitor.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" /><br /><br />

            <label for="identificacao">Identificação:</label>
            <input type="text" id="identificacao" name="identificacao" /><br /><br />

            <label for="veiculo">Veículo/Placa:</label>
            <input type="text" id="veiculo" name="veiculo" /><br /><br />

            <label for="options">Escolha uma Rua:</label>

            <select id="rua" name="rua">
                <option value="">Selecione a Rua...</option>
                <option value="RUA CEL SILIO PORTELA">RUA CEL SILIO PORTELA</option>
                <option value="RUA GEN PONDÉ">RUA GEN PONDÉ</option>
                <option value="RUA GEN WEDMAN">RUA GEN WEDMAN</option>
                <option value="RUA CEL AQUILES PERDENEIRAS">RUA CEL AQUILES PERDENEIRAS</option>
                <option value="option2"></option>
            </select><br /><br />

            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero" /><br /><br />

            <label for="sit_escola">Situação na Escola:</label> <br />
            <input type="checkbox" id="sit_escola" name="sit_escola" value="1" /><br /><br />

            <input type="hidden" name="token" value="<?php echo uniqid(); ?>">
            <button type="submit" id="register" nome="submit">Cadastrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
    <script src="leitor.js"></script>

    <script>
    // Fun o para redirecionar para a p gina do gerador
    document
        .getElementById("irparagerar")
        .addEventListener("click", function() {
            // Substitua pelo nome do seu arquivo
            window.location.href = "gen2.php";
        });
    </script>
    <script>
    document.getElementById("submit").addEventListener("click", function() {
        const nome = document.getElementById("nome").value;
        const identificacao = document.getElementById("identificacao").value;
        const veiculo = document.getElementById("veiculo").value;
        const options = document.getElementById("options").value;
        const numero = document.getElementById("numero").value;
        const sit_escola = document.getElementById("sit_escola").value;


        // Verifica se os campos estão preenchidos
        if (nome && identificacao && veiculo && options && numero && sit_escola) {
            // Faz uma requisição AJAX para o PHP
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "leitor.php");
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // Exibe a resposta do PHP
                    console.log(this.responseText);
                }
            };
            xhr.send("$nome=" + encodeURIComponent(nome) + "&identificacao=" + encodeURIComponent(
                    identificacao) + "&veiculo=" + encodeURIComponent(veiculo) + "&rua=" +
                encodeURIComponent(
                    options) + "&numero=" + encodeURIComponent(numero) + "&sit_escola=" +
                encodeURIComponent(sit_escola));
        }
    });
    </script>
</body>

</html>