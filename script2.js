// Campos do formulário de cadastro
const nomeField = document.getElementById("nome");
const identificacaoField = document.getElementById("identificacao");
const veiculoField = document.getElementById("veiculo");
const placaField = document.getElementById("placa");
const sitEscolaField = document.getElementById("sit_escola");

// Arrays para armazenar as informações lidas
const nomes = [];
const identificacoes = [];
const veiculos = [];
const placas = [];
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
        !veiculos.includes(qrData.vehicle) &&
        !placas.includes(qrData.placa) &&
        !sitescola.includes(qrData.sit_escola)
      ) {
        // Armazena os novos dados nos arrays
        nomes.push(qrData.name);
        identificacoes.push(qrData.identification);
        veiculos.push(qrData.vehicle);
        placas.push(qrData.placa);
        sitescola.push(qrData.sit_escola);

        // Preenche os campos do formulário com os dados do QR code
        nomeField.value = qrData.name || "";
        identificacaoField.value = qrData.identification || "";
        veiculoField.value = qrData.vehicle || "";
        placaField.value = qrData.placa || "";
        sitEscolaField.value = qrData.sit_escola || "";

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
