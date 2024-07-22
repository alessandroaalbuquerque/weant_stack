<?php
include "config.php";
include "sec_verifica.php";
if ( $nivel < 2 ) 
{
	header("Location: ../sem_acesso.php"); exit;
}
?>

<?php
$id = $_GET["id"];

$sqlc = "SELECT * FROM usuario WHERE id='$id'"; //faz a busca com as palavras enviadas
$result = $conn->query($sqlc);
$dados = $result->fetch_assoc();

$login = $dados["login"];
$senha = $dados["senha"];
$nome = $dados["nome"];
$cpf = $dados["cpf"];
$nascimento = $dados["nascimento"];
$email = $dados["email"];
$telefone = $dados["telefone"];
$cargousuario = $dados["cargo"];
$departamentousuario = $dados["departamento"];
$nivelusuario = $dados["nivel"];
$pnivel = $dados["pnivel"];
$ativousuario = $dados["ativo"];
$pativo = $dados["pativo"];
$gerasenha = "1";
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
    $pnivel = 'Tecnico';
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
$query = "INSERT INTO registrousuario ( `id_usuario` , `login` , `senha` , `nome` , `cpf` , `nascimento` , `email` , `telefone` , `departamento` , `cargo` , `nivel` , `pnivel` , `ativo` , `pativo` , `gerasenha` , `horario` , `dia` , `semana` , `mes` , `ano` , `operador` ) VALUES ( '$id', '$login', '$criptografada', '$nome', '$cpf', '$nascimento', '$email', '$telefone', '$departamentousuario', '$cargousuario', '$nivelusuario', '$pnivel', '$ativousuario', '$pativo', '$gerasenha', '$horario', '$dia', '$semana', '$mes', '$ano', '$operador' )";
$result = $conn->query($query);

$query2 = "UPDATE usuario SET senha='$cpf' WHERE id='$id'"; 
$result2 = $conn->query($query2);


$msg = "Reset de senha realizado com sucesso!";
echo "<script>alert( '$msg ' );; window.location = '../pesquisarusuario.php';</script>";
?>



