
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

            $localdetrabalho_selecionado = $_POST['localdetrabalho'];
            $idusuario_selecionado = $_POST['nome'];

            $horarioexpediente_selecionado = $_POST['horarioexpediente'];
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
            
            $query_selecionado = "SELECT * FROM usuario WHERE id='$idusuario_selecionado'"; //faz a busca com as palavras enviadas
                $resultado_selecionado = $conn->query($query_selecionado);
                    $dados_selecionado = $resultado_selecionado->fetch_assoc();
                        $nome_selecionado = $dados_selecionado['nome']; 
                        @$nome_selecionado = $dados_selecionado['nome'];
                            @$login_selecionado = $dados_selecionado['login'];
                            @$aniversario_selecionado = $dados_selecionado['nascimento'];
                                // Divide a string em partes separadas por "/"
                                @$partesnascimento_selecionado = explode("/", $aniversario_selecionado);
                                // Pega o dia e o mês
                                @$dianascimento_selecionado = $partesnascimento_selecionado[0];
                                @$mesnascimento_selecionado = $partesnascimento_selecionado[1];
                                // Combina o dia e o mês em uma nova string
                                @$aniversario_selecionado_tratado = "$dianascimento_selecionado-$mesnascimento_selecionado";
?>
<div class="alertaescalaverde"> 
<?php  
            $query_domingousuario = "SELECT *
                FROM afastamento
                WHERE id_usuario = $idusuario_selecionado AND motivo = 'Folga'
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
                            echo "$nome_selecionado ainda não teve um Domingo de folga no mês atual</br>";                                          
                        }
?>
</div>
<div class="alertaescalavermelho">  
<?php            

            // Definir a variável @novas_datas
            $query_set_var = "SET @novas_datas = '$todas_as_datas_selecionadas';";
            if (!$conn->query($query_set_var)) {
                die("Erro ao definir a variável: " . $conn->error);
            }

            // Criar tabela temporária
            $query_create_temp = "
            CREATE TEMPORARY TABLE IF NOT EXISTS temp_datas (
                data DATE
            );";
            if (!$conn->query($query_create_temp)) {
                die("Erro ao criar tabela temporária: " . $conn->error);
            }

            // Inserir datas existentes no banco de dados
            $query_insert_existing = "
            INSERT INTO temp_datas (data)
            SELECT DATE(CONCAT_WS('-', ano, LPAD(mes, 2, '0'), LPAD(dia, 2, '0')))
            FROM escala
            WHERE id_usuario = $idusuario_selecionado;";
            if (!$conn->query($query_insert_existing)) {
                die("Erro ao inserir datas existentes: " . $conn->error);
            }

            // Inserir novas datas
            $query_insert_new = "
            INSERT INTO temp_datas (data)
            SELECT STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(@novas_datas, ',', numbers.n), ',', -1), '%d-%m-%Y')
            FROM (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7) numbers
            WHERE CHAR_LENGTH(@novas_datas) - CHAR_LENGTH(REPLACE(@novas_datas, ',', '')) >= numbers.n - 1;";
            if (!$conn->query($query_insert_new)) {
                die("Erro ao inserir novas datas: " . $conn->error);
            }

            // Verificar intervalos de 7 dias consecutivos
            $query_check_7days = "
            WITH OrderedDates AS (
                SELECT
                    data,
                    LEAD(data, 1) OVER (ORDER BY data) AS next_day_1,
                    LEAD(data, 2) OVER (ORDER BY data) AS next_day_2,
                    LEAD(data, 3) OVER (ORDER BY data) AS next_day_3,
                    LEAD(data, 4) OVER (ORDER BY data) AS next_day_4,
                    LEAD(data, 5) OVER (ORDER BY data) AS next_day_5,
                    LEAD(data, 6) OVER (ORDER BY data) AS next_day_6
                FROM
                    temp_datas
            )
            SELECT
                DATE_FORMAT(data, '%d-%m-%Y') AS primeiro_dia,
                DATE_FORMAT(DATE_ADD(data, INTERVAL 6 DAY), '%d-%m-%Y') AS ultimo_dia
            FROM
                OrderedDates
            WHERE
                next_day_1 = DATE_ADD(data, INTERVAL 1 DAY)
                AND next_day_2 = DATE_ADD(data, INTERVAL 2 DAY)
                AND next_day_3 = DATE_ADD(data, INTERVAL 3 DAY)
                AND next_day_4 = DATE_ADD(data, INTERVAL 4 DAY)
                AND next_day_5 = DATE_ADD(data, INTERVAL 5 DAY)
                AND next_day_6 = DATE_ADD(data, INTERVAL 6 DAY);";

            $resultado_7diasseguidos = $conn->query($query_check_7days);
            if ($resultado_7diasseguidos) {
                if ($resultado_7diasseguidos->num_rows > 0) {
                    while ($row7dias = $resultado_7diasseguidos->fetch_assoc()) {
                        $primeirodiabusca7dias = $row7dias['primeiro_dia'];
                        $ultimodiabusca7dias = $row7dias['ultimo_dia'];

                        // Converte a data para o formato DD/MM/AAAA
                        $primeirodia_7dias_formatado = DateTime::createFromFormat('d-m-Y', $primeirodiabusca7dias)->format('d/m/Y');
                        $ultimodia_7dias_formatado = DateTime::createFromFormat('d-m-Y', $ultimodiabusca7dias)->format('d/m/Y');
                        
                        // Exemplo de uso das variáveis
                        echo "Escalando 7 dias seguidos, entre $primeirodia_7dias_formatado e $ultimodia_7dias_formatado</br>";
                    }
                } 
            } 
            // Limpar a tabela temporária
            $conn->query("DROP TEMPORARY TABLE IF EXISTS temp_datas");
?>
</div>

            <?php                                        
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

                        $datacompleta_selecionado = "$escaladia/$escalames/$escalaano";
                        $dataescala_tratada = "$escaladia-$escalames"; 
                        $dataescala_completa_tratada = "$escalaano-$escalames-$escaladia";
                        
                        $query_escalahorario = "SELECT * FROM escala WHERE local='$localdetrabalho_selecionado' AND dia='$escaladia' AND mes='$escalames' AND ano='$escalaano' AND horarioinicio='$inicioexpediente'"; //faz a busca com as palavras enviadas
                            $resultado_escalahorario = $conn->query($query_escalahorario);
                                $dados_escalahorario = $resultado_escalahorario->fetch_assoc();
                                    @$login_escalahorario = $dados_escalahorario['id_usuario']; 

                        $query_usuarioescalado = "SELECT * FROM usuario WHERE id='$login_escalahorario'";
                            $resultado_usuarioescalado = $conn->query($query_usuarioescalado);
                                $dados_usuarioescalado = $resultado_usuarioescalado->fetch_assoc();
                                    @$nome_usuarioescalado = $dados_usuarioescalado['nome'];
                                    @$login_usuarioescalado = $dados_usuarioescalado['login']; 

            ?>     
<div class="alertaescalavermelho">         
                        <?php
                    
                            if (@$resultado_escalahorario->num_rows > 0) {                  
                                echo "$nome_usuarioescalado já está escalado em $datacompleta_selecionado, à " . $inicioexpediente . "h no $localdetrabalho_selecionado</br>";                                          
                            }

                        ?>
</div> 
<div class="alertaescalaverde"> 
                        <?php  
                        
                            if ("$dataescala_tratada" == "$aniversario_selecionado_tratado"){
                                echo "Escalando no aniversário em $datacompleta_selecionado</br>";                  
                            }   

                        ?>
</div> 
                

            <?php
                    }    
                }                                      
            
        } else {
            echo "Nenhuma data fornecida!";
        }  
        ?>
        
        