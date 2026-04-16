/*var vetorRadioBtn = [];
var vetorRadioBtnTexto = [];

async function buscarRegistroAnterior(IDdelg, destino) {
    const dados = {
        id: IDdelg
    };

    try {
        const response = await fetch('http://localhost/Muniverse/MUNIVERSE-main/html/buscar_registro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados)
        });

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }

        const resultadoEnvioPHP = await response.json();
        console.log('Resposta do servidor:', resultadoEnvioPHP);
        console.log(resultadoEnvioPHP);

        var id_representacoes = [];
        var nome_representacao = [];
         

        id_representacoes = resultadoEnvioPHP.id_representacoes;
        nome_representacao = resultadoEnvioPHP.nome_representacao;

       // var divprimeiraRep = document.getElementById(destino);
        var div1 = '';
        var div2 = '';
        var div3 = '';
        if (destino=" primeiraRep") {
            var div1 = document.getElementById(destino);
        }
        if (destino=" segundaRep") {
            var div2 = document.getElementById(destino);
        }
        if (destino=" terceiraRep") {
            var div3 = document.getElementById(destino);
        }

        if (vetorRadioBtn.length > 0 && resultadoEnvioPHP != null) {
            vetorRadioBtn.forEach(radio => {
                radio.remove();
            });

            vetorRadioBtnTexto.forEach(texto => {
                texto.remove();
            });

            // Limpa os arrays após remover os elementos
            vetorRadioBtn = [];
            vetorRadioBtnTexto = [];
        }

        id_representacoes.forEach((id, index) => {
            var container = document.createElement("div");
            container.className = "radio-container";

            var radio = document.createElement("input");
            radio.type = "radio";
            radio.name = "opcao"; // Todos os radio buttons precisam ter o mesmo nome para serem exclusivos
            radio.id = id;
            radio.value = nome_representacao[index];

            // Cria um span para o texto ao lado do radio button
            var label = document.createElement("label");
            label.htmlFor = id; // Associa o label ao botão pelo ID
            label.textContent = nome_representacao[index]; // Define o texto do label

            container.appendChild(radio);
            container.appendChild(label);

            // Adiciona o contêiner à div principal
            divprimeiraRep.appendChild(container);

            // Armazena os elementos criados para limpeza posterior
            vetorRadioBtn.push(radio);
            vetorRadioBtnTexto.push(label);
        });

    } catch (error) {
        console.error('Erro:', error);
    }
}*/
var vetorRadioBtn = {
    primeiraRep: [],
    segundaRep: [],
    terceiraRep: []
};

var vetorRadioBtnTexto = {
    primeiraRep: [],
    segundaRep: [],
    terceiraRep: []
};

var ultimoID = {
    primeiraRep: null,
    segundaRep: null,
    terceiraRep: null
};

async function buscarRegistroAnterior(IDdelg, destino) {
    const dados = { id: IDdelg };

    try {
        const response = await fetch('http://localhost/Muniverse/MUNIVERSE-main/html/buscar_registro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados)
        });

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }

        const resultadoEnvioPHP = await response.json();
        console.log('Resposta do servidor:', resultadoEnvioPHP);

        const id_representacoes = resultadoEnvioPHP.id_representacoes || [];
        const nome_representacao = resultadoEnvioPHP.nome_representacao || [];

        const divDestino = document.getElementById(destino);

        // Verifica se o ID mudou; se não mudou, não faz nada
        if (ultimoID[destino] === IDdelg) {
            console.log(`O ID para ${destino} não mudou. Nenhuma atualização necessária.`);
            return;
        }

        // Atualiza o último ID processado
        ultimoID[destino] = IDdelg;

        // Limpa os conteúdos anteriores da div correspondente
        if (vetorRadioBtn[destino].length > 0) {
            vetorRadioBtn[destino].forEach(radio => radio.remove());
            vetorRadioBtnTexto[destino].forEach(label => label.remove());

            vetorRadioBtn[destino] = [];
            vetorRadioBtnTexto[destino] = [];
        }

        // Preenche a div com os novos valores
        id_representacoes.forEach((id, index) => {
            const container = document.createElement("div");
            container.className = "radio-container";

            const radio = document.createElement("input");
            radio.type = "radio";
            radio.name = destino; // Nome exclusivo para cada div
            radio.id = `${destino}_${id}`;
            radio.value = nome_representacao[index];

            const label = document.createElement("label");
            label.htmlFor = `${destino}_${id}`;
            label.textContent = nome_representacao[index];

            container.appendChild(radio);
            container.appendChild(label);

            divDestino.appendChild(container);

            // Armazena os elementos criados para limpeza posterior
            vetorRadioBtn[destino].push(radio);
            vetorRadioBtnTexto[destino].push(label);
        });

    } catch (error) {
        console.error('Erro:', error);
    }
}