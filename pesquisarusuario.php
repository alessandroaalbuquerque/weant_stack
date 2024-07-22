<?php 
include "tudo_cima.php";
if ($nivel < 2) {
    header("Location: sem_acesso.php"); exit;
}
?>

<p align="center">
 <b>PESQUISAR USUÁRIO</b>
</p>

<style>
  .container {
    flex: 1;
    width: 80%;
    margin: auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
  }

  .search-form {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .search-form select, .search-form input[type="text"], .search-form input[type="submit"] {
    padding: 10px;
    margin: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
  }

  .search-form select {
    width: 150px;
  }

  .search-form input[type="text"] {
    flex: 1;
  }

  .search-form input[type="submit"] {
    background-color: #1f283e;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .search-form input[type="submit"]:hover {
    background-color: #6861CE;
  }

  table.legenda {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  table.legenda th, table.legenda td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
  }

  table.legenda th {
    background-color: #1f283e;
    color: white;
  }

  table.legenda tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  table.legenda tr:nth-child(odd) {
    background-color: #ffffff;
  }

  .record-count {
    text-align: right;
    margin-top: 10px;
  }
</style>

<div class="search-form">
  <form action="" method="post" style="display: flex; width: 100%;">
    <select name="filtro">
      <option value="login">Login</option> 
      <option value="nome">Nome</option>  
      <option value="cpf">CPF</option>  
      <option value="telefone">Celular</option>                        
      <option value="pnivel">Nível</option> 
      <option value="pativo">Status</option> 
    </select>                
    <input type="text" name="palavra" id="palavra"/> 
    <input type="submit" Value="Pesquisar"/>
  </form>               
</div>

<?php
$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';
$busca = isset($_POST['palavra']) ? $_POST['palavra'] : '';

if (!empty($filtro) && !empty($busca)) {
  // Escapa as variáveis para evitar injeção de SQL
  $filtro = $conn->real_escape_string($filtro);
  $busca = $conn->real_escape_string($busca);
  
  if (($nivel > 2 ) && ($tipo_vdl_licenca > 5)){
  $busca_query = "SELECT * FROM usuario WHERE $filtro LIKE '%$busca%' ORDER BY id";
  }
  else {
  $busca_query = "SELECT DISTINCT u.*
                  FROM usuario u
                  JOIN licenca rc ON u.id = rc.id_usuario
                  WHERE rc.id_cliente = $id_cliente_vdl_licenca AND u.$filtro LIKE '%$busca%'
                  ORDER BY u.id DESC";
  }
  $result = $conn->query($busca_query);              
  
  if ($result->num_rows < 1) {
    echo "<p>Nenhum registro encontrado.</p>";
  } else {
?>

<table class="legenda">                
  <tr>
    <?php 
    if ($filtro == "login") { 
      echo '<th>Login</th>';
    } elseif ($filtro == "cpf") { 
      echo '<th>Login</th><th>CPF</th>';
    } elseif ($filtro == "pativo") { 
      echo '<th>Login</th><th>Status</th>';
    } else {
      $upercasefiltro = ucfirst($filtro);
      echo '<th>Login</th><th>'. $upercasefiltro . '</th>';
    }
    ?>          
  </tr>
  <?php      
  while ($dados = $result->fetch_assoc()) {                                 
  ?>              
  <tr>  
    <?php
    if ($filtro == "login") { 
      echo '<td><a href="editarusuario.php?id=' . $dados['id'] . '">' . $dados['login'] . '</a></td>';
    } else {
      echo '<td><a href="editarusuario.php?id=' . $dados['id'] . '">' . $dados['login'] . '</a></td><td>'. $dados[$filtro] . '</td>';
    }
    ?>                      
  </tr> 
  <?php               
  }
  ?>  
</table>
<div class="record-count">
  <?php 
  $num_rows = $result->num_rows;
  echo "<p><b>$num_rows registros</b></p>";
  ?>
</div>

<?php
  }
} else {
  echo "<p>Nenhum registro encontrado.</p>";
}
?>

<!-- FINALIZA CONTEÚDO -->  

<?php
include "tudo_baixo.php";
?>
