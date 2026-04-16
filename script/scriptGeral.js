
var request;
document.addEventListener("DOMContentLoaded", () => {
    verificarPermissaoMesa();
});

function entrar() {
    try {
        var nome = document.getElementById("NomeUsertxt").value;
        var senha = document.getElementById("Senhatxt").value;
        request = new XMLHttpRequest();
        request.addEventListener("readystatechange", processaDadoServidor, false);
        console.log('Nome: ' + nome + ' Senha: ' + senha);
        request.open('GET', 'http://4.228.227.52:8080/atividadelogin/autenticar?email=' + nome + '&senha=' + senha, true);
        request.send(null);
    } catch (exception) {
        alert('Problema no envio de dados');
    }
}

function processaDadoServidor() {
    if (request.status == 200 && request.readyState == 4) {
        var verifica = request.responseText;
        if (verifica !== '') {
            if (verifica === 'true') {
                window.location.href = "../index.php";
            } else {
                alert('Erro: E-mail ou Senha Incorreta');
            }
        }
    }
}

function alterarIMG() {
    const imageInput = document.getElementById('imageInput');
    if (imageInput) {
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('userImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

function fetchUserName() {
    const entrarElement = document.getElementById("entrar");
    const cadastrarElement = document.getElementById("cadastrar");
    const certificadoElement = document.getElementById("certificado");
    const solMesaElement = document.getElementById("solMesa");
    const solDelegElement = document.getElementById("solDeleg");
    if(window.location.href.includes("index.php")){
        console.log("index aberto");
        document.querySelector('.user-menu').style.top = "42rem";
        fetch("php/get_user.php").then(response => response.json()).then(data => {
            
            const userNameElement = document.getElementById("DefaultUser");
            if (userNameElement && data.nome_user) {
                userNameElement.textContent = data.nome_user;
                entrarElement.parentElement.style.display = "none";
                cadastrarElement.parentElement.style.display = "none";
            } else {
                userNameElement.textContent = "Não logado";
                certificadoElement.parentElement.style.display = "none";
                solMesaElement.parentElement.style.display = "none";
                solDelegElement.parentElement.style.display = "none";
                
            }
        })
        .catch(error => console.error("Erro ao obter o nome do usuário:", error));
    }else{
        console.log("não é index aberto");
        document.querySelector('.user-menu').style.top = "42rem";

        fetch("../php/get_user.php").then(response => response.json()).then(data => {
            const userNameElement = document.getElementById("DefaultUser");
            if (userNameElement && data.nome_user) {
                userNameElement.textContent = data.nome_user;
                entrarElement.parentElement.style.display = "none";
                cadastrarElement.parentElement.style.display = "none";
                verificarPermissaoMesa(data.email_user);
            } else {
                userNameElement.textContent = "Não logado";
                certificadoElement.parentElement.style.display = "none";
                solMesaElement.parentElement.style.display = "none";
                solDelegElement.parentElement.style.display = "none";
                
            }
        })
        .catch(error => console.error("Erro ao obter o nome do usuário:", error));
    }
}



document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.querySelector(".hamburguer");
    const nav = document.querySelector(".nav");

    if (hamburger && nav) {
        hamburger.addEventListener("click", () => nav.classList.toggle("active"));
    }

    
    alterarIMG();
    fetchUserName();

// Quando a imagem inicial for clicada, abre o seletor de arquivos
document.getElementById("userImg").addEventListener("click", function() {
    document.getElementById("inputImagem").click();
});

// Quando o usuário escolher uma imagem, ela será exibida
document.getElementById("inputImagem").addEventListener("change", function(event) {
    const arquivo = event.target.files[0];
    if (arquivo) {
        const leitor = new FileReader();
        
        leitor.onload = function(e) {
            // Substitui a imagem exibida pela imagem escolhida
            document.getElementById("userImg").src = e.target.result;
        };
        
        leitor.readAsDataURL(arquivo);
    }
});

// Quando o usuário escolher uma imagem, ela será exibida
document.getElementById("inputImagem").addEventListener("change", function(event) {
    const arquivo = event.target.files[0];
    if (arquivo) {
        const leitor = new FileReader();
        
        leitor.onload = function(e) {
            // Substitui a imagem exibida pela imagem escolhida
            document.getElementById("userImg").src = e.target.result;
        };
        
        leitor.readAsDataURL(arquivo);
    }
});

document.getElementById('inputImagem').addEventListener('change', function(e) {
    var formData = new FormData();
    formData.append('imagem', e.target.files[0]);
    if(window.location.href.includes("index.php")){
    fetch('php/uploadFoto.php', {
        method: 'POST',
        body: formData
    })

    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Se o upload for bem-sucedido, atualizar a imagem na página
            var reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('userImg').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
            console.log('Foto atualizada com sucesso!');
        } else {
            console.log('Erro ao atualizar a foto.');
        }
    })
    .catch(error => {
        console.error('Erro no upload:', error);
        alert('Erro ao fazer upload da imagem.');
    });
}else{
    fetch('../php/uploadFoto.php', {
        method: 'POST',
        body: formData
    })

    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Se o upload for bem-sucedido, atualizar a imagem na página
            var reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('userImg').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
            console.log('Foto atualizada com sucesso!');
        } else {
            console.log('Erro ao atualizar a foto.');
        }
    })
    .catch(error => {
        console.error('Erro no upload:', error);
        alert('Erro ao fazer upload da imagem.');
    });
}
});
});

function aprovarComite(id) {
    if (confirm("Deseja aprovar este comitê?")) {
        fetch('../php/processa_comite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&acao=aprovar`
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    alert("Comitê aprovado com sucesso!");
                    document.getElementById(`comite-${id}`).style.display = "none";
                } else {
                    alert("Erro ao aprovar comitê.");
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
}

function recusarComite(id) {
    if (confirm("Deseja recusar este comitê?")) {
        fetch('../php/processa_comite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&acao=recusar`
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    alert("Comitê recusado com sucesso!");
                    document.getElementById(`comite-${id}`).style.display = "none";
                } else {
                    alert("Erro ao recusar comitê.");
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
}
function verificarPermissaoMesa() {
    // Primeiro, obtemos o e-mail do usuário conectado
    fetch("../php/get_user.php")
        .then(response => response.json())
        .then(data => {
            const emailUsuario = data.email_user; // Email do usuário conectado
            const mesaButton = document.querySelector(".botao-inscricao-mesa"); // Botão de inscrição de mesa

            if (emailUsuario) {
                // Verificar se o usuário é diretor
                fetch("../php/verificar_diretor.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ email: emailUsuario }),
                })
                    .then(response => response.json())
                    .then(result => {
                        if (mesaButton) {
                            if (result.isDiretor) {
                                // Usuário é diretor: habilitar o botão
                                mesaButton.disabled = false;
                                mesaButton.style.backgroundColor = ""; // Cor padrão
                                mesaButton.style.cursor = "pointer";
                            } else {
                                // Usuário não é diretor: desabilitar o botão
                                mesaButton.disabled = true;
                                mesaButton.style.backgroundColor = "gray";
                                mesaButton.style.cursor = "not-allowed";
                            }
                        }
                    })
                    .catch(error => {
                        console.error("Erro ao verificar permissão de diretor:", error);
                        if (mesaButton) {
                            // Em caso de erro, desabilitar o botão
                            mesaButton.disabled = true;
                            mesaButton.style.backgroundColor = "gray";
                            mesaButton.style.cursor = "not-allowed";
                        }
                    });
            } else {
                console.log("Usuário não logado.");
                if (mesaButton) {
                    // Usuário não logado: desabilitar o botão
                    mesaButton.disabled = true;
                    mesaButton.style.backgroundColor = "gray";
                    mesaButton.style.cursor = "not-allowed";
                }
            }
        })
        .catch(error => {
            console.error("Erro ao obter o email do usuário:", error);
            const mesaButton = document.querySelector(".botao-inscricao-mesa");
            if (mesaButton) {
                // Em caso de erro ao obter o e-mail, desabilitar o botão
                mesaButton.disabled = true;
                mesaButton.style.backgroundColor = "gray";
                mesaButton.style.cursor = "not-allowed";
            }
        });
}





