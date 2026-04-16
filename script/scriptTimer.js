function toggleExpandableBar() {
  const bar = document.getElementById('expandableBar');
  bar.style.display = bar.style.display === 'none' || bar.style.display === '' ? 'block' : 'none';
}
// Seleciona os elementos
const modal = document.getElementById('realizarChamadaModal');
const btn = document.getElementById('realizarChamadaBtn');
const span = document.querySelector('.close');

// Quando o botão for clicado, exibe o modal
btn.onclick = function() {
  modal.style.display = 'block';
};

// Quando o botão "x" for clicado, esconde o modal
span.onclick = function() {
  modal.style.display = 'none';
};

// Fecha o modal ao clicar fora do conteúdo
window.onclick = function(event) {
  if (event.target === modal) {
      modal.style.display = 'none';
  }
};

function changeColor(checkbox) {
  const allCheckboxes = document.querySelectorAll('.checkbox');
  const allLabels = document.querySelectorAll('.checkbox-label');

  // Se o checkbox for marcado, muda a cor de fundo correspondente
  if (checkbox.checked) {
      const label = checkbox.nextElementSibling;

      if (checkbox.id.includes('pCheckbox')) {
          label.style.backgroundColor = 'yellow'; // Cor para P
      } else if (checkbox.id.includes('pvCheckbox')) {
          label.style.backgroundColor = 'green'; // Cor para PV
      } else if (checkbox.id.includes('aCheckbox')) {
          label.style.backgroundColor = 'red'; // Cor para A
      }
  } else {
      // Se desmarcar, remove a cor de fundo
      const label = checkbox.nextElementSibling;
      label.style.backgroundColor = ''; // Remove a cor
  }

  // Desmarca todos os outros checkboxes com o mesmo nome
  const nameGroup = checkbox.name;
  document.querySelectorAll('input[name="' + nameGroup + '"]').forEach((cb) => {
      if (cb !== checkbox) {
          cb.checked = false;
          const label = cb.nextElementSibling;
          label.style.backgroundColor = ''; // Remove a cor
      }
  });
}

let nomeSelecionado = "";  // Variável para armazenar o nome do delegado selecionado

// Função para definir o nome selecionado
function selecionarDelegado(nome) {
nomeSelecionado = nome;  // Armazena o nome do delegado selecionado
}

// Função para salvar a seleção dos delegados




span.onclick = function() {
  modal.style.display = 'none';
};

// Fecha o modal ao clicar fora do conteúdo
window.onclick = function(event) {
  if (event.target === modal) {
      modal.style.display = 'none';
  }
};

function adicionarOrador(nome, item) {
  
  event.stopPropagation(); // Impede que o evento se propague para outros elementos

  const oradoresList = document.getElementById('listaProximosOradores'); // Lista de oradores atuais

  // Cria um novo item para a lista de oradores
  const newOrador = document.createElement('li');
  newOrador.classList.add('list-group-item');
  newOrador.textContent = nome;

  // Adiciona o orador na lista de oradores
  oradoresList.appendChild(newOrador);

  // Remove o item da lista de "Acrescentar Orador"
  item.remove();
}

function moverOuLiberarOrador() {
const listaProximosOradores = document.getElementById('listaProximosOradores');
const listaOradoresAtuais = document.getElementById('listaOradores');
const listaAcrescentarOradores = document.getElementById('listaAcrescentarOradores');

// Se já houver um orador atual, liberar ele e reabilitar na lista de "Acrescentar Orador"
if (oradorAtual !== null) {
const nomeOradorLiberado = oradorAtual.textContent;

// Procurar o orador na lista de "Acrescentar Orador" e reabilitar
const itensAcrescentar = listaAcrescentarOradores.getElementsByTagName('li');
for (let i = 0; i < itensAcrescentar.length; i++) {
if (itensAcrescentar[i].textContent === nomeOradorLiberado) {
itensAcrescentar[i].style.pointerEvents = 'auto'; // Reabilitar o clique
itensAcrescentar[i].style.backgroundColor = ''; // Restaurar o estilo original
break;
}
}

// Remover o orador atual da lista de oradores
listaOradoresAtuais.removeChild(oradorAtual);

oradorAtual = null;
}

// Verificar se há próximos oradores na lista
if (listaProximosOradores.children.length > 0) {
const proximoOrador = listaProximosOradores.children[0];

// Mover o próximo orador para a lista de orador atual
listaOradoresAtuais.appendChild(proximoOrador);
oradorAtual = proximoOrador;

// Desabilitar o novo orador atual
oradorAtual.style.pointerEvents = 'none';
oradorAtual.style.backgroundColor = '#f0f0f0'; // Indicar que está desabilitado
}
}