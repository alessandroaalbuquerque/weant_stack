<?php 
include "tudo_cima.php";
if ($nivel < 2) {
    header("Location: sem_acesso.php"); exit;
}
?>

<p align="center">
 <b>PESQUISAR CONTRATO</b>
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


<?php


  if (($nivel > 2 ) && ($tipo_vdl_licenca > 5)){
  $busca_query = "SELECT * FROM contrato ORDER BY id";
  }
  else {
  $busca_query = "SELECT DISTINCT u.*
                  FROM contrato u
                  JOIN relacao_cliente rc ON u.id = rc.id_contrato
                  WHERE rc.id_cliente = $id_cliente_vdl_licenca
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
    echo "<th>Nome</th>"
    ?>          
  </tr>
  <?php      
  while ($dados = $result->fetch_assoc()) {                                 
  ?>              
  <tr>  
    <?php    
      echo '<td><a href="editarcontrato.php?id=' . $dados['id'] . '">' . $dados['nome'] . '</a></td>';
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

?>

<!-- FINALIZA CONTEÚDO -->  

<?php
include "tudo_baixo.php";
?>
