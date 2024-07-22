<?php
    include "config.php";
    include "sec_verifica.php";
    if ( $nivel < 2 ) 
    {
        header("Location: sem_acesso.php"); exit;
    }
        // Verifica se as datas foram passadas na URL
        if (isset($_POST['dates'])) {
            // Sanitiza e obtém as datas
            $datesStr = htmlspecialchars($_POST['dates']);
            $dates = explode(',', $datesStr);
            
            $todas_as_datas_selecionadas = $_POST['dates'];

            // Exibe as datas selecionadas                                    
            foreach ($dates as $date) {             
                $allItems = array();
                    
                // Tenta separar cada data usando '-' como delimitador
                $separatedData = explode('-', $date);

                //Verifica se a data está no formato correto (dia-mes-ano)
                if (count($separatedData) == 3) {
                    $escaladia = $separatedData[0];
                    $escalames = $separatedData[1];
                    $escalaano = $separatedData[2];            
                        
                    // Adiciona os itens separados ao array $allItems
                    $allItems[] = array('dia' => $escaladia, 'mes' => $escalames, 'ano' => $escalaano);


                    $query_escalahorario = "SELECT * FROM escala WHERE dia='$escaladia' AND mes='$escalames' AND ano='$escalaano'"; //faz a busca com as palavras enviadas
                            $resultado_escalahorario = $conn->query($query_escalahorario);   
                    


                                
                    if (@$resultado_escalahorario->num_rows > 0) {     
                        echo "</br> $escaladia/$escalames/$escalaano existem $resultado_escalahorario->num_rows turnos </br></br>";  
                        
                        while ($dados_escalahorario = $resultado_escalahorario->fetch_assoc()) {

                            @$id_escalahorario = $dados_escalahorario['id'];
                            @$login_escalahorario = $dados_escalahorario['id_usuario']; 
                            @$login_escalainiciodeexpediente = $dados_escalahorario['horarioinicio'];
                            @$login_escalalocaldetrabalho = $dados_escalahorario['local'];

                            $query_usuarioescalado = "SELECT * FROM usuario WHERE id='$login_escalahorario'";
                                $resultado_usuarioescalado = $conn->query($query_usuarioescalado);
                                    $dados_usuarioescalado = $resultado_usuarioescalado->fetch_assoc();
                                        @$nome_usuarioescalado = $dados_usuarioescalado['nome'];
                                        @$login_usuarioescalado = $dados_usuarioescalado['login']; 
                                        
                                        switch ($login_escalainiciodeexpediente) {
                                            case "01:00:00":
                                                $inicioexpediente = "01:00:00";
                                                $iniciointervalo = "04:00:00";
                                                $finalintervalo = "04:15:00";
                                                $finalexpediente = "07:00:00";
                                                break;
                                            case "07:00:00":
                                                $inicioexpediente = "07:00:00";
                                                $iniciointervalo = "10:00:00";
                                                $finalintervalo = "10:15:00";
                                                $finalexpediente = "13:00:00";
                                                break;
                                            case "13:00:00":
                                                $inicioexpediente = "13:00:00";
                                                $iniciointervalo = "16:00:00";
                                                $finalintervalo = "16:15:00";
                                                $finalexpediente = "19:00:00";
                                                break;
                                            case "19:00:00":
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
                            <a href='editarturno.php?id=<?php echo "$id_escalahorario"; ?>'>
<?php
                            echo "Nome: $nome_usuarioescalado </br>";  
                            echo "Data: $escaladia/$escalames/$escalaano </br>";   
                            echo "Início de Expediente: $inicioexpediente</br>"; 
                            echo "Início de Intervalo: $iniciointervalo</br>"; 
                            echo "Fim de Intervalo: $finalintervalo</br>"; 
                            echo "Fim de Expediente: $finalexpediente</br>"; 
                            echo "Local: $login_escalalocaldetrabalho</br> </br>";
?>
                            </a>
<?php
                        }                                                            
                    }
                }    
            }    
        } 
?>           