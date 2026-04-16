
<div class="barra">
    <div class="itens">
        <!-- Links existentes -->
        <p><a id="inicio" href="http://localhost/Muniverse/MUNIVERSE-main/index.php" class="item">Inicio</a></p>
        <p><a id="entrar" href="http://localhost/Muniverse/MUNIVERSE-main/html/login.html" class="item">Entrar</a></p>
        <p><a id="cadastrar" href="http://localhost/Muniverse/MUNIVERSE-main/html/cadastro.html" class="item">Cadastrar</a></p>
        <p><a id="certificado" href="http://localhost/Muniverse/MUNIVERSE-main/html/certificado.php" class="item">Certificado</a></p>
        <p><a id="solMesa" href="http://localhost/Muniverse/MUNIVERSE-main/html/solicitacao.php" class="item">Solicitação de Mesa</a></p>


        <div class="user-frame">
            <img src="" alt="Foto" id="userImg" class="imagem-botao">
            <input type="file" id="inputImagem" class="input-imagem" accept="image/*">
        </div>
        
        <p id="DefaultUser" class="clickable">Nome do Usuário</p>
        
        <!-- Menu suspenso -->
        <div id="userMenu" class="user-menu">
            <a href="http://localhost/Muniverse/MUNIVERSE-main/html/perfil.php">Perfil</a>
            <a href="http://localhost/Muniverse/MUNIVERSE-main/php/logout.php">Sair</a>
        </div>
    </div>
</div>

    <script>
        if(window.location.href.includes("index.php")){
            document.getElementById("userImg").src = "php/getImg.php"
        }else{
            document.getElementById("userImg").src = "../php/getImg.php"
        }

        const defaultUser = document.getElementById("DefaultUser");
    const userMenu = document.getElementById("userMenu");

    defaultUser.addEventListener("click", () => {
    if (userMenu.classList.contains("slideUp")) {
        userMenu.classList.remove("slideUp");
        userMenu.classList.add("slideDown");
        defaultUser.classList.remove("open"); // Remove a classe de aberto

        setTimeout(() => {
            userMenu.style.display = "none";
        }, 500);
    } else {
        userMenu.style.display = "block";
        userMenu.classList.remove("slideDown");
        userMenu.classList.add("slideUp");
        defaultUser.classList.add("open"); // Adiciona a classe de aberto
    }
});

// Fecha o menu e remove a classe "open" se clicar fora dele
document.addEventListener("click", (event) => {
    if (!defaultUser.contains(event.target) && !userMenu.contains(event.target)) {
        if (userMenu.classList.contains("slideUp")) {
            userMenu.classList.remove("slideUp");
            userMenu.classList.add("slideDown");
            defaultUser.classList.remove("open"); // Remove a classe de aberto

            setTimeout(() => {
                userMenu.style.display = "none";
            }, 500);
        }
    }
});
    </script>

