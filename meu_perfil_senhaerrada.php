<?php
include "tudo_cima.php"; 

              $sqlc = "SELECT * FROM usuario WHERE id='$idlogado'"; //faz a busca com as palavras enviadas
              $result = $conn->query($sqlc);
              $dados = $result->fetch_assoc();
              
              $id = $dados['id'];
              $login = $dados["login"];
              $nome = $dados["nome"];
              $cpf = $dados["cpf"];
              $telefone = $dados["telefone"];
              $nascimento = $dados["nascimento"];              
              $email = $dados["email"];
              $pnivel = $dados["pnivel"];
              $pativo = $dados["pativo"];
              $gerasenha = $dados["gerasenha"];
              $horario = $dados["horario"];
              $dia = $dados["dia"];
              $semana = $dados["semana"];
              $mes = $dados["mes"];
              $ano =$dados["ano"];
              $operador = $dados["operador"];

?>

            <!-- INICIA CONTEÚDO -->              

            <div class="form-group">
                <label><b>Login:</b></label>
                <?php echo $login;?>
            </div>

            <div class="form-group">
                <label><b>Nome:</b></label>
                <?php echo $nome;?>
            </div>

            <div class="form-group">
                <label><b>CPF:</b></label>
                <?php echo $cpf;?>
            </div>

            <div class="form-group">
                <label><b>Email:</b></label>
                <?php echo $email;?>
            </div>

            <div class="form-group">
                <label><b>Celular:</b></label>
                <?php echo $telefone;?>
            </div>

            <div class="form-group">
                <label><b>Nivel:</b></label>
                <?php echo $pnivel;?>
            </div>

            <div class="form-group">                   
                <form method="POST" action="sec/alterarsenha.php"> 
                    <input type="pass" name="senhaatual" placeholder="Senha atual"> </br>
                    <input type="pass" name="senhanova" placeholder="Nova atual"> </br>    
                    <div style="color: red;">Senha não confere!</div> </br>       
                    <button class="botao" type="submit">Alterar senha</button>   
                </form>                    
            </div>
            
         <!-- FINALIZA CONTEÚDO -->

<?php
include "tudo_baixo.php"; 
?>