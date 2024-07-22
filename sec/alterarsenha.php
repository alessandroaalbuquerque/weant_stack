<?php
include "config.php";
include "sec_verifica.php";
?>

<?php
$$sqlc = "SELECT * FROM usuario WHERE id='$idlogado'"; //faz a busca com as palavras enviadas
$result = $conn->query($sqlc);
$dados = $result->fetch_assoc();

$id = $dados['id'];
$senha = $dados["senha"];
$login = $dados["login"];
$nome = $dados["nome"];
$cpf = $dados["cpf"];
$telefone = $dados["telefone"];
$nascimento = $dados["nascimento"];   
$genero = $dados["genero"];           
$email = $dados["email"];
$nivelusuario = $dados["nivel"];
$ativousuario = $dados["ativo"];
$gerasenha = $dados["gerasenha"];
$operador = $dados["operador"];
$senhaatual = $_POST["senhaatual"];
$novasenha = $_POST["senhanova"];

@$cargousuario = $_POST["cargousuario"];
@$departamentousuario = $_POST["departamentousuario"];
$gerasenha = "4";
$horario = date('H:i:s');
$dia = date('d');
$mes = date('m');
$ano = date('Y');
$semana = date('w');
$operador = $_SESSION['UsuarioLogin'];



switch ($mes){

case 1: $mes = "Janeiro"; break;
case 2: $mes = "Fevereiro"; break;
case 3: $mes = "Março"; break;
case 4: $mes = "Abril"; break;
case 5: $mes = "Maio"; break;
case 6: $mes = "Junho"; break;
case 7: $mes = "Julho"; break;
case 8: $mes = "Agosto"; break;
case 9: $mes = "Setembro"; break;
case 10: $mes = "Outubro"; break;
case 11: $mes = "Novembro"; break;
case 12: $mes = "Dezembro"; break;

}


switch ($semana) {

case 0: $semana = "Domingo"; break;
case 1: $semana = "Segunda"; break;
case 2: $semana = "Terça"; break;
case 3: $semana = "Quarta"; break;
case 4: $semana = "Quinta"; break;
case 5: $semana = "Sexta"; break;
case 6: $semana = "Sábado"; break;

}
?>
<?php
if ($nivelusuario == 3){
    $pnivel = 'Administrador';
}
elseif  ($nivelusuario == 2){
    $pnivel = 'Gestor';
}
elseif  ($nivelusuario == 1){
    $pnivel = 'Usuario';
}
?>
<?php
if ($ativousuario == 1){
    $pativo = 'Ativado';
}
elseif  ($ativousuario == 0){
    $pativo = 'Desativado';
}
?>

<?php
if ($senhaatual == $senha) {

    $query1 = "INSERT INTO registrousuario ( `id_usuario` , `login` , `senha` , `nome` , `cpf` , `nascimento`, `genero`, `email` , `telefone` , `departamento` , `cargo` , `nivel` , `pnivel` , `ativo` , `pativo` , `gerasenha` , `horario` , `dia` , `semana` , `mes` , `ano` , `operador` ) VALUES ( '$id', '$login', '$criptografada', '$nome', '$cpf', '$nascimento', '$genero', '$email', '$telefone', '$departamentousuario', '$cargousuario', '$nivelusuario', '$pnivel', '$ativousuario', '$pativo', '$gerasenha', '$horario', '$dia', '$semana', '$mes', '$ano', '$operador' )";
    $result1 = $conn->query($query1);

    $query2 = "UPDATE usuario SET login='$login', senha='$novasenha', nome='$nome', cpf='$cpf', nascimento='$nascimento', genero='$genero', email='$email', telefone='$telefone', nivel='$nivelusuario', pnivel='$pnivel', ativo='$ativousuario', pativo='$pativo', gerasenha='$gerasenha' WHERE id='$id'"; 
    $result2 = $conn->query($query2);

    $msg = "Senha atualizada com sucesso!";
    echo "<script>alert( '$msg ' );; window.location = '../meu_perfil.php';</script>";
}
else {
    header("Location: ../inicial.php"); exit;
}
?>



