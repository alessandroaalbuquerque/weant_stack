<?php
include "config.php";
include "sec_verifica.php";
if ( $nivel < 2 ) 
{
	header("Location: sec_tipo.php"); exit;
}

$id_cliente = $_GET['cliente'];

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber e sanitizar o nome do contrato
    $contrato = isset($_POST['contrato']) ? htmlspecialchars($_POST['contrato']) : '';
    $statuscontrato = $_POST['statuscontrato'];

     // Query para contrato
     $query_contrato = "INSERT INTO contrato (nome, status) 
     VALUES (?, ?)";
     
         $stmt_contrato = $conn->prepare($query_contrato);
     
             if ($stmt_contrato === false) {
                 die('Erro na preparação da query: ' . $conn->error);
             }
     
                 $stmt_contrato->bind_param("si", $contrato, $statuscontrato);
     
                     if (!$stmt_contrato->execute()) {
                         die('Erro na execução da query: ' . $stmt_contrato->error);
                     }
 
                         $retorno_idcontrato = $stmt_contrato->insert_id;

    // Receber os profissionais selecionados
    $profissionais = isset($_POST['profissionais']) ? $_POST['profissionais'] : [];

    // Sanitizar e processar os IDs dos profissionais
    $profissionais = array_map('intval', $profissionais);

    // Receber os locais dinamicamente
    $locais = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'local') === 0) {
            $locais[$key] = htmlspecialchars($value);
        }
    }
       
    // Query para relação de profissionais x cliente x contrato    
    foreach ($profissionais as $profissional) {

        $query_ricc = "INSERT INTO relacao_cliente (id_cliente, id_contrato, id_usuario) 
            VALUES (?, ?, ?)";
            
                $stmt_ricc = $conn->prepare($query_ricc);
            
                    if ($stmt_ricc === false) {
                        die('Erro na preparação da query: ' . $conn->error);
                    }
            
                        $stmt_ricc->bind_param("iii", $id_cliente, $retorno_idcontrato, $profissional);
            
                            if (!$stmt_ricc->execute()) {
                                die('Erro na execução da query: ' . $stmt_ricc->error);
                            }
                            
    }

    
    foreach ($locais as $local => $valor_local) {

        // Query para contrato
        $query_local = "INSERT INTO local (nome, id_contrato) 
        VALUES (?,?)";
        
            $stmt_local = $conn->prepare($query_local);
        
                if ($stmt_local === false) {
                    die('Erro na preparação da query: ' . $conn->error);
                }
        
                    $stmt_local->bind_param("si", $valor_local, $retorno_idcontrato);
        
                        if (!$stmt_local->execute()) {
                            die('Erro na execução da query: ' . $stmt_local->error);
                        }
    }

    $msg = "Contrato criado com sucesso!";
    echo "<script>alert( '$msg ' );; window.location = '../criarcontrato.php';</script>";
}

?>