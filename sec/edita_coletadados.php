
<?php
    include "config.php";
    include "sec_verifica.php";
    if ( $nivel < 2 ) 
    {
        header("Location: sem_acesso.php"); exit;
    }
    
// Verifique se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario_selecionado = $_POST['nome'];
    $horarioexpediente_selecionado = $_POST['horarioexpediente'];
    $localdetrabalho_selecionado = $_POST['localdetrabalho'];
    $dia_escala = $_GET['dia'];
    $mes_escala = $_GET['mes'];
    $ano_escala = $_GET['ano'];
    $id_escala = $_GET['id'];

        $query_usuario_selecionado = "SELECT * FROM usuario WHERE id='$id_usuario_selecionado'";   
            $resultado_usuario_selecionado = $conn->query($query_usuario_selecionado);
                $dados_usuario_selecionado = $resultado_usuario_selecionado->fetch_assoc();
                    $nome_usuario_selecionado = $dados_usuario_selecionado['nome'];
                    $login_usuario_selecionado = $dados_usuario_selecionado['login'];
                    
    
        switch ($horarioexpediente_selecionado) {
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
                // Caso nenhum dos valores seja correspondido
                // Defina um comportamento padrão aqui, se necessário
                break;
        }
?>

<!-- Início das validações -->
    <div class="alertaescalaverde"> 
        <?php  
                $query_domingousuario = "SELECT *
                    FROM afastamento
                    WHERE id_usuario = $id_usuario_selecionado AND motivo = 'Folga'
                    AND MONTH(STR_TO_DATE(datainicial, '%d/%m/%Y')) = MONTH(CURDATE())
                    AND EXISTS (
                        SELECT 1
                        FROM afastamento a
                        WHERE a.id_usuario = afastamento.id_usuario
                            AND STR_TO_DATE(a.datainicial, '%d/%m/%Y') <= STR_TO_DATE(afastamento.datafinal, '%d/%m/%Y')
                            AND STR_TO_DATE(a.datafinal, '%d/%m/%Y') >= STR_TO_DATE(afastamento.datainicial, '%d/%m/%Y')
                            AND (DAYOFWEEK(STR_TO_DATE(a.datainicial, '%d/%m/%Y')) = 1 OR DAYOFWEEK(STR_TO_DATE(a.datafinal, '%d/%m/%Y')) = 1)
                    );";        
                    $resultado_domingousuario = $conn->query($query_domingousuario);  
                        $dados_domingousuario = $resultado_domingousuario->fetch_assoc();  
            
                            if (@$resultado_domingousuario->num_rows < 1) {                  
                                echo "$nome_usuario_selecionado ainda não teve um Domingo de folga no mês atual</br>";                                          
                            }
        ?>
    </div>

    <div class="alertaescalavermelho">         
                        <?php
                            $query_escalahorario = "SELECT * FROM escala WHERE local='$localdetrabalho_selecionado' AND dia='$dia_escala' AND mes='$mes_escala' AND ano='$ano_escala' AND horarioinicio='$inicioexpediente' AND NOT id='$id_escala'"; //faz a busca com as palavras enviadas
                            $resultado_escalahorario = $conn->query($query_escalahorario);
                                $dados_escalahorario = $resultado_escalahorario->fetch_assoc();
                                    @$id_usuario_usuarioescalado = $dados_escalahorario['id_usuario']; 
                                    @$dia_usuario_usuarioescalado = $dados_escalahorario['dia']; 
                                    @$mes_usuario_usuarioescalado = $dados_escalahorario['mes'];
                                    @$ano_usuario_usuarioescalado = $dados_escalahorario['ano'];

                            $query_usuarioescalado = "SELECT * FROM usuario WHERE id='$id_usuario_usuarioescalado'";
                                $resultado_usuarioescalado = $conn->query($query_usuarioescalado);
                                    $dados_usuarioescalado = $resultado_usuarioescalado->fetch_assoc();
                                        @$nome_usuarioescalado = $dados_usuarioescalado['nome'];
                                        @$login_usuarioescalado = $dados_usuarioescalado['login']; 
                    
                            if (@$resultado_escalahorario->num_rows > 0) {                  
                                echo "$nome_usuarioescalado já está escalado em $dia_usuario_usuarioescalado/$mes_usuario_usuarioescalado/$ano_usuario_usuarioescalado, à " . $inicioexpediente . "h no $localdetrabalho_selecionado</br>";                                          
                            }

                        ?>
    </div> 

    <div class="alertaescalaverde"> 
                        <?php 
                            $dataescala_tratada = "$dia_escala-$mes_escala";
                            $aniversario_usuario_selecionado = $dados_usuario_selecionado['nascimento'];
                                // Divide a string em partes separadas por "/"
                                @$partesnascimento_selecionado = explode("/", $aniversario_usuario_selecionado);
                                // Pega o dia e o mês
                                @$dianascimento_selecionado = $partesnascimento_selecionado[0];
                                @$mesnascimento_selecionado = $partesnascimento_selecionado[1];
                                // Combina o dia e o mês em uma nova string
                                @$aniversario_selecionado_tratado = "$dianascimento_selecionado-$mesnascimento_selecionado";                                
                         
                        
                            if ("$dataescala_tratada" == "$aniversario_selecionado_tratado"){
                                echo "Escalando no aniversário</br>";                  
                            }   

                        ?>
    </div> 

    <div class="alertaescalaverde"> 
                        <?php            

                            
                        ?>
    </div> 
<!-- Fim das validações --> 
 
<?php
} else {
    echo "<p>Nenhum dado recebido.</p>";
}

// Feche a conexão com o banco de dados
$conn->close();
?>  
