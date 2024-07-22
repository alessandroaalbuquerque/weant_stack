<?php

include "config.php";

// Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
if (!empty($_POST) AND (empty($_POST['login']) OR empty($_POST['senha']))) {
  header("Location: ../login.php"); exit;
}

$usuario = mysqli_real_escape_string($conn, $_POST['login']);
$senha = mysqli_real_escape_string($conn, $_POST['senha']);
    
// Validação do usuário/senha digitados
$sql = "SELECT `id`, `login`, `nivel`, `ativo` FROM `usuario` WHERE (`login` = '". $usuario ."') AND (`senha` = '". ($senha) ."')";
$query = $conn->query($sql);
$resultado = $query->fetch_assoc();




if ($query->num_rows > 0) {
  // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado  


  // Se a sessão não existir, inicia uma
  if (!isset($_SESSION)) session_start();

    // Salva os dados encontrados na sessão
    $_SESSION['UsuarioID'] = $resultado['id'];
    $_SESSION['UsuarioLogin'] = $resultado['login'];
    $_SESSION['UsuarioNivel'] = $resultado['nivel'];
    
    $nivel = $_SESSION['UsuarioNivel'];  
    $id_validacao_usuario = $_SESSION['UsuarioID'];

    
$query_validacao_licenca = "SELECT * FROM licenca WHERE id_usuario = $id_validacao_usuario";
  $resultado_validacao_licenca = $conn->query($query_validacao_licenca);
    if ($resultado_validacao_licenca->num_rows > 0){
        $dados_validacao_licenca = $resultado_validacao_licenca->fetch_assoc();        
        $id_validacao_licenca = $dados_validacao_licenca['id']; 
        $id_pagamento_validacao_licenca = $dados_validacao_licenca['id_pagamento']; 
        $ativo_validacao_licenca = $dados_validacao_licenca['ativo'];

        $query_validacao_pagamento = "SELECT * FROM pagamento WHERE id = $id_pagamento_validacao_licenca";
        $resultado_validacao_pagamento = $conn->query($query_validacao_pagamento);
            $dados_validacao_pagamento = $resultado_validacao_pagamento->fetch_assoc();        
            $dia_validacao_pagamento = $dados_validacao_pagamento['dia']; 
            $mes_validacao_pagamento = $dados_validacao_pagamento['mes']; 
            $ano_validacao_pagamento = $dados_validacao_pagamento['ano']; 
            $diasativo_validacao_pagamento = $dados_validacao_pagamento['diasativo'];

            // Convertendo o nome do mês para número
        switch ($mes_validacao_pagamento) {
            case "Janeiro":
                $mes_validacao_pagamento = 1;
                break;
            case "Fevereiro":
                $mes_validacao_pagamento = 2;
                break;
            case "Março":
                $mes_validacao_pagamento = 3;
                break;
            case "Abril":
                $mes_validacao_pagamento = 4;
                break;
            case "Maio":
                $mes_validacao_pagamento = 5;
                break;
            case "Junho":
                $mes_validacao_pagamento = 6;
                break;
            case "Julho":
                $mes_validacao_pagamento = 7;
                break;
            case "Agosto":
                $mes_validacao_pagamento = 8;
                break;
            case "Setembro":
                $mes_validacao_pagamento = 9;
                break;
            case "Outubro":
                $mes_validacao_pagamento = 10;
                break;
            case "Novembro":
                $mes_validacao_pagamento = 11;
                break;
            case "Dezembro":
                $mes_validacao_pagamento = 12;
                break;
            default:
                // Se o nome do mês não for reconhecido, deixe como está
                break;
        }

        $data = "$dia_validacao_pagamento-$mes_validacao_pagamento-$ano_validacao_pagamento"; 
        $dataexpirar = date('d/m/Y', strtotime("+$diasativo_validacao_pagamento days",strtotime($data)));
        $data_inicial = date("d/m/Y");



        function geraTimestamp($data) {
            $partes = explode('/', $data);
            return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
            }

        // Usa a função criada e pega o timestamp das duas datas:
        $time_inicial = geraTimestamp($data_inicial);
        $time_final = geraTimestamp($dataexpirar);
        // Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final - $time_inicial; // 19522800 segundos
        // Calcula a diferença de dias
        $dias = (int)floor( $diferenca / (60 * 60 * 24));

        // Fechar conexão
        $conn->close();
    } 
    else {
       header("Location: login_semlicenca.php"); exit; 
    }

    if ($dias > 0){
    // Redireciona o visitante
      header("Location: ../inicial.php"); exit;
    }
    else {
      header("Location: ../pagamento.php"); exit;
    }

    if ($resultado['ativo'] == 0) {
      header("Location: ../login_desativado.php"); exit;
    }

} else {
  header("Location: ../login_invalido.php"); exit;
}
?>

