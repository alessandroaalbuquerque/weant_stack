<?php
include "tudo_cima.php"; 
if ($nivel < 2) {
    header("Location: sem_acesso.php");
    exit;
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<style>
    .border-changed {
        border-color: #8800ff !important;
    }
    .color-label{
        color: #8800ff !important;
        font-weight: bold;
    }
</style>

<!-- INICIA CONTEÚDO -->
 
<p align="center">
    <b>EDITAR CONTRATO</b>
</p>

<?php
$id = $_GET['id'];

$sqlcontrato = "SELECT * FROM contrato WHERE id='$id'";
    $querycontrato = $conn->query($sqlcontrato);
        $dadoscontrato = $querycontrato->fetch_assoc();         
            $nomecontrato = $dadoscontrato["nome"];
            $statuscontrato = $dadoscontrato['status'];
?>

<form method="POST" action='sec/atualizarusuario.php?id=<?php echo $dados['id']; ?>'>
    
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $nomecontrato;?>"/>
    </div>
    <script>
        const nomeInput = document.getElementById('nome');
        const nome = '<?php echo $nomecontrato; ?>'; // Substitua com o valor PHP adequado  
        function checknome() {
            if (nomeInput.value !== nome) {
                nomeInput.classList.add('border-changed');
            } else {
                nomeInput.classList.remove('border-changed');
            }
        }
        nomeInput.addEventListener('input', checknome);
        window.addEventListener('load', checknome); // Verifica o valor inicial ao carregar a página
    </script>    


    <div class="form-group">
        <label>Status:</label><br />
        <div class="d-flex">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="statuscontrato" id="statuscontrato" value="1" <?php if ($statuscontrato == "1") echo 'checked'; ?>/>
                <label class="form-check-label" for="1">Ativo</label>            
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="statuscontrato" id="statuscontrato" value="0" <?php if ($statuscontrato == "0") echo 'checked'; ?>/>
                <label class="form-check-label" for="0">Desativado</label>  
            </div>
    </div>
    <script>
            const statuscontratoInputs = document.querySelectorAll('input[name="statuscontrato"]');
            const statuscontrato = '<?php echo $statuscontrato; ?>'; // Substitua com o valor PHP adequado

            function checkstatuscontrato() {
                statuscontratoInputs.forEach(input => {
                    const label = input.nextElementSibling;
                    if (input.checked && input.value !== statuscontrato) {
                        label.classList.add('color-label');
                    } else {
                        label.classList.remove('color-label');
                    }
                });
            }

            statuscontratoInputs.forEach(input => {
                input.addEventListener('change', checkstatuscontrato);
            });

            window.addEventListener('load', checkstatuscontrato); // Verifica o valor inicial ao carregar a página
        </script>


    <input type="hidden" name="checkbox_changed" id="checkbox_changed" value="no">
    <div class="form-group">
        <label>Vincule ao(s) profissional(is):</label>
        <div class="d-flex">               
            <?php include 'sec/pesquisa_coletausuarios_editarcontrato.php'; ?>       
        </div>
    </div>
    
   
    <div class="form-group">                                   
        <button class="botao" type="submit">EDITAR CONTRATO</button>                                
    </div>
</form>

<br />

<style>
    /* Estilos para a tabela de histórico */
    .legenda {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
        font-family: Arial, sans-serif;
    }
    .legenda th, .legenda td {
        border: 1px solid #dddddd;
        padding: 8px;
        text-align: left;
    }
    .legenda th {
        background-color: #f2f2f2;
    }
    .legenda a {
        color: #007bff;
        text-decoration: none;
    }
    .legenda a:hover {
        text-decoration: underline;
    }

    /* Estilos para o botão de mostrar/ocultar */
    #toggleHistory {
        background-color: #2a2f5b;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        margin-top: 10px;
        border-radius: 4px;
        font-size: 12px;
    }
    #toggleHistory:hover {
        background-color: #8800ff;
    }
</style>


<button id="toggleHistory" onmouseover="this.style.backgroundColor='#8800ff'" onmouseout="this.style.backgroundColor='#2a2f5b'">Mostrar Histórico</button>

<table id="historicoTable" class="legenda" style="display: none;">
    <tr>    
        <th>Operador</th>           
        <th>Horário</th>
        <th>Dia</th>
        <th>Mês</th>
        <th>Ano</th>                  
    </tr>
    <?php
    $busca_query1 = "SELECT * FROM registrousuario WHERE login='$login' ORDER BY id DESC";
    $result = $conn->query($busca_query1);

    if ($result->num_rows > 0) {
        while ($dados1 = $result->fetch_assoc()) {
            ?>
            <tr>        
                <td><?php echo '<a href="exibirregistrousuario.php?id=' . $dados1['id'] . '">' . $dados1['operador'] . '</a>'; ?></td>       
                <td><?php echo $dados1['horario']; ?></td>
                <td><?php echo $dados1['dia']; ?></td>    
                <td><?php echo $dados1['mes']; ?></td>
                <td><?php echo $dados1['ano']; ?></td>                   
            </tr>
            <?php
        }
    } else {
        echo '<tr><td colspan="5">Nenhum registro encontrado.</td></tr>';
    }
    ?>
</table>

<?php
if ($result->num_rows > 0) { 
?> 
<table class="legenda" width="100%">
    <tr>
        <td align="right">
            <?php 
            $num_rows = $result->num_rows;
            echo "<b>$num_rows registros</b>";
            ?>
        </td>
    </tr>  
</table>
<?php
}
?>

<script>
    // Script para mostrar/ocultar o histórico ao clicar no botão
    document.getElementById('toggleHistory').addEventListener('click', function(event) {
    event.preventDefault(); // Impede o comportamento padrão do botão de enviar
    var table = document.getElementById('historicoTable');
    if (table.style.display === 'none') {
        table.style.display = 'table';
        this.textContent = 'Ocultar Histórico';
        this.style.backgroundColor = '#8800ff'; // Mudança de cor quando mostrado
    } else {
        table.style.display = 'none';
        this.textContent = 'Mostrar Histórico';
        this.style.backgroundColor = '#2a2f5b'; // Mudança de cor quando ocultado
    }
});
</script>

<!-- FINALIZA CONTEÚDO -->  

<?php
include "tudo_baixo.php";
?>
