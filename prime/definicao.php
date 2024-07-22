<?php
$credencial = $_GET['credencial'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>    
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WeAnt</title>
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="icon" href="../assets/img/kaiadmin/favicon_1.ico" type="image/x-icon"/>
  <style>
.text-display {
      color: white;
      font-family: 'Arial', sans-serif;
      font-size: 1.2em;
    }
    .hidden {
      display: none;
    }
    .button {
      background-color: #4CAF50; /* Verde */
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }
    .next-display {
      color: white;
      font-family: 'Arial', sans-serif;
      font-size: 1.2em;
    }

  </style>
</head>

<body>

<div align="center" class="page">

  <div id='seuElemento' class="text-display"></div> 
  <div id="nextDiv" class="next-display hidden">
    <p>Agora você irá cadastrar seu usuário de gestão</p>
    <form method="POST" action="../sec/prime_enviausuario.php?credencial=<?php echo $credencial; ?>">
        <input type="text" name="nome" placeholder="Digite seu nome completo">        
    </form>    
  </div>
</div>
  
<script>
function exibirLetraPorLetra(texto, elemento, callback) {
  let index = 0;
  const intervalo = 1; // intervalo em milissegundos entre cada letra

  function mostrarProximaLetra() {
    if (index < texto.length) {
      if (texto[index] === '\n') {
        elemento.innerHTML += '<br>'; // Adiciona quebra de linha no HTML
      } else {
        elemento.innerHTML += texto.charAt(index); // Muda para innerHTML
      }
      index++;
      setTimeout(mostrarProximaLetra, intervalo);
    } else if (callback) {
      callback();
    }
  }

  mostrarProximaLetra();
}

function mostrarBotao() {
  const botao = document.createElement('button');
  botao.innerHTML = 'CONTINUAR';
  botao.className = 'button';
  botao.onclick = function() {
    document.getElementById('seuElemento').classList.add('hidden');
    document.getElementById('nextDiv').classList.remove('hidden');
  };
  document.getElementById('seuElemento').appendChild(botao);
}

// Exemplo de uso:
const credencial = "<?php echo $credencial; ?>";
const textoParaExibir = `Parabéns!\n
CNPJ ${credencial} agora têm licença X.\n
Seu produto têm os recursos:\n
- Usuários ilimitados.\n
- Contratos ilimitados\n
- Suporte 24h\n
- Central de monitoramento 24h\n
- IT Service Manager (Gestão de requisições, incidentes, problemas, mudanças e inventário)\n
\n
Vamos te guiar a parametrizar seu serviço... \n\n`;

const elementoParaExibir = document.getElementById('seuElemento'); // substitua 'seuElemento' pelo ID do elemento onde deseja exibir o texto

exibirLetraPorLetra(textoParaExibir, elementoParaExibir, mostrarBotao);
</script>   
  
</body>
</html>
