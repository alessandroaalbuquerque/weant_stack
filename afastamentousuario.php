<?php
include "tudo_cima.php"; 
if ( $nivel < 2 ) 
{
	header("Location: sem_acesso.php"); exit;
}
?>
            <!-- INICIA CONTEÚDO -->   

            <p align="center">
              <b>REGISTRO DE AFASTAMENTO</b>
            </p>
                
            <form method='post' action="sec/enviarafastamento.php?id=<?php echo $dados['id'];?>" class="user-form">
                    <div class="form-group">
                    <label for="motivo">Motivo:</label>
                    <input type="text" name="motivo" id="motivo" class="form-control" />
                    </div>

                    <div class="form-group">
                    <label for="datainicial">Data inicial:</label>
                  <input type="date" name="datainicial" id="datainicial" class="form-control" />
                </div>

                <div class="form-group">
                  <label for="datafinal">Data final:</label>
                  <input type="date" name="datafinal" id="datafinal" class="form-control" />
                </div>
                
                <div class="form-group">
                <button type="submit" style="background-color: #2a2f5b; color: white; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin-top: 10px; cursor: pointer; border-radius: 4px;"onmouseover="this.style.backgroundColor='#8800ff'"onmouseout="this.style.backgroundColor='#2a2f5b'">Cadastrar</button>
                </div>
            </form>

            <!-- FINALIZA CONTEÚDO -->  

<?php
include "tudo_baixo.php"; 
?>