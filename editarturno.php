<?php
include "tudo_cima.php"; 
if ( $nivel < 2 ) 
{
	header("Location: sem_acesso.php"); exit;
}
?>

<?php
$id_escala = $_GET['id'];

$query_escala = "SELECT * FROM escala WHERE id='$id_escala'";
    $resultado_escala = $conn->query($query_escala);
        $dados_escala = $resultado_escala->fetch_assoc();
            $id_usuario_escala = $dados_escala['id_usuario'];
            $inicioexpediente_escala = $dados_escala['horarioinicio'];
            $intervaloinicio_escala = $dados_escala['intervaloinicio'];
            $intervalofim_escala = $dados_escala['intervalofim'];
            $horariofim_escala = $dados_escala['horariofim'];
            $local_escala = $dados_escala['local'];
            $dia_escala = $dados_escala['dia'];
            $mes_escala = $dados_escala['mes'];
            $ano_escala = $dados_escala['ano'];
            
            // switch ($inicioexpediente_escala) {
            //     case "01:00:00":
            //         $inicioexpediente = "01-07";
            //         break;
            //     case "07:00:00":
            //         $inicioexpediente = "07-13";
            //         break;
            //     case "13:00:00":
            //         $inicioexpediente = "13-19";
            //         break;
            //     case "19:00:00":
            //         $inicioexpediente = "19-01";
            //         break;
            //     default:
            //         break;
            // }

$query_usuarioescalado = "SELECT * FROM usuario WHERE id='$id_usuario_escala'";   
    $resultado_usuarioescalado = $conn->query($query_usuarioescalado);
        $dados_usuarioescalado = $resultado_usuarioescalado->fetch_assoc();
            $nome_usuarioescalado = $dados_usuarioescalado['nome'];
?>

    <form method="POST" action="sec/atualizaturno.php?id=<?php echo "$id_escala"; ?>&dia=<?php echo "$dia_escala"; ?>&mes=<?php echo "$mes_escala"; ?>&ano=<?php echo "$ano_escala"; ?>">
        <div class="form-group form-group-default">
            <label><b>Nome:</b></label>
                <select class="form-select" id="nome" name="nome">
                    <?php
                        // Preenche o dropdown com os usuários
                        $query_usuarios = "SELECT * FROM usuario WHERE NOT id='$id_usuario_escala' ORDER BY login ASC";
                        $result_usuarios = $conn->query($query_usuarios);
                                echo '<option value="' . $id_usuario_escala . '">' . $nome_usuarioescalado . '</option>';                       
                            while($row = $result_usuarios->fetch_assoc()) {
                                echo '<option value="' . $row["id"] . '">' . $row["nome"] . '</option>';
                            }
                        
                    ?>
                </select>
        </div>

        <div class="form-group form-group-default">
            <label><b>Data:</b></label>
                <?php echo "$dia_escala/$mes_escala/$ano_escala";?>
                           
        </div>

        <div class="form-group form-group-default">
            <label for="horarioexpediente"><b>Horário de expediente:</b></label>
            <select class="form-select" id="horarioexpediente" name="horarioexpediente">
                <?php
                switch ($inicioexpediente_escala) {
                    case "01:00:00":
                        echo '<option selected value="01-07">01h as 07h</option>';
                        echo '<option value="07-13">07h as 13h</option>';
                        echo '<option value="13-19">13h as 19h</option>';
                        echo '<option value="19-01">19h as 01h</option>';
                        break;
                    case "07:00:00":
                        echo '<option value="01-07">01h as 07h</option>';
                        echo '<option selected value="07-13">07h as 13h</option>';
                        echo '<option value="13-19">13h as 19h</option>';
                        echo '<option value="19-01">19h as 01h</option>';
                        break;
                    case "13:00:00":
                        echo '<option value="01-07">01h as 07h</option>';
                        echo '<option value="07-13">07h as 13h</option>';
                        echo '<option selected value="13-19">13h as 19h</option>';
                        echo '<option value="19-01">19h as 01h</option>';
                        break;
                    case "19:00:00":
                        echo '<option value="01-07">01h as 07h</option>';
                        echo '<option value="07-13">07h as 13h</option>';
                        echo '<option value="13-19">13h as 19h</option>';
                        echo '<option selected value="19-01">19h as 01h</option>';
                        break;
                    default:
                        break;
                }
                ?>
            </select>
        </div>

        <div class="form-group form-group-default">
            <label for="localdetrabalho"><b>Local:</b></label>
            <select class="form-select" id="localdetrabalho" name="localdetrabalho">
            <?php
                switch ($local_escala) {
                    case "TJ":
                        echo '<option selected value="TJ">TJ</option>';
                        echo '<option value="FC2">FC2</option>';                    
                        break;
                    case "FC2":
                        echo '<option value="TJ">TJ</option>';
                        echo '<option selected value="FC2">FC2</option>';  
                        break;               
                    default:
                        break;
                }
                ?>
            </select>
        </div>

        <div class="selecionar">
            <div class="nav">
                <button class="botao" type="submit">Editar turno</button>        
            </div>
        </div>
    </form>

    <div id="validacaoinfo"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function(){
        // Função para enviar os dados do formulário via POST
        $('select').on('change', function() {
            // Coleta os dados do formulário
            var nome = $('#nome').val();
            var horarioexpediente = $('#horarioexpediente').val();
            var localdetrabalho = $('#localdetrabalho').val();

            // Envia os dados via POST
            $.ajax({
                url: 'sec/edita_coletadados.php?id=<?php echo $id_escala; ?>&dia=<?php echo $dia_escala; ?>&mes=<?php echo $mes_escala; ?>&ano=<?php echo $ano_escala; ?>',
                type: 'POST',
                data: {
                    nome: nome,
                    horarioexpediente: horarioexpediente,
                    localdetrabalho: localdetrabalho
                },
                success: function(data) {
                    $('#validacaoinfo').html(data);
                },
                error: function() {
                    $('#validacaoinfo').html('<p>Erro ao carregar os dados.</p>');
                }
            });
        });
    });
    </script>


<?php
include "tudo_baixo.php";
?>