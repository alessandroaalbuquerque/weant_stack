<?php
include "config.php";
include "sec_verifica.php";
if ( $nivel < 2 ) 
{
	header("Location: sec_tipo.php"); exit;
}


$id_escala = $_GET['id'];
$dia_escala = $_GET['dia'];
$mes_escala = $_GET['mes'];
$ano_escala = $_GET['ano'];
$id_usuarioescalado = $_POST['nome'];
$local_escala = $_POST['localdetrabalho'];

$horario = date('H:i:s');
$dia = date('d');
$mes = date('m');
$ano = date('Y');
$semana = date('w');
$operador = $_SESSION["UsuarioLogin"];

$inicioexpediente_escala = $_POST['horarioexpediente'];
    switch ($inicioexpediente_escala) {
        case "01-07":
            $inicioexpediente = "01:00:00";
            $iniciointervalo = "04:00:00";
            $finalintervalo = "04:15:00";
            $finalexpediente = "07:00:00";
            break;
        case "07-13":
            $inicioexpediente = "07:00:00";
            $iniciointervalo = "10:00:00";
            $finalintervalo = "10:15:00";
            $finalexpediente = "13:00:00";
            break;
        case "13-19":
            $inicioexpediente = "13:00:00";
            $iniciointervalo = "16:00:00";
            $finalintervalo = "16:15:00";
            $finalexpediente = "19:00:00";
            break;
        case "19-01":
            $inicioexpediente = "19:00:00";
            $iniciointervalo = "21:00:00";
            $finalintervalo = "21:15:00";
            $finalexpediente = "01:00:00";
            break;
        default:
            break;
    }
            

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

// $query_escala = "SELECT * FROM escala WHERE id='$id_escala'";
//     $resultado_escala = $conn->query($query_escala);
//         $dados_escala = $resultado_escala->fetch_assoc();
//             $id_usuario_escala = $dados_escala['id_usuario'];
?>

                        <?php

                        // Preparando a primeira query
                        $query = "UPDATE escala SET id_usuario=?, horarioinicio=?, intervaloinicio=?, intervalofim=?, horariofim=?, local=?, dia=?, mes=?, ano=?, operador=? WHERE id=?";
                        $stmt = $conn->prepare($query);

                        if ($stmt === false) {
                            die('Prepare failed: ' . htmlspecialchars($conn->error));
                        }

                        $stmt->bind_param(
                            'isssssssssi', 
                            $id_usuarioescalado, 
                            $inicioexpediente, 
                            $iniciointervalo, 
                            $finalintervalo, 
                            $finalexpediente, 
                            $local_escala, 
                            $dia_escala, 
                            $mes_escala, 
                            $ano_escala, 
                            $operador, 
                            $id_escala
                        );

                        if ($stmt->execute() === false) {
                            die('Execute failed: ' . htmlspecialchars($stmt->error));
                        } else {
                            echo "Registro atualizado com sucesso.";
                        }

                        $stmt->close();
                        
                        // Preparando a segunda query
                        $query1 = "INSERT INTO registroescala (id_usuario, id_escala, horarioinicio, intervaloinicio, intervalofim, horariofim, local, dia, mes, ano, loghorario, logdia, logsemana, logmes, logano, operador) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        $stmt1 = $conn->prepare($query1);

                        if ($stmt1 === false) {
                            die('Erro na preparação da query1: ' . $conn->error);
                        }

                        $stmt1->bind_param("iissssssssssssss", $id_usuarioescalado, $id_escala, $inicioexpediente, $iniciointervalo, $finalintervalo, $finalexpediente, $local_escala, $dia_escala, $mes_escala, $ano_escala, $horario, $dia, $semana, $mes, $ano, $operador);

                        if (!$stmt1->execute()) {
                            die('Erro na execução da query1: ' . $stmt1->error);
                        }
                                                
                        $stmt1->close();

                        
                        ?> 

<?php

$msg = "Turno alterado com sucesso!";
echo "<script>alert( '$msg' );; window.location = '../pesquisaescala.php';</script>";                
?>




