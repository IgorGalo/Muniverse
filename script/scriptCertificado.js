const today = new Date();
const ano = today.getFullYear();
let mes = today.getMonth() + 1; //Mês começa em 0
let dia = today.getDate();
if (dia < 10) {
  dia = '0' + dia;
}
if (mes < 10) {
  mes = '0' + mes;
}
const DataMax = ano + '-' + mes + '-' + dia;

const { degrees, PDFDocument, rgb, StandardFonts } = PDFLib;

document.addEventListener("DOMContentLoaded", () => {
  const images = document.querySelectorAll(".imagemcertificado");
  const gerarPdfBtn = document.getElementById("GerarPdfBtn");
  let selectedValue = ""; // Variável para armazenar o valor selecionado

  images.forEach((image, index) => {
      image.addEventListener("click", () => {
          images.forEach(img => img.classList.remove("selected"));
          image.classList.add("selected");

          if (index === 0) {
              selectedValue = "Modelo 1 Selecionado";
              console.log("Você selecionou o Modelo com assinatura do Secretário Geral.");
          } else if (index === 1) {
              selectedValue = "Modelo 2 Selecionado";
              console.log("Você selecionou o Modelo com assinatura do Secretário Geral e do Diretor da Instituição.");
          } else if (index === 2) {
              selectedValue = "Inserir Modelo Personalizado";
              console.log("Você optou por inserir seu próprio modelo.");
          }

          // Salva o valor no localStorage para uso posterior
          localStorage.setItem("selectedValue", selectedValue);
      });
  });

  // Adiciona a validação no clique do botão
  gerarPdfBtn.addEventListener("click", (e) => {
      if (!selectedValue) {
          alert("Por favor, selecione um modelo antes de gerar o certificado.");
      } else {
          console.log("Certificado gerado com o modelo:", selectedValue);
          modifyPdf(); // Chama a função principal para gerar o certificado
      }
  });
});


async function fetchUsuarios() {
  try {
    const response = await fetch('../php/buscar_dados.php');
    
    if (!response.ok) {
      throw new Error('Erro ao acessar o servidor');
    }

    const data = await response.json();

    if (data.error) {
      throw new Error(data.error);
    }

    // Processa os dados para exibir valores default onde necessário
    const processedData = data.map(item => {
      return {
        nome_usuario: item.nome_usuario,
        edicao: item.edicao || 'XXXX', // Caso edicao seja null
        comite: item.comite || 'XXXX', // Caso comite seja null
        data_inicio: item.data_inicio || 'XXXX', // Caso data_inicio seja null
        data_fim: item.data_fim || 'XXXX', // Caso data_fim seja null
        funcao: item.funcao || 'XXXX', // Caso funcao seja null
        carga_horaria: item.carga_horaria || 'XXXX' // Caso carga_horaria seja null
      };
    });

    console.log(processedData); // Exibe a resposta processada
    return processedData;
  } catch (error) {
    console.error('Erro ao buscar os dados do banco:', error);
    alert('Erro ao buscar os dados do banco: ' + error.message);
    return [];
  }
}

async function modifyPdf() {
  const Usuarios = await fetchUsuarios(); // Espera os dados antes de continuar

  if (!Usuarios || Usuarios.length === 0) {
    alert('Nenhum dado foi retornado do servidor.');
    return;
  }

  const selectedValue = localStorage.getItem("selectedValue");
  console.log("Valor Selecionado:", selectedValue);

  // Função para introduzir o atraso entre os downloads
  function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

  for (let index = 0; index < Usuarios.length; index++) {

    // Ajuste a lógica para definir a URL com base no valor selecionado
    let url;
    if (selectedValue === "Modelo 1 Selecionado") {
      url = '../image/ModeloDeCertificadoSec.pdf';
    } else if (selectedValue === "Modelo 2 Selecionado") {
      url = '../image/ModeloBranco.pdf';
    } else {
      alert("Nenhum modelo foi selecionado. Por favor, selecione um modelo.");
      return;
    }

    const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());

    // Load a PDFDocument from the existing PDF bytes
    const pdfDoc = await PDFDocument.load(existingPdfBytes);

    // Embed the Helvetica font
    const FontNome = await pdfDoc.embedFont(StandardFonts.TimesRomanBoldItalic);
    const Font = await pdfDoc.embedFont(StandardFonts.TimesRoman);

    // Get the first page of the document
    const pages = pdfDoc.getPages();
    const firstPage = pages[0];

    // Get the width and height of the first page
    const { width, height } = firstPage.getSize();
    console.log(width);

    // Acessando as propriedades diretamente dos objetos no array de Usuarios
    let Nome = String(Usuarios[index].nome_usuario); 
    let comite = String(Usuarios[index].comite).toUpperCase(); 
    let edicao = String(Usuarios[index].edicao).toUpperCase(); 
    let data_inicio = String(Usuarios[index].data_inicio).toUpperCase(); 
    let data_fim = String(Usuarios[index].data_fim).toUpperCase(); 
    let funcao = String(Usuarios[index].funcao).toUpperCase(); 
    let carga_horaria = String(Usuarios[index].carga_horaria).toUpperCase();

    // Verifica se algum dado essencial está ausente
    if (!Nome || !edicao || !comite || !data_inicio || !data_fim || !funcao || !carga_horaria) {
      alert("Alguns dados estão ausentes. Verifique os dados do usuário.");
      return;
    }

    // Medir a largura do texto.
    let fontSize = 60; // Tamanho padrão da fonte
    let compAltura = 0;
    let larguraNome = FontNome.widthOfTextAtSize(Nome, fontSize);
    while (larguraNome > 700) { // Limite de largura para o nome
      fontSize -= 0.25; // Reduz a fonte gradualmente
      larguraNome = FontNome.widthOfTextAtSize(Nome, fontSize);
      compAltura += 0.25;
    }
    
    firstPage.drawText(Nome, {
      x: 416 - (larguraNome / 2),
      y: height / 2 + 45 + compAltura,
      size: fontSize,
      font: FontNome,
      color: rgb(0, 0.30196, 0.3803921)
    });

    let primeiraLinha = 'PELA PARTICIPAÇÃO EXERCENDO A FUNÇÃO DE ' + funcao + ' DA ' + edicao;
    let larguralinha1 = NumeroPixels(primeiraLinha, index, Font, 18.5, Usuarios);
    firstPage.drawText(primeiraLinha, {
      x: 420 - (larguralinha1 / 2),
      y: height / 2,
      size: 18.5,
      font: Font,
      color: rgb(0, 0.30196, 0.3803921)
    });

    let segundaLinha = 'REALIZADA NOS DIAS ' + data_inicio + ' A ' + data_fim + ', COM CARGA HORÁRIA TOTAL';
    let larguralinha2 = NumeroPixels(segundaLinha, index, Font, 18.5, Usuarios);
    firstPage.drawText(segundaLinha, {
      x: 420 - (larguralinha2 / 2),
      y: height / 2 - 29,
      size: 18.5,
      font: Font,
      color: rgb(0, 0.30196, 0.3803921)
    });

    let terceiraLinha = 'DE ' + carga_horaria + ' HORAS. EMITIDO EM ' + dia + '/' + mes + '/' + ano + ' PELO SECRETARIADO GERAL.';
    let larguralinha3 = NumeroPixels(terceiraLinha, index, Font, 18.5, Usuarios);

    firstPage.drawText(terceiraLinha, {
      x: 420 - (larguralinha3 / 2),
      y: height / 2 - 56,
      size: 18.5,
      font: Font,
      color: rgb(0, 0.30196, 0.3803921)
    });

    // Fetch and embed the image
    const imageUrl = 'https://igorluisgalo.github.io/Certificado/IMG_9299-removebg-preview.png'; // Assinatura
    const imageBytes = await fetch(imageUrl).then(res => res.arrayBuffer());
    const image = await pdfDoc.embedPng(imageBytes); // Ou embedJpg se a imagem for JPG

    // Get the dimensions of the image
    const imageWidth = image.width;
    const imageHeight = image.height;

    // Define the position and size for the image
    const imageWidthScaled = 200; // Ajuste conforme necessário
    const imageHeightScaled = (imageHeight / imageWidth) * imageWidthScaled;

    if (selectedValue === "Modelo 1 Selecionado") {
      // Draw the image on the first page
      firstPage.drawImage(image, {
        x: 300,
        y: height / 2 - 225,
        width: imageWidthScaled,
        height: imageHeightScaled,
      });
    } else if (selectedValue === "Modelo 2 Selecionado") {
      // Draw the image on the first page
      firstPage.drawImage(image, {
        x: 150,
        y: height / 2 - 225,
        width: imageWidthScaled,
        height: imageHeightScaled,
      });

      firstPage.drawImage(image, {
        x: 450,
        y: height / 2 - 225,
        width: imageWidthScaled,
        height: imageHeightScaled,
      });
    } else {
      alert("Nenhum modelo foi selecionado. Por favor, selecione um modelo.");
      return;
    }

    // Serialize the PDFDocument to bytes (a Uint8Array)
    const pdfBytes = await pdfDoc.save();

    // Trigger the browser to download the PDF document
    download(pdfBytes, "Certificado" + '_' + Nome, "application/pdf");

    // Atraso de 500ms entre os downloads para evitar bloqueios
    await delay(250);
  }
}


function NumeroPixels(Text, index, Font, tamanho, Usuarios) {
  const tempElement3 = document.createElement('span');
  tempElement3.style.visibility = 'hidden'; // Oculta o elemento
  tempElement3.style.whiteSpace = 'nowrap'; // Impede que o texto quebre para a próxima linha
  tempElement3.textContent = Text;

  // Copiar estilos relevantes do elemento original para obter uma medição precisa.
  const originalElement3 = Usuarios[index].nome_usuario;
  tempElement3.style.fontFamily = Font.fontFamily;
  tempElement3.style.fontSize = Font.fontSize;
  tempElement3.style.fontSize = tamanho;

  // Adicionar o elemento temporário ao corpo do documento.
  document.body.appendChild(tempElement3);

  // Medir a largura do texto.
  return tempElement3.offsetWidth;
}
