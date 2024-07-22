<?php
include "tudo_cima.php"; 
if ( $nivel < 2 ) 
{
	header("Location: sem_acesso.php"); exit;
}
?>
            
            <!-- INICIA CONTEÚDO -->  

            <div class="form-group form-group-default">
              <label><b>Nome:</b></label>
              <select class="form-select" id="nome" name="nome">
                  <?php
                      // Preenche o dropdown com os usuários
                      $query_usuarios = "SELECT * FROM usuario ORDER BY login ASC";
                      $result_usuarios = $conn->query($query_usuarios);
                      if ($result_usuarios->num_rows > 0) {
                          while($row = $result_usuarios->fetch_assoc()) {
                              echo '<option value="' . $row["id"] . '">' . $row["nome"] . '</option>';
                          }
                      } else {
                          echo '<option value="">Nenhum usuário encontrado</option>';
                      }
                  ?>
              </select>
            </div>

            <div class="form-group form-group-default">
                <label for="horarioexpediente"><b>Horário de expediente:</b></label>
                <select class="form-select" id="horarioexpediente" name="horarioexpediente">
                    <option value="01-07">01h as 07h</option>
                    <option value="07-13">07h as 13h</option>
                    <option value="13-19">13h as 19h</option>
                    <option value="19-01">19h as 01h</option>
                </select>
            </div>

            <div class="form-group form-group-default">
                <label for="localdetrabalho"><b>Local:</b></label>
                <select class="form-select" id="localdetrabalho" name="localdetrabalho">
                    <option value="TJ">TJ</option>
                    <option value="FC2">FC2</option>
                </select>
            </div>

            <div class="selecionar">
                <div class="nav">
                    <button class="botao" id="botaoexibircalendario">Mostrar Calendário</button>
                </div>
            </div>

            <div class="calendar">
                <div id="calendar" style="display: none;">
                    <header>
                        <h2 id="month-year">Julho 2024</h2>
                        <div class="nav">
                            <button onclick="prevMonth()">Anterior</button>
                            <button onclick="nextMonth()">Próximo</button>
                        </div>
                    </header>
                    <table>
                        <thead>
                            <tr>
                                <th>Dom</th>
                                <th>Seg</th>
                                <th>Ter</th>
                                <th>Qua</th>
                                <th>Qui</th>
                                <th>Sex</th>
                                <th>Sáb</th>
                            </tr>
                        </thead>
                        <tbody id="calendar-body">
                            <!-- Os dias do calendário serão gerados aqui -->
                        </tbody>
                    </table>
                    <footer>
                        
                    </footer>
                </div>

                <div class="selecionar">
                  <div class="nav">
                      <button class="botao" onclick="cadastrarDatas()">Cadastrar turnos</button>
                      <!--  <button style="color: green; background-color: transparent; border: none; padding: 5px 10px; margin-top: 20px;" id="botaovalidacaoinfo">+</button> -->
                  </div>
                </div>
                    </br>
                <div id="validacaoinfo">
                  <div id="selected-dates" class="hidden">
                      <!-- As datas selecionadas serão exibidas aqui -->
                  </div>

                  <div id="formulario-php">
                      <!-- O formulário PHP será exibido aqui -->
                  </div>
                </div>

            </div>

<script>
    // Adiciona listeners aos selects para chamar enviarDatas() ao alterar o valor
    window.onload = function() {
            document.getElementById('nome').addEventListener('change', enviarDatas);
            document.getElementById('horarioexpediente').addEventListener('change', enviarDatas);
            document.getElementById('localdetrabalho').addEventListener('change', enviarDatas);
            generateCalendar(currentMonth, currentYear);
        };
    
    document.getElementById('botaoexibircalendario').addEventListener('click', function() {
        var calendar = document.getElementById('calendar');
        var botaoexibircalendario = document.getElementById('botaoexibircalendario');
        if (calendar.style.display === 'none' || calendar.style.display === '') {
            calendar.style.display = 'block';
            botaoexibircalendario.textContent = 'Esconder Calendário';
        } else {
            calendar.style.display = 'none';
            botaoexibircalendario.textContent = 'Mostrar Calendário';
        }
    });   

//     document.getElementById('botaovalidacaoinfo').addEventListener('click', function() {
//       var validacaoinfo = document.getElementById('validacaoinfo');
//       var botaovalidacaoinfo = document.getElementById('botaovalidacaoinfo');
//       if (validacaoinfo.style.display === 'none' || validacaoinfo.style.display === '') {
//           validacaoinfo.style.display = 'block';
//           botaovalidacaoinfo.textContent = 'Atenção +';
//           botaovalidacaoinfo.style.color = 'green'; // Cor de fundo vermelho
//       } else {
//           validacaoinfo.style.display = 'none';
//           botaovalidacaoinfo.textContent = '-';
//           botaovalidacaoinfo.style.color = 'red'; // Cor de fundo verde
//       }
//       botaovalidacaoinfo.style.backgroundColor = 'transparent'; // Remove a cor de fundo do botão
//       botaovalidacaoinfo.style.border = 'none'; // Sem borda
//   });


const calendarBody = document.getElementById('calendar-body');
const monthYear = document.getElementById('month-year');
let today = new Date();
let currentMonth = today.getMonth(); // Mês atual
let currentYear = today.getFullYear(); // Ano atual
let selectedDates = [];

function generateCalendar(month, year) {
    // Limpa o calendário
    calendarBody.innerHTML = '';

    // Número de dias no mês
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();

    // Atualiza o cabeçalho do mês e ano
    const monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    monthYear.innerHTML = `${monthNames[month]} ${year}`;

    // Cria as células do calendário
    let date = 1;
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('tr');

        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            if (i === 0 && j < firstDay) {
                cell.innerHTML = '';
            } else if (date > daysInMonth) {
                break;
            } else {
                cell.innerHTML = date;
                cell.classList.add('day');
                const formattedDate = `${String(date).padStart(2, '0')}-${String(month + 1).padStart(2, '0')}-${year}`; // Formato dd-mm-yyyy

                // Marca a célula como selecionada se a data estiver no array de datas selecionadas
                if (selectedDates.includes(formattedDate)) {
                    cell.classList.add('selected');
                }

                // Adiciona ou remove a classe 'selected' ao clicar para marcar/desmarcar a seleção
                cell.onclick = () => {
                    if (cell.classList.contains('selected')) {
                        cell.classList.remove('selected');
                        selectedDates = selectedDates.filter(d => d !== formattedDate);
                    } else {
                        cell.classList.add('selected');
                        selectedDates.push(formattedDate);
                    }
                    enviarDatas(); // Chama a função enviarDatas() sempre que uma data é marcada/desmarcada
                };

                date++;
            }
            row.appendChild(cell);
        }
        calendarBody.appendChild(row);
    }
}

function prevMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar(currentMonth, currentYear);
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    generateCalendar(currentMonth, currentYear);
}

function cadastrarDatas() {
                  // Envia as datas selecionadas para o PHP
                  if (selectedDates.length > 0) {
                      const selectedDatesStr = selectedDates.join(',');
                      const nome = document.getElementById('nome').value;
                      const horarioExpediente = document.getElementById('horarioexpediente').value;
                      const localDeTrabalho = document.getElementById('localdetrabalho').value;
                      window.location.href = `sec/enviaturno.php?dates=${selectedDatesStr}&id=${nome}&horarioexpediente=${horarioExpediente}&localdetrabalho=${localDeTrabalho}`;
                  } else {
                      alert('Selecione pelo menos uma data!');
                  }
              }

function enviarDatas() {
    const selectedDatesElement = document.getElementById('selected-dates');
    selectedDatesElement.innerHTML = ''; // Limpa qualquer conteúdo anterior

    if (selectedDates.length > 0) {
        const selectedDatesStr = selectedDates.join(',');
        const nome = document.getElementById('nome').value;
        const horarioExpediente = document.getElementById('horarioexpediente').value;
        const localDeTrabalho = document.getElementById('localdetrabalho').value;

        // Envia as datas selecionadas via AJAX
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Exibe o formulário PHP na mesma página
                    const formularioPhp = document.getElementById('formulario-php');
                    formularioPhp.innerHTML = xhr.responseText;
                } else {
                    console.error('Erro ao processar requisição.');
                }
            }
        };
        xhr.open('POST', 'sec/cria_coletadados.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`dates=${selectedDatesStr}&nome=${nome}&horarioexpediente=${horarioExpediente}&localdetrabalho=${localDeTrabalho}`);
    } else {
        selectedDatesElement.textContent = 'Nenhuma data selecionada.';
    }
}

// Gera o calendário inicial
generateCalendar(currentMonth, currentYear);

</script>


            <!-- FINALIZA CONTEÚDO -->  

<?php
include "tudo_baixo.php";
?>            