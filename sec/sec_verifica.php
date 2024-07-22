<?php
include "config.php";

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
  // Destrói a sessão por segurança
  session_destroy();
  // Redireciona o visitante de volta pro login
  header("Location: $urllogin"); exit;
}

$nivel = $_SESSION['UsuarioNivel'];
 
 
$sqlc = "SELECT * FROM usuario WHERE id=" . $_SESSION['UsuarioID']; //faz a busca com as palavras enviadas
  $query = $conn->query($sqlc);
    $dados = $query->fetch_assoc();
      $idlogado = $dados['id'];
      $usuariologado = $dados['login'];
      $nomelogado = $dados['nome'];
      $cpflogado = $dados['cpf'];
      $emaillogado = $dados['email'];
      $telefonelogado = $dados['telefone'];
      $departamentologado = $dados['departamento'];
      $cargologado = $dados['cargo'];

$query_vdl_licenca = "SELECT * FROM licenca WHERE id_usuario = '$idlogado'";
  $resultado_vdl_licenca = $conn->query($query_vdl_licenca);
    $dados_vdl_licenca = $resultado_vdl_licenca->fetch_assoc();  
      $id_cliente_vdl_licenca = $dados_vdl_licenca['id_cliente']; 
      $tipo_vdl_licenca = $dados_vdl_licenca['tipo']; 
?>
