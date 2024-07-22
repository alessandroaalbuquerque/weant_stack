<?php
include "config.php";

$tokencliente = $_POST['tokencliente'];
$nomecliente = $_POST['nomecliente'];
$statuspagamento = 'reservada';

// Consulta usando prepared statements para evitar SQL injection
$query_token = $conn->prepare("SELECT * FROM pagamento WHERE cnpj_cpf = ? AND token = ?");
$query_token->bind_param("ss", $nomecliente, $tokencliente); 
$query_token->execute();
$resultado_token = $query_token->get_result();
    if ($resultado_token->num_rows > 0) {

        // Consulta usando prepared statements para evitar SQL injection
        $query_token2 = $conn->prepare("SELECT * FROM pagamento WHERE cnpj_cpf = ? AND token = ? AND status = ?");
        $query_token2->bind_param("sss", $nomecliente, $tokencliente, $statuspagamento); 
        $query_token2->execute();
        $resultado_token2 = $query_token2->get_result();

        if ($resultado_token2->num_rows > 0) {
            $dados_validatoken = $resultado_token2->fetch_assoc();
                $id_validatoken = $dados_validatoken['id'];
                $cnpj_cpf_validatoken = $dados_validatoken['cnpj_cpf'];
                $diasativo_validatoken = $dados_validatoken['diasativo'];                
                $horario_validatoken = $dados_validatoken['horario'];
                $dia_validatoken = $dados_validatoken['dia'];
                $semana_validatoken = $dados_validatoken['semana'];
                $mes_validatoken = $dados_validatoken['mes'];
                $ano_validatoken = $dados_validatoken['ano'];
                $tipodelicenca_validatoken = $dados_validatoken['tipodelicenca'];
                $valor_validatoken = $dados_validatoken['valor'];
                $statuspagamento = 'ocupada';
                
                $loghorario = date('H:i:s');
                $logdia = date('d');
                $logsemana = date('w');
                $logmes = date('m');
                $logano = date('Y');


                switch ($logsemana) {

                case 0: $logsemana = "Domingo"; break;
                case 1: $logsemana = "Segunda"; break;
                case 2: $logsemana = "Terça"; break;
                case 3: $logsemana = "Quarta"; break;
                case 4: $logsemana = "Quinta"; break;
                case 5: $logsemana = "Sexta"; break;
                case 6: $logsemana = "Sábado"; break;

                }

                switch ($logmes){

                case 1: $logmes = "Janeiro"; break;
                case 2: $logmes = "Fevereiro"; break;
                case 3: $logmes = "Março"; break;
                case 4: $logmes = "Abril"; break;
                case 5: $logmes = "Maio"; break;
                case 6: $logmes = "Junho"; break;
                case 7: $logmes = "Julho"; break;
                case 8: $logmes = "Agosto"; break;
                case 9: $logmes = "Setembro"; break;
                case 10: $logmes = "Outubro"; break;
                case 11: $logmes = "Novembro"; break;
                case 12: $logmes = "Dezembro"; break;

                }


                $query_insert = "INSERT INTO registropagamento (cnpj_cpf, token, diasativo, horario, dia, semana, mes, ano, loghorario, logdia, logsemana, logmes, logano, tipodelicenca, valor, status) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $resultado_insert = $conn->prepare($query_insert);

                    if ($resultado_insert === false) {
                        die('Erro na preparação da query: ' . $conn->error);
                    }

                    $resultado_insert->bind_param("ssssssssssssssss", $cnpj_cpf_validatoken, $tokencliente, $diasativo_validatoken, $horario_validatoken, $dia_validatoken, $semana_validatoken, $mes_validatoken, $ano_validatoken, $loghorario, $logdia, $logsemana, $logmes, $logano, $tipodelicenca_validatoken, $valor_validatoken, $statuspagamento);

                    if (!$resultado_insert->execute()) {
                        die('Erro na execução da query: ' . $resultado_insert->error);
                    }

                $query_update = "UPDATE pagamento SET status='$statuspagamento' WHERE id='$id_validatoken'"; 
                    $resultado_update = $conn->query($query_update);

                $msg = "Token validado com sucesso!";
                echo "<script>alert( '$msg ' );; window.location = '../prime/definicao.php?credencial=$cnpj_cpf_validatoken';</script>";

            
        } else {
            header("Location: ../token_ocupado.php");
            exit;
        } 


    } else {
        header("Location: ../token_invalido.php");
        exit;
    }
?>
