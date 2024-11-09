<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo Triunfo - Recrutamento Humano</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar">                            
            <img src="img/logo.png" alt="logo" height="100px" width="auto" flex-shrink="0">  
            <div class=logo-container>
            </div>  
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#sobre">Sobre</a></li>
                    <li><a href="#servicos">Serviços</a></li>
                    <li><a href="#parcerias">Localização</a></li>
                </ul>
            <button id="login-btn" class="cta-login">Login</button>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Bem-vindo ao Grupo Triunfo</h1>
            <p>Especialistas em recrutamento humano, facilitando o seu processo de contratação.</p>
            <a href="#servicos" class="cta-button">Saiba Mais</a>
        </div>
    </section>

    <!-- Sobre Nós Section -->
    <section id="sobre" class="about">
        <h2>Sobre Nós</h2>
        <h4>O Grupo Triunfo é referência no setor de recrutamento humano, oferecendo soluções completas e inovadoras para empresas e candidatos. Nossa missão é facilitar e aprimorar o processo de contratação com eficiência e confiança.</h4>
    </section>

    <!-- Serviços Section -->
    <section id="servicos" class="services">
        <h2>Nossos Serviços</h2>
        <div class="service-cards">
            <div class="card">
                <h3>Cadastro de Vagas</h3>
                <p>Ajudamos as empresas a criar vagas e gerir candidatos de forma simplificada e organizada.</p>
            </div>
            <div class="card">
                <h3>Acompanhamento de Documentação</h3>
                <p>Monitoramos a documentação dos candidatos, garantindo que tudo esteja correto e atualizado.</p>
            </div>
            <div class="card">
                <h3>Validação e Agendamento</h3>
                <p>Validamos os dados dos candidatos e auxiliamos no agendamento de exames admissionais (ASO).</p>
            </div>
        </div>
    </section>

    <!-- Parcerias e Localização Section -->
    <section id="parcerias" class="partnerships">
        <h2>Localização</h2>
        <p>Estamos localizados na Av. Triunfo, 1234, Centro, Cidade Exemplo. Trabalhamos em parceria com várias empresas para oferecer soluções de recrutamento eficazes.</p>
        <p>Entre em contato para se tornar um parceiro e juntos aprimorarmos o mercado de trabalho.</p>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18..."></iframe>
        </div>
    </section>

    <!-- Modal de Login -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login</h2>
            <form action="validacao.php" method="post">
                <label for="txUsuario">Usuário:</label>
                <input type="text" id="txUsuario" name="usuario" required>
                <label for="txSenha">Senha:</label>
                <input type="password" id="txSenha" name="senha" required>
                <button type="submit">Conectar</button>
            </form>
        </div>
    </div>
    <script src="scripts.js"></script>

    <footer>
        <p>&copy; 2024 Grupo Triunfo - Todos os direitos reservados</p>
    </footer>
</body>
</html>
