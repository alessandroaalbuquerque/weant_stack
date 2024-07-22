<?php 
include "tudo_cima.php";
if ( $nivel < 2 ) 
{
	header("Location: sem_acesso.php"); exit;
}
?>
            <!-- INICIA CONTEÚDO -->   

            <p align="center">
              <b>CRIAR USUÁRIO</b>
            </p>
                
            <form method='post' name="contato" action="sec/enviarusuario.php" class="user-form">
                <div class="form-group">
                  <label for="login">Login:</label>
                  <input type="text" name="login" id="login" class="form-control" />
                </div>

                <div class="form-group">
                  <label for="nome">Nome:</label>
                  <input type="text" name="nome" id="nome" class="form-control" />
                </div>

                <div class="form-group">
                  <label for="cpf">CPF:</label>
                  <input type="text" name="cpf" id="cpf" class="form-control" />
                </div>

                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="text" name="email" id="email" class="form-control" />
                </div>

                <div class="form-group">
                  <label for="telefone">Celular:</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">+55</span>
                    <input type="text" class="form-control" placeholder="xx xxxxx-xxxx" maxlength="12" onKeyPress="Mascaracelular(this); return SomenteNumero(event);" id="celular" name="celular"/>
                  </div>
                </div>

                <div class="form-group">
                  <label for="nascimento">Data de Nascimento:</label>
                  <input type="date" name="nascimento" id="nascimento" class="form-control" placeholder="xx/xx/xxxx" />
                </div>

                <div class="form-group">
                  <label>Gênero</label><br />
                  <div class="d-flex">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="genero" id="genero" value="Masculino" checked/>
                      <label class="form-check-label" for="Masculino">Masculino</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="genero" id="genero" value="Feminino"/>
                      <label class="form-check-label" for="Feminino">Feminino</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="genero" id="genero" value="Outro"/>
                      <label class="form-check-label" for="Outro">Outro</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Nível</label><br />
                  <div class="d-flex">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="nivelusuario" id="nivelusuario" value="1" checked/>
                      <label class="form-check-label" for="1">Usuário</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="nivelusuario" id="nivelusuario" value="2"/>
                      <label class="form-check-label" for="2">Gestor</label>
                    </div>
                  </div>
                </div>
                  
                <div class="form-group">
                  <label>Status:</label><br />
                  <div class="d-flex">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="ativousuario" id="ativousuario" value="1" checked/>
                      <label class="form-check-label" for="1">Ativado</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="ativousuario" id="ativousuario" value="0"/>
                      <label class="form-check-label" for="0">Desativado</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Vincule ao(s) contrato(s):</label> </br>
                    <?php include 'sec/pesquisa_coletacontratos.php';?>
                </div>

                  <!-- <div class="form-group">   
                    <label class="form-label">Vincule ao(s) local(is):</label> </br>                 
                    <div id="content"></div>                    
                  </div>  -->
                  
                  <div class="form-group">                    
                    <button class="botao" type="submit">CADASTRAR USUÁRIO</button>                    
                  </div>                
            </form>

            <!-- <script>
        function loadExternalContent() {
            var checkboxes = document.querySelectorAll('.selectgroup-input.contratos');
            var selectedValues = [];

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    selectedValues.push(checkbox.value);
                }
            });

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'sec/pesquisa_coletalocais.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('content').innerHTML = xhr.responseText;
                }
            };
            xhr.send('selectedValues=' + JSON.stringify(selectedValues));
        }

        window.onload = function() {
            loadExternalContent();
            var checkboxes = document.querySelectorAll('.selectgroup-input.contratos');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', loadExternalContent);
            });
        }
    </script> -->


            <!-- FINALIZA CONTEÚDO -->  
          
<?php
include "tudo_baixo.php";
?>
