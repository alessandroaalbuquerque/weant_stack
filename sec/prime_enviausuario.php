<?php
include "config.php";

$credencial = $_GET['credencial'];
$nome = $_POST['nome'];
$statusinicio = "ocupada";

// Consulta usando prepared statements para evitar SQL injection
$query_token = $conn->prepare("SELECT * FROM pagamento WHERE cnpj_cpf = ? AND status = ?");
    $query_token->bind_param("ss", $credencial, $statusinicio); 
        $query_token->execute();
        $resultado_token = $query_token->get_result();
            if ($resultado_token->num_rows > 0) {
?>