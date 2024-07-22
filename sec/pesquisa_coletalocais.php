<?php
include "sec_verifica.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedValues = json_decode($_POST['selectedValues'], true);

    if (!empty($selectedValues)) {
        foreach ($selectedValues as $value) {
            // Sanitização do valor do ID para evitar SQL Injection
            $id_contrato = (int)$value;

            $query_locais = "SELECT * FROM local WHERE id_contrato = $id_contrato";
            $resultado_locais = $conn->query($query_locais);

            if ($resultado_locais->num_rows > 0) {
                while($dados_locais = $resultado_locais->fetch_assoc()) {
                    $id_locais = $dados_locais['id'];
                    $nome_locais = $dados_locais['nome'];

                    echo '
                    <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                            <input
                                type="checkbox"
                                name="locais[]"
                                value="' . htmlspecialchars($id_locais) . '"
                                class="selectgroup-input locais"
                                checked
                            />
                            <span class="selectgroup-button">' . htmlspecialchars($nome_locais) . '</span>
                        </label>
                    </div>
                    ';
                }
            } else {
                $query_contrato = "SELECT * FROM contrato WHERE id = $id_contrato";
                        $resultado_contrato = $conn->query($query_contrato);
                            $dados_contrato = $resultado_contrato->fetch_assoc();
                                $nome_contrato = $dados_contrato['nome'];

                echo "<p style='color:red; font-size: 10px'>Nenhum local encontrado para o contrato $nome_contrato.</p>";
            }
        }
    } else {
        echo "<p>Nenhum checkbox foi selecionado.</p>";
    }
} else {
    echo "<p>Nenhum dado foi recebido.</p>";
}
?>
