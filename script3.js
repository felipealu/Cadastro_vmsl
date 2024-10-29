const nomeCompleto = document.querySelector("#nome");
const ident = document.querySelector("#identificacao");
const loco = document.querySelector("#veiculo");
const placaID = document.querySelector("#placa");
const sitEscola = document.querySelector("#sit_escola");
const qrcode = document.querySelector("#qrcode");
const gerarButton = document.querySelector("#gerar");

//eventos de mecanismos de crianção do QRCode
document.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    genQRCode();
  }
});

gerarButton.addEventListener("click", () => {
  console.log("Botão de gerar clicado");
  genQRCode();
});

sitEscola.addEventListener("change", () => {
  const sitEscolaValue = sitEscola.checked ? "1" : "0";
  sitEscola.value = sitEscolaValue;
});

// API para crianção do QRCode
function genQRCode() {
  console.log("Função genQRCode chamada");
  const sitEscolaValue = sitEscola.checked ? "1" : "0";
  const data = {
    name: nomeCompleto.value,
    identification: ident.value,
    vehicle: loco.value,
    placa: placaID.value,
    sit_escola: sitEscolaValue,
  };
  console.log("Objeto data criado:", data);
  const jsonString = JSON.stringify(data);
  console.log("String JSON criada:", jsonString);
  qrcode.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(
    jsonString
  )}`;
  console.log("QRCode gerado:", qrcode.src);
}
