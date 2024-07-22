<?php
include "tudo_cima.php"; 

$sqlc = "SELECT * FROM usuario WHERE id='$idlogado'"; //faz a busca com as palavras enviadas
$result = $conn->query($sqlc);
$dados = $result->fetch_assoc();

$id = $dados['id'];
$login = $dados["login"];
$nome = $dados["nome"];
$cpf = $dados["cpf"];
$telefone = $dados["telefone"];
$nascimento = $dados["nascimento"];              
$email = $dados["email"];
$pnivel = $dados["pnivel"];
$pativo = $dados["pativo"];
$gerasenha = $dados["gerasenha"];
$horario = $dados["horario"];
$dia = $dados["dia"];
$semana = $dados["semana"];
$mes = $dados["mes"];
$ano = $dados["ano"];
$operador = $dados["operador"];

?>

<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
  }

  .container {
    width: 80%;
    margin: auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
  }

  .form-group div {
    font-size: 16px;
    padding: 8px;
    background-color: #f1f1f1;
    border-radius: 4px;
  }

  .password-form {
    margin-top: 20px;
  }

  .password-form input[type="pass"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
  }

  .password-form button {
    background-color: #1f283e;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s;
  }

  .password-form button:hover {
    background-color: #6861CE;
  }
</style>

<div class="container">
  <!-- INICIA CONTEÚDO -->              
  <div class="form-group">
    <label>Login:</label>
    <div><?php echo $login; ?></div>
  </div>

  <div class="form-group">
    <label>Nome:</label>
    <div><?php echo $nome; ?></div>
  </div>

  <div class="form-group">
    <label>CPF:</label>
    <div><?php echo $cpf; ?></div>
  </div>

  <div class="form-group">
    <label>Email:</label>
    <div><?php echo $email; ?></div>
  </div>

  <div class="form-group">
    <label>Celular:</label>
    <div><?php echo $telefone; ?></div>
  </div>

  <div class="form-group">
    <label>Nivel:</label>
    <div><?php echo $pnivel; ?></div>
  </div>

  <div class="form-group password-form">                   
    <form method="POST" action="sec/alterarsenha.php"> 
      <input type="pass" name="senhaatual" placeholder="Senha atual">
      <input type="pass" name="senhanova" placeholder="Nova senha">
      <button class="botao" type="submit">Alterar senha</button>
    </form>                    
  </div>
  <!-- FINALIZA CONTEÚDO -->
</div>

<?php
include "tudo_baixo.php"; 
?>
