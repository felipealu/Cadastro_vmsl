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
  sendwhatsapp();
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

function sendwhatsapp() {
  const phonenumber = "+555481685893";

  // Pegar a imagem
  const imagem = document.getElementById("qrcode");

  // Adicionar evento load à imagem
  imagem.onload = function () {
    // Pegar o conteúdo do objeto data
    const sitEscolaValue = sitEscola.checked ? "1" : "0";
    const data = {
      name: nomeCompleto.value,
      identification: ident.value,
      vehicle: loco.value,
      placa: placaID.value,
      sit_escola: sitEscolaValue,
    };

    // Converter o objeto data em uma string
    const dataString = JSON.stringify(data);

    // Adicionar o conteúdo do objeto data ao QR Code
    const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(
      dataString
    )}&size=150x150&background=${encodeURIComponent(
      "https://tecnodefesa.com.br/wp-content/uploads/2020/02/AGR.jpg"
    )}`;

    // Enviar o link para o WhatsApp
    const whatsappUrl = `https://wa.me/${phonenumber}?text=${qrCodeUrl}`;
    window.open(whatsappUrl, "_blank").focus();
  };
}
