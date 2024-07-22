<?php
include "tudo_cima.php"; 


// Buscar datas do banco de dados
$query_pesquisaescala = "SELECT dia, mes, ano FROM escala WHERE id_usuario = '$idlogado'";
$resultado_pesquisaescala = $conn->query($query_pesquisaescala);

$datesWithData = [];
if ($resultado_pesquisaescala->num_rows > 0) {
    while ($row = $resultado_pesquisaescala->fetch_assoc()) {
        $datesWithData[] = sprintf('%02d-%02d-%04d', $row['dia'], $row['mes'], $row['ano']);
    }
}

$conn->close();
?>

<script>
// Passa as datas do PHP para o JavaScript
const datesWithData = <?php echo json_encode($datesWithData); ?>;
</script>

            <!-- INICIA CONTEÚDO -->  

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

                // Verifica se a data tem dados no banco de dados
                if (datesWithData.includes(formattedDate)) {
                    cell.style.backgroundColor = 'blue'; // Marca a célula em azul
                    cell.style.color = 'white'; // Ajusta a cor do texto para melhor visibilidade
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

// Gera o calendário inicial
generateCalendar(currentMonth, currentYear);

</script>


            <!-- FINALIZA CONTEÚDO -->  

<?php
include "tudo_baixo.php";
?>
