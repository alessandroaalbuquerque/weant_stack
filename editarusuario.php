<?php
include "tudo_cima.php"; 
if ($nivel < 2) {
    header("Location: sem_acesso.php");
    exit;
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script>
function redirectTo(url, id) {
    window.location.href = url + '?id=' + id;
}
</script>

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
    <b>EDITAR USUÁRIO</b>
</p>

<?php
$id = $_GET['id'];

$query_get_licenca = "SELECT * FROM licenca WHERE id_usuario = '$id'";
  $resultado_get_licenca = $conn->query($query_get_licenca);
    $dados_get_licenca = $resultado_get_licenca->fetch_assoc();  
      $id_cliente_get_licenca = $dados_get_licenca['id_cliente']; 

if (($id_cliente_vdl_licenca <> $id_cliente_get_licenca) && ($nivel < 3 ) && ($tipo_vdl_licenca < 6)){
    echo "VOCÊ NÃO TEM PERMISSÃO!";
}      
else {
      

    if ($id_cliente_get_licenca)

    $sqlc = "SELECT * FROM usuario WHERE id='$id'";
    $query = $conn->query($sqlc);
    $dados = $query->fetch_assoc();

    $login = $dados["login"];           
    $nome = $dados["nome"];
    $cpf = $dados["cpf"];
    $telefone = $dados["telefone"];
    $nascimento = $dados["nascimento"];  
    $genero = $dados["genero"];             
    $email = $dados["email"];
    $cargo = $dados["cargo"];
    $departamento = $dados["departamento"];
    $nivelusuario = $dados["nivel"];
    $ativousuario = $dados["ativo"];
    $horario = $dados["horario"];
    $dia = $dados["dia"];
    $semana = $dados["semana"];
    $mes = $dados["mes"];
    $ano = $dados["ano"];
    $operador = $_SESSION["UsuarioLogin"];

    $sqlc1 = "SELECT * FROM usuario WHERE operador='$operador'";
    $query1 = $conn->query($sqlc1);
    $dados1 = $query1->fetch_assoc();
    ?>

    <form method="POST" action='sec/atualizarusuario.php?id=<?php echo $dados['id']; ?>'>
        
        <div class="form-group">
            <label for="login"><b>Login:</b></label>
            <input type="text" name="login" id="login" class="form-control" value="<?php echo $login;?>"/>
        </div>
        <script>
            const loginInput = document.getElementById('login');
            const login = '<?php echo $nome; ?>'; // Substitua com o valor PHP adequado  
            function checklogin() {
                if (loginInput.value !== login) {
                    loginInput.classList.add('border-changed');
                } else {
                    loginInput.classList.remove('border-changed');
                }
            }
            loginInput.addEventListener('input', checklogin);
            window.addEventListener('load', checknlogin); // Verifica o valor inicial ao carregar a página
        </script>

        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $nome;?>"/>
        </div>
        <script>
            const nomeInput = document.getElementById('nome');
            const nome = '<?php echo $nome; ?>'; // Substitua com o valor PHP adequado  
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
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $cpf;?>"/>
        </div>
        <script>
            const cpfInput = document.getElementById('cpf');
            const cpf = '<?php echo $cpf; ?>'; // Substitua com o valor PHP adequado  
            function checkcpf() {
                if (cpfInput.value !== cpf) {
                    cpfInput.classList.add('border-changed');
                } else {
                    cpfInput.classList.remove('border-changed');
                }
            }
            cpfInput.addEventListener('input', checkcpf);
            window.addEventListener('load', checkcpf); // Verifica o valor inicial ao carregar a página
        </script>


        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" class="form-control" value="<?php echo $email;?>"/>
        </div>
        <script>
            const emailInput = document.getElementById('email');
            const email = '<?php echo $email; ?>'; // Substitua com o valor PHP adequado  
            function checkemail() {
                if (emailInput.value !== email) {
                    emailInput.classList.add('border-changed');
                } else {
                    emailInput.classList.remove('border-changed');
                }
            }
            emailInput.addEventListener('input', checkemail);
            window.addEventListener('load', checkemail); // Verifica o valor inicial ao carregar a página
        </script>


        <div class="form-group">
            <label for="telefone">Celular:</label>
            <input type="text" name="telefone" id="telefone" class="form-control" placeholder="(xx) xxxxx-xxxx" value="<?php echo $telefone;?>"/>
        </div>
        <script>
            const telefoneInput = document.getElementById('telefone');
            const telefone = '<?php echo $telefone; ?>'; // Substitua com o valor PHP adequado

            function checkTelefone() {
                if (telefoneInput.value !== telefone) {
                    telefoneInput.classList.add('border-changed');
                } else {
                    telefoneInput.classList.remove('border-changed');
                }
            }

            telefoneInput.addEventListener('input', checkTelefone);
            window.addEventListener('load', checkTelefone); // Verifica o valor inicial ao carregar a página
        </script>


        <div class="form-group">
            <label for="nascimento">Data de Nascimento:</label>
            <input type="text" name="nascimento" id="nascimento" class="form-control" value="<?php echo $nascimento;?>"/>
        </div>
        <script>
            const nascimentoInput = document.getElementById('nascimento');
            const nascimento = '<?php echo $nascimento; ?>'; // Substitua com o valor PHP adequado

            function checknascimento() {
                if (nascimentoInput.value !== nascimento) {
                    nascimentoInput.classList.add('border-changed');
                } else {
                    nascimentoInput.classList.remove('border-changed');
                }
            }

            nascimentoInput.addEventListener('input', checknascimento);
            window.addEventListener('load', checknascimento); // Verifica o valor inicial ao carregar a página
        </script>
        

        <div class="form-group">
            <label>Gênero:</label>
            <div class="d-flex">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="genero" id="generoMasculino" value="Masculino" <?php if ($genero == "Masculino") echo "checked"; ?>/>
                    <label class="form-check-label" for="generoMasculino">Masculino</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="genero" id="generoFeminino" value="Feminino" <?php if ($genero == "Feminino") echo "checked"; ?>/>
                    <label class="form-check-label" for="generoFeminino">Feminino</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="genero" id="generoOutro" value="Outro" <?php if ($genero == "Outro") echo "checked"; ?>/>
                    <label class="form-check-label" for="generoOutro">Outro</label>
                </div>
            </div>
        </div>
        <script>
            const generoInputs = document.querySelectorAll('input[name="genero"]');
            const genero = '<?php echo $genero; ?>'; // Substitua com o valor PHP adequado

            function checkGenero() {
                generoInputs.forEach(input => {
                    const label = input.nextElementSibling;
                    if (input.checked && input.value !== genero) {
                        label.classList.add('color-label');
                    } else {
                        label.classList.remove('color-label');
                    }
                });
            }

            generoInputs.forEach(input => {
                input.addEventListener('change', checkGenero);
            });

            window.addEventListener('load', checkGenero); // Verifica o valor inicial ao carregar a página
        </script>
        

        <div class="form-group">
            <label>Nível:</label><br />
            <div class="d-flex">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="nivelusuario" id="nivelusuario" value="1" <?php if ($nivelusuario == "1") echo 'checked'; ?>/>
                    <label class="form-check-label" for="nivelusuarioUsuário">Usuário</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="nivelusuario" id="nivelusuario" value="2" <?php if ($nivelusuario == "2") echo 'checked'; ?>/>
                    <label class="form-check-label" for="nivelusuarioGestor">Gestor</label>            
                </div>
            </div>
        </div>
        <script>
            const nivelusuarioInputs = document.querySelectorAll('input[name="nivelusuario"]');
            const nivelusuario = '<?php echo $nivelusuario; ?>'; // Substitua com o valor PHP adequado

            function checkNivelusuario() {
                nivelusuarioInputs.forEach(input => {
                    const label = input.nextElementSibling;
                    if (input.checked && input.value !== nivelusuario) {
                        label.classList.add('color-label');
                    } else {
                        label.classList.remove('color-label');
                    }
                });
            }

            nivelusuarioInputs.forEach(input => {
                input.addEventListener('change', checkNivelusuario);
            });

            window.addEventListener('load', checkNivelusuario); // Verifica o valor inicial ao carregar a página
        </script>

            
        <div class="form-group">
            <label>Status:</label><br />
            <div class="d-flex">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ativousuario" id="ativousuario" value="1" <?php if ($ativousuario == "1") echo 'checked'; ?>/>
                    <label class="form-check-label" for="1">Ativo</label>            
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ativousuario" id="ativousuario" value="0" <?php if ($ativousuario == "0") echo 'checked'; ?>/>
                    <label class="form-check-label" for="0">Desativado</label>  
                </div>
        </div>
        <script>
            const ativousuarioInputs = document.querySelectorAll('input[name="ativousuario"]');
            const ativousuario = '<?php echo $ativousuario; ?>'; // Substitua com o valor PHP adequado

            function checkAtivousuario() {
                ativousuarioInputs.forEach(input => {
                    const label = input.nextElementSibling;
                    if (input.checked && input.value !== ativousuario) {
                        label.classList.add('color-label');
                    } else {
                        label.classList.remove('color-label');
                    }
                });
            }

            ativousuarioInputs.forEach(input => {
                input.addEventListener('change', checkAtivousuario);
            });

            window.addEventListener('load', checkAtivousuario); // Verifica o valor inicial ao carregar a página
        </script>


        <input type="hidden" name="checkbox_changed" id="checkbox_changed" value="no">
        <div class="form-group">
            <label>Vincule ao(s) contrato(s):</label>
            <div class="d-flex">               
                <?php include 'sec/pesquisa_coletacontratos_editarusuario.php'; ?>       
            </div>
        </div>
        
    
        <div class="form-group" align="center">                                   
            <button class="botao" type="submit">EDITAR USUÁRIO</button>
            <button class="botao" type="button" onclick="redirectTo('sec/enviarsenhausuario.php', <?php echo $dados['id']; ?>)">GERAR NOVA SENHA</button>
            <button class="botao" type="button" onclick="redirectTo('afastamentousuario.php', <?php echo $dados['id']; ?>)">CADASTRAR AFASTAMENTO</button>                         
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
