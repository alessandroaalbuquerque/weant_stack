<!DOCTYPE html>
<html lang="pt-BR">
  <head>    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeAnt</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" href="assets/img/kaiadmin/favicon_1.ico" type="image/x-icon"/>
  </head>

  <body>

  <div align="center" class="page">
    <a class="logo">
      <img src="assets/img/kaiadmin/logo_light.png" alt="navbar brand" class="navbar-brand" height="70"/>
    </a>   
    <form method='POST' action='sec/sec_validatoken.php'>
      <input type="text" name="tokencliente" id="tokencliente" size="30" maxlength="30" placeholder="TOKEN" required/> </br>
      <input type="text" name="nomecliente" id="nomecliente" size="30" maxlength="30" placeholder="CONTRATO" required/> </br>
      <button type="submit" class="btn">Confirma</button>
    </form> 
  </div>
  
</body>

</html>