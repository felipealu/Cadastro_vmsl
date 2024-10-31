<?php
    require_once 'config.php';
    
    //     print_r($_POST['nome']);
    //     print_r('<br>');
    //     print_r($_POST['identificacao']);
    //     print_r('<br>');
    //     print_r($_POST['veiculo']);
    //     print_r('<br>');
    //

    // if(!$conexao){
    //     die("Erro de conexão:" . $conexao->connect_error);
    // }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $identificacao = $_POST["identificacao"];
        $veiculo = $_POST["veiculo"];
        $placa = $_POST["placa"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        
        if (isset($_POST['sit_escola']) && $_POST['sit_escola'] !== '') {
            $sit_escola = 1;
        } else {
            $sit_escola = 0;
        }

        
        
    
        $result = mysqli_query($conexao, "INSERT INTO entrada_saida (idcadastro, nome, identificacao, veiculo, placa, rua, numero, sit_escola, entrada,saida) VALUES (NULL, '$nome', '$identificacao', '$veiculo', '$placa', '$rua', '$numero', '$sit_escola', NOW(), NOW())");

        if (!$result) {
            return("Erro ao inserir dados: " . mysqli_error($conexao));
        }
          // Redirecionar para uma página diferente pq toda vez que eu apertava f5 duplicava a inserção
        header("Location: leitor.php");
         exit;
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
        <form action=" " method="POST">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Nome Completo" /><br /><br />
            <div id="sugestoes"></div>

            <label for="identificacao">Identificação:</label>
            <input type="text" id="identificacao" name="identificacao" placeholder="CPF" /><br /><br />


            <label for="veiculo">Veículo:</label>
            <input type="text" id="veiculo" name="veiculo" placeholder="Veiculo" /><br /><br />

            <label for="placa">Placa:</label>
            <input type="text" id="placa" name="placa" placeholder="Placa" /><br /><br />


            <label for="rua">Escolha uma Rua:</label>

            <select id="rua" name="rua">
                <option value="">Selecione a Rua...</option>
                <option value="RUA CEL SILIO PORTELA">RUA CEL SILIO PORTELA</option>
                <option value="RUA GEN PONDÉ">RUA GEN PONDÉ</option>
                <option value="RUA GEN WEDMAN">RUA GEN WEDMAN</option>
                <option value="RUA CEL AQUILES PERDENEIRAS">RUA CEL AQUILES PERDENEIRAS</option>

            </select><br /><br />

            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero" placeholder="Número" /><br /><br />

            <label for="sit_escola">Cadastro Escolar:</label> <br />
            <input type="checkbox" id="sit_escola" name="sit_escola" value="true" /><br /><br />
            <a id="saida" href="lista_registro.php"> Saida</a> <br /><br />
            <a id="relatorio" href="relatorio.php"> Relatório</a> <br /><br />
            <input type="hidden" name="token" value="<?php echo uniqid(); ?>">
            <button type="submit" id="register" nome="submit">Cadastrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
    <script src="leitor.js"></script>
    
    <script>
    navigator.mediaDevices.getUserMedia({
            video: true
        })
        .then(stream => {
            console.log('Câmera acessada com sucesso!');
        })
        .catch(error => {
            console.error('Erro ao acessar a câmera:', error);
        });
    </script>
    
    <script>
    // Função para redirecionar para a página do gerador
    document.getElementById("irparagerar")
        .addEventListener("click", function() {
            // Substitua pelo nome do seu arquivo
            window.location.href = "gen2.php";
        });
    </script>

     <!-- Conteúdo do site -->
   
    

    <script>
    // cadastra individualmente cada informação ao apertar "cadastrar"
    document.getElementById("submit").addEventListener("click", function() {
        const nome = document.getElementById("nome").value;
        const identificacao = document.getElementById("identificacao").value;
        const veiculo = document.getElementById("veiculo").value;
        const placa = document.getElementById("placa").value;
        const options = document.getElementById("rua").value;
        const numero = document.getElementById("numero").value;
        const sit_escola = document.getElementById("sit_escola").value;


        // Verifica se os campos estão preenchidos
        if (nome && identificacao && veiculo && placa && rua && numero && sit_escola) {
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
                    identificacao) + "&veiculo=" + encodeURIComponent(veiculo) + "&placa=" +
                encodeURIComponent(placa) + "&rua=" +
                encodeURIComponent(
                    options) + "&numero=" + encodeURIComponent(numero) + "&sit_escola=" +
                encodeURIComponent(sit_escola));
        }
    });
    </script>



    <script>
    // Sugestões e autocomplete dos outros campos 
    const inputNome = document.getElementById('nome');
    const inputIdentificacao = document.getElementById('identificacao');
    const inputVeiculo = document.getElementById('veiculo');
    const inputPlaca = document.getElementById('placa');
    const checkboxSituacao = document.getElementById('sit_escola');
    const sugestoes = document.getElementById('sugestoes');

    inputNome.addEventListener('keyup', function() {
        const nome = inputNome.value.trim();
        if (nome !== '') {
            fetch('buscar.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        nome: nome
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const sugestoesHtml = data.map(sugestao => {
                        return `<li>${sugestao.nome}</li>`;
                    }).join('');
                    sugestoes.innerHTML = `<ul>${sugestoesHtml}</ul>`;
                    sugestoes.style.display = 'block';
                })
                .catch(error => console.error(error));
        } else {
            sugestoes.style.display = 'none';
        }
    });

    sugestoes.addEventListener('click', function(event) {
        if (event.target.tagName === 'LI') {
            const nomeSelecionado = event.target.textContent;
            inputNome.value = nomeSelecionado;
            sugestoes.style.display = 'none';
            buscarInformacoes(nomeSelecionado);
        }
    });

    function buscarInformacoes(nome) {
        fetch('buscar-informacoes.php', {
                method: 'POST',
                body: new URLSearchParams({
                    nome: nome
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Verifique se os dados estão sendo lidos corretamente
                inputIdentificacao.value = data.identificacao;
                inputVeiculo.value = data.veiculo;
                inputPlaca.value = data.placa;
                checkboxSituacao.checked = data.sit_escola === '1' ? true :
                    false; // code para consguir o valor do checkbox
            })
            .catch(error => console.error(error));
    }
    </script>

    <script>
    // Oculta as sugestões
    window.addEventListener('load', function() {
        const sugestoes = document.getElementById('sugestoes');
        sugestoes.style.display = 'none';
    });
    </script>


</body>

</html>
