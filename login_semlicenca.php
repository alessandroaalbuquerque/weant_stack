
<!DOCTYPE html>
<html lang="pt-BR">
<head><head>
<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" href="assets/img/kaiadmin/favicon_1.ico" type="image/x-icon"/>
    <?php
    session_start(); // Inicia a sessão
    session_destroy(); // Destrói a sessão limpando todos os valores salvos
    ?>    
</head>
<body>
<div class="page">
        <form method="POST" class="formLogin" action="sec/sec_valida.php">
            <label for="email">Login</label>
            <input type="text" name="login" placeholder="Digite seu login" autofocus="true" />
            <label for="password">Senha</label>
            <input type="password" name="senha" placeholder="Digite sua senha" />
            <a href="/" align="center">Esqueci minha senha</a>
            <input type="submit" value="Acessar" class="btn" />
            <b align="center"> LOGIN SEM LICENÇA </b>
        </form>
    </div>
</body>
</html>
