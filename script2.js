// Campos do formulário de cadastro
const nomeField = document.getElementById("nome");
const identificacaoField = document.getElementById("identificacao");
const veiculoField = document.getElementById("veiculo");
const sitEscolaField = document.getElementById("sit_escola");

// Arrays para armazenar as informações lidas
const nomes = [];
const identificacoes = [];
const veiculos = [];
const sitescola = [];

function tick() {
  if (code) {
    try {
      // Tenta converter os dados do QR code para um objeto JSON
      const qrData = JSON.parse(code.data);

      // Verifica se as informações já foram armazenadas
      if (
        !nomes.includes(qrData.name) &&
        !identificacoes.includes(qrData.identification) &&
        !veiculos.includes(qrData.vehicle)
      ) {
        // Armazena os novos dados nos arrays
        nomes.push(qrData.name);
        identificacoes.push(qrData.identification);
        veiculos.push(qrData.vehicle);

        // Preenche os campos do formulário com os dados do QR code
        nomeField.value = qrData.name || "";
        identificacaoField.value = qrData.identification || "";
        veiculoField.value = qrData.vehicle || "";

        // Atualiza a interface para mostrar os dados lidos
        outputData.innerText = "Dados preenchidos automaticamente.";
      } else {
        outputData.innerText = "Código já lido.";
      }
    } catch (error) {
      outputData.innerText = "Erro ao ler o QR code: " + error;
    } finally {
      requestAnimationFrame(tick);
    }
  }
}
