<?php
    include "sec_verifica.php";

    $query_validacao_contrato = "SELECT * FROM relacao_cliente WHERE id_usuario = '$idlogado'";
    $resultado_validacao_contrato = $conn->query($query_validacao_contrato);
    if ($resultado_validacao_contrato->num_rows > 0){
        while($dados_validacao_contrato = $resultado_validacao_contrato->fetch_assoc()){
            $id_cliente_validacao_contrato = $dados_validacao_contrato['id_cliente'];                  

            $query_contrato = "SELECT * FROM contrato WHERE id = '$id_contrato_validacao_contrato'";
            $resultado_contrato = $conn->query($query_contrato);
            if ($resultado_contrato->num_rows > 0){
                while ($dados_contrato = $resultado_contrato->fetch_assoc()) {
                    $id_contrato = $dados_contrato['id'];
                    $nome_contrato = $dados_contrato['nome'];

                    echo '
                    <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                            <input
                                type="checkbox"
                                name="contratos[]"
                                value="' . $id_contrato . '"
                                class="selectgroup-input contratos"
                                onchange="setCheckboxChanged()"
                    ';

                    $query_validacao_relacao_cliente_contrato = "SELECT * FROM relacao_cliente WHERE id_usuario = '$id' AND id_contrato = '$id_contrato'";
                    $resultado_validacao_relacao_cliente_contrato = $conn->query($query_validacao_relacao_cliente_contrato);
                    if ($resultado_validacao_relacao_cliente_contrato->num_rows > 0){
                        echo '
                        checked
                        /><span class="selectgroup-button">' . $nome_contrato . '</span>                                                                  
                        </label> 
                    </div>         
                        ';                    
                    }
                    else {
                        echo 
                        '/><span class="selectgroup-button" style="color: #8800ff !important; font-weight: bold">' . $nome_contrato . '</span>                                                                  
                        </label> 
                    </div>                  
                        ';   
                    }
                }
            } else {
                echo "Nenhum local cadastrado para esse(s) contrato(s)";
            }
        }
    }
?>  