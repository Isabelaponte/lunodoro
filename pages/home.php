<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../styles/globals.css" />
    <link rel="stylesheet" href="./../styles/home.css" />
    <title>Lunodoro</title>
</head>

<body>
    <?php
        session_start();
        $user = isset($_SESSION['nome_usuario']) ? htmlspecialchars($_SESSION['nome_usuario']) : "Visitante";
    ?>
    
    <header class="header_nav">
        <div class="icon">
            <img src="./../img/logo.png" alt="logo" id="logo" />
            <h1>Lunodoro</h1>
        </div>
        <nav>
            <a href="home.html">Home</a>
            <a href="lista_tarefas.html">Lista de Tarefas</a>
            <a href="reports.html">Relatórios</a>
            <a href="faq.html">Sobre o Lunodoro</a>
        </nav>
        <a href="login.html" class="login">Login</a>
    </header>

    <main class="home-container">
        <h1 class="welcome-message">Bem-vindo, <?php echo $user; ?>!</h1>
        <p class="intro-text">Para começar, crie sua lista de tarefas e comece a organizar seu tempo de forma eficiente.</p>
        <a href="./lista_tarefas.html" class="task-list-link">Acessar minhas listas de tarefas</a>
    </main>
</body>

</html>
