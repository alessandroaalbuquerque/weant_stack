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
$query = $conn->query($sqlc);
$dados = $query->fetch_assoc();
$nivelusuario = $dados["nivel"];

$login = $_POST["login"];
$nome = $_POST["nome"];
$cpf = $_POST["cpf"];
$email = $_POST["email"];
$telefone = $_POST["telefone"];
$nascimento = $_POST["nascimento"];
$genero = $_POST['genero'];
$nivelusuario = $_POST['nivelusuario'];
$ativousuario = $_POST['ativousuario'];
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
// $query1 = "INSERT INTO registrousuario ( `id_usuario` , `login` , `senha` , `nome` , `cpf` , `nascimento`, `genero`, `email` , `telefone` , `departamento` , `cargo` , `nivel` , `pnivel` , `ativo` , `pativo` , `gerasenha` , `horario` , `dia` , `semana` , `mes` , `ano` , `operador` ) VALUES ( '$id', '$login', '$criptografada', '$nome', '$cpf', '$nascimento', '$genero', '$email', '$telefone', '$departamentousuario', '$cargousuario', '$nivelusuario', '$pnivel', '$ativousuario', '$pativo', '$gerasenha', '$horario', '$dia', '$semana', '$mes', '$ano', '$operador' )";
// $result1 = $conn->query($query1);

// $query2 = "UPDATE usuario SET login='$login', nome='$nome', cpf='$cpf', nascimento='$nascimento', genero='$genero', email='$email', telefone='$telefone', nivel='$nivelusuario', pnivel='$pnivel', ativo='$ativousuario', pativo='$pativo', gerasenha='$gerasenha' WHERE id='$id'"; 
// $result2 = $conn->query($query2);

// $query_validacao_licenca = "SELECT * FROM licenca WHERE id_usuario = '$idlogado'";
//     $resultado_validacao_licenca = $conn->query($query_validacao_licenca);
//         $dados_validacao_licenca = $resultado_validacao_licenca->fetch_assoc();  
//             $id_cliente_validacao_licenca = $dados_validacao_licenca['id_cliente']; 

$query_validacao_licenca = "SELECT * FROM licenca WHERE id_usuario = '$idlogado'";
    $resultado_validacao_licenca = $conn->query($query_validacao_licenca);
        $dados_validacao_licenca = $resultado_validacao_licenca->fetch_assoc();  
            $id_cliente_validacao_licenca = $dados_validacao_licenca['id_cliente']; 


// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os valores dos contratos como um array
    $contratos = isset($_POST['contratos']) ? $_POST['contratos'] : [];

    $query_delete_ricc = "DELETE FROM relacao_cliente WHERE id_usuario = $id";
        $resultado_delete_ricc = $conn->query($query_delete_ricc);
    
    // Processa cada contrato
    foreach ($contratos as $index => $contrato) {
        // Remove espaços em branco e caracteres especiais
        $contratoLimpo = htmlspecialchars(trim($contrato));
        
        $query_ricc = "INSERT INTO relacao_cliente (id_cliente, id_contrato, id_usuario)
                        SELECT ?, ?, ?
                        FROM DUAL
                        WHERE NOT EXISTS (
                            SELECT 1 
                            FROM relacao_cliente 
                            WHERE id_cliente = ? 
                            AND id_contrato = ? 
                            AND id_usuario = ?
                        )";
        
        $stmt_ricc = $conn->prepare($query_ricc);
        
        if ($stmt_ricc === false) {
            die('Erro na preparação da query: ' . $conn->error);
        }
        
        // Atualize o número de parâmetros de bind_param para corresponder aos parâmetros na consulta SQL
        $stmt_ricc->bind_param("iiiiss", $id_cliente_validacao_licenca, $contratoLimpo, $id, $id_cliente_validacao_licenca, $contratoLimpo, $id);
        
        if (!$stmt_ricc->execute()) {
            die('Erro na execução da query: ' . $stmt_ricc->error);
        }
    }
} else {
    echo "Nenhum dado foi enviado.";
}

$msg = "Alteração do usuário realizado com sucesso!";
echo "<script>alert( '$msg ' );; window.location = '../pesquisarusuario.php';</script>";
?>



