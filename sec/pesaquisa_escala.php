<?php

include "config.php";

// Consulta para buscar as datas
$sql = "SELECT dia, mes, ano FROM escala";
$result = $conn->query($sql);

$datas = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $datas[] = $row['dia'] . '-' . $row['mes'] . '-' . $row['ano'];
    }
}

$conn->close();
?>

<script>
    const datasComEventos = <?php echo json_encode($datas); ?>;
</script>