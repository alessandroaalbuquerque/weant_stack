<?php 
include "tudo_cima.php";
if ( $nivel < 2 ) 
{
    header("Location: sem_acesso.php"); exit;
}
?>
<!-- INICIA CONTEÚDO -->   

<p align="center">
    <b>CRIAR CONTRATO</b>
</p>
<?php
$query_validacao_licenca = "SELECT * FROM licenca WHERE id_usuario = '$idlogado'";
    $resultado_validacao_licenca = $conn->query($query_validacao_licenca);
        $dados_validacao_licenca = $resultado_validacao_licenca->fetch_assoc();  
            $id_cliente_validacao_licenca = $dados_validacao_licenca['id_cliente']; 
?>

<form method='post' action='sec/enviarcontrato.php?cliente=<?php echo "$id_cliente_validacao_licenca"; ?>' class="user-form">
    <div class="form-group">
        <label for="contrato">Nome do Contrato:</label>
        <div style="display: flex; align-items: center;">
            <input type="text" name="contrato" id="contrato" class="form-control" required oninvalid="this.setCustomValidity('Insira um nome para o contrato')" onchange="try{setCustomValidity('')}catch(e){}" style="flex: 1; margin-right: 10px;" />            
        </div>
    </div>    

    <div class="form-group">
        <label>Status:</label><br />
        <div class="d-flex">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="statuscontrato" id="statuscontrato" value="1" checked/>
            <label class="form-check-label" for="1">Ativado</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="statuscontrato" id="statuscontrato" value="0"/>
            <label class="form-check-label" for="0">Desativado</label>
        </div>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Vincule ao(s) profissional(is):</label> </br>
        <?php include 'sec/pesquisa_coletausuarios.php';?>
    </div>

    <div id="dynamic-inputs">
        <div class="form-group">          
            <label for="local1">Local 1:</label>
            <div style="display: flex; align-items: center;">
                <input type="text" name="local1" id="local1" class="form-control" required oninvalid="this.setCustomValidity('Insira pelo menos um local')" onchange="try{setCustomValidity('')}catch(e){}" style="flex: 1; margin-right: 5px;" />   
                <button type="button" class="btn btn-sm btn-outline-success" onclick="addInput()">+</button>
            </div>                   
        </div>
    </div>

    <div class="form-group"> 
    </div>
    
    <div class="form-group">                    
        <button class="botao" type="submit">CADASTRAR CONTRATO</button>                    
    </div>                
</form>

<script>
let inputCount = 1;

function addInput() {
    inputCount++;
    const newInputDiv = document.createElement('div');
    newInputDiv.className = 'form-group';
    newInputDiv.innerHTML = `                
        <label for="local${inputCount}">Local ${inputCount}:</label>
        <div style="display: flex; align-items: center;">
            <input type="text" name="local${inputCount}" id="local${inputCount}" class="form-control" style="flex: 1; margin-right: 5px;" />            
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecificInput(${inputCount})">-</button>
        </div>                
    `;
    document.getElementById('dynamic-inputs').appendChild(newInputDiv);
}

function removeSpecificInput(id) {
    const dynamicInputs = document.getElementById('dynamic-inputs');
    const inputToRemove = document.getElementById(`local${id}`).parentNode.parentNode;
    if (inputToRemove) {
        dynamicInputs.removeChild(inputToRemove);
        inputCount--;
    }
}



function removeSpecificInput(id) {
    const dynamicInputs = document.getElementById('dynamic-inputs');
    const inputToRemove = document.getElementById(`local${id}`).parentNode.parentNode;
    if (inputToRemove) {
        dynamicInputs.removeChild(inputToRemove);
        inputCount--;
    }
}
</script>

<!-- FINALIZA CONTEÚDO -->  

<?php
include "tudo_baixo.php";
?>
