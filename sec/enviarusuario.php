<?php
include "config.php";
include "sec_verifica.php";
if ( $nivel < 2 ) 
{
	header("Location: sec_tipo.php"); exit;
}

$login = $_POST["login"];
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$nascimento = $_POST['nascimento'];
    $enviarnascimento = explode("-", $nascimento);

    // Pega o ano, mês e dia
    $enviaanonascimento = $enviarnascimento[0];
    $enviamesnascimento = $enviarnascimento[1];
    $enviadianascimento = $enviarnascimento[2];

    // Monta a data no formato DD/MM/AAAA
    $enviaaniversario = "$enviadianascimento/$enviamesnascimento/$enviaanonascimento";


$genero = $_POST['genero'];
$email = $_POST['email'];
$telefone = $_POST['celular'];
#$cargousuario = $_POST["cargousuario"];
#$departamentousuario = $_POST["departamentousuario"];
$nivelusuario = $_POST["nivelusuario"];
$ativousuario = $_POST["ativousuario"];
$gerasenha = "3";
$horario = date('H:i:s');
$dia = date('d');
$mes = date('m');
$ano = date('Y');
$semana = date('w');
$operador = $_SESSION["UsuarioLogin"];



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
switch ($nivelusuario) {

    case 1: $pnivel = "Usuario"; break;
    case 2: $pnivel = "Gestor"; break; 

}
?>
<?php
switch ($ativousuario) {

    case 0: $pativo = "Desativado"; break;
    case 1: $pativo = "Ativo"; break; 

}
?>

<?php
// // Função para verificar se uma variável está definida e não é vazia
// function verificarVariavel($var, $nomeVar) {
//     if (!isset($var) || empty($var)) {
//         die("Por favor, preencha o campo obrigatório: $nomeVar.");
//     }
// }

// // Verificando se todas as variáveis necessárias estão definidas e não são vazias
// verificarVariavel($login, 'login');
// verificarVariavel($nome, 'nome');
// verificarVariavel($cpf, 'cpf');
// verificarVariavel($nascimento, 'nascimento');
// verificarVariavel($genero, 'genero');
// verificarVariavel($email, 'email');
// verificarVariavel($telefone, 'telefone');
// verificarVariavel($nivelusuario, 'nivel');
// verificarVariavel($pnivel, 'pnivel');
// verificarVariavel($ativousuario, 'ativo');
// verificarVariavel($pativo, 'pativo');
// verificarVariavel($gerasenha, 'gerasenha');
// verificarVariavel($horario, 'horario');
// verificarVariavel($dia, 'dia');
// verificarVariavel($semana, 'semana');
// verificarVariavel($mes, 'mes');
// verificarVariavel($ano, 'ano');
// verificarVariavel($operador, 'operador');

// Preparando a primeira query
$query = "INSERT INTO usuario (login, senha, nome, cpf, nascimento, genero, email, telefone, departamento, cargo, nivel, pnivel, ativo, pativo, gerasenha, horario, dia, semana, mes, ano, operador) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Erro na preparação da query: ' . $conn->error);
}

$stmt->bind_param("sssssssssssssssssssss", $login, $cpf, $nome, $cpf, $nascimento, $genero, $email, $telefone, $departamento, $cargo, $nivelusuario, $pnivel, $ativousuario, $pativo, $gerasenha, $horario, $dia, $semana, $mes, $ano, $operador);

if (!$stmt->execute()) {
    die('Erro na execução da query: ' . $stmt->error);
}

$retorno_idusuario = $stmt->insert_id;

// Preparando a segunda query
$query1 = "INSERT INTO registrousuario (id_usuario, login, senha, nome, cpf, nascimento, genero, email, telefone, departamento, cargo, nivel, pnivel, ativo, pativo, gerasenha, horario, dia, semana, mes, ano, operador) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt1 = $conn->prepare($query1);

if ($stmt1 === false) {
    die('Erro na preparação da query1: ' . $conn->error);
}

$stmt1->bind_param("isssssssssssssssssssss", $retorno_idusuario, $login, $criptografadacpf, $nome, $cpf, $nascimento, $genero, $email, $telefone, $departamento, $cargo, $nivelusuario, $pnivel, $ativousuario, $pativo, $gerasenha, $horario, $dia, $semana, $mes, $ano, $operador);

if (!$stmt1->execute()) {
    die('Erro na execução da query1: ' . $stmt1->error);
}
?>

<?php
// Receber os contratos selecionados
$contratos = isset($_POST['contratos']) ? $_POST['contratos'] : [];

// Sanitizar e processar os IDs dos contratos
$contratos = array_map('intval', $contratos);

$query_validacao_licenca = "SELECT * FROM licenca WHERE id_usuario = '$idlogado'";
    $resultado_validacao_licenca = $conn->query($query_validacao_licenca);
        $dados_validacao_licenca = $resultado_validacao_licenca->fetch_assoc();              
            $tipo_cliente_validacao_licenca = $dados_validacao_licenca['tipo']; 
            $id_pagamento_validacao_licenca = $dados_validacao_licenca['id_pagamento'];  
            $id_cliente_validacao_licenca = $dados_validacao_licenca['id_cliente'];           

// Query para relação de profissionais x cliente x contrato    
foreach ($contratos as $contrato) {

    $query_ricc = "INSERT INTO relacao_cliente (id_usuario, id_contrato, id_cliente) 
        VALUES (?, ?, ?)";
        
            $stmt_ricc = $conn->prepare($query_ricc);
        
                if ($stmt_ricc === false) {
                    die('Erro na preparação da query: ' . $conn->error);
                }
        
                    $stmt_ricc->bind_param("iii",  $retorno_idusuario, $contrato, $id_cliente_validacao_licenca);
        
                        if (!$stmt_ricc->execute()) {
                            die('Erro na execução da query: ' . $stmt_ricc->error);
                        }
}

// Query para licença do usuário cadastrado
$query = "INSERT INTO licenca (tipo, id_cliente, id_usuario, id_pagamento) 
VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Erro na preparação da query: ' . $conn->error);
}

$stmt->bind_param("iiii", $tipo_cliente_validacao_licenca, $id_cliente_validacao_licenca, $retorno_idusuario, $id_pagamento_validacao_licenca);

if (!$stmt->execute()) {
    die('Erro na execução da query: ' . $stmt->error);
}

$stmt->close();
$stmt1->close();

$msg = "Usuário cadastrado com sucesso!";
echo "<script>alert('$msg'); window.location = '../criarusuario.php';</script>";
?>





