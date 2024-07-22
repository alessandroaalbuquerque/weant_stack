<?php
    include "sec_verifica.php";

    $query_validacao_licenca = "SELECT * FROM licenca WHERE id_usuario = '$idlogado'";
        $resultado_validacao_licenca = $conn->query($query_validacao_licenca);
            if ($resultado_validacao_licenca->num_rows > 0){
                $dados_validacao_licenca = $resultado_validacao_licenca->fetch_assoc();        
                $id_validacao_licenca = $dados_validacao_licenca['id']; 
                $id_cliente_validacao_licenca = $dados_validacao_licenca['id_cliente']; 
    
                $query_coleta_usuarios = "SELECT * FROM licenca WHERE id_cliente = '$id_cliente_validacao_licenca'";
                    $resultado_coleta_usuarios = $conn->query($query_coleta_usuarios);
                        while ($dados_coleta_usuarios = $resultado_coleta_usuarios->fetch_assoc()) {
                                $id_coleta_usuarios = $dados_coleta_usuarios['id_usuario'];                       

                            $query_validacao_usuario = "SELECT * FROM usuario WHERE id = '$id_coleta_usuarios'";
                                $resultado_validacao_usuario = $conn->query($query_validacao_usuario);
                                    while ($dados_validacao_usuario = $resultado_validacao_usuario->fetch_assoc()) {
                                        $id_validacao_usuario = $dados_validacao_usuario['id'];
                                        $login_validacao_usuario = $dados_validacao_usuario['login'];
                                            echo '
                                            <div class="selectgroup selectgroup-pills">
                                                <label class="selectgroup-item">
                                                    <input
                                                        type="checkbox"
                                                        name="profissionais[]"
                                                        value="' . $id_validacao_usuario . '"
                                                        class="selectgroup-input contratos"
                                                        onchange="setCheckboxChanged()"
                                            ';

                                            $query_validacao_relacao_cliente_contrato = "SELECT * FROM relacao_cliente WHERE id_usuario = '$id_validacao_usuario' AND id_contrato = '$id'";
                                            $resultado_validacao_relacao_cliente_contrato = $conn->query($query_validacao_relacao_cliente_contrato);
                                            if ($resultado_validacao_relacao_cliente_contrato->num_rows > 0){
                                                echo '
                                                checked
                                                /><span class="selectgroup-button">' . $login_validacao_usuario . '</span>                                                                  
                                                </label> 
                                            </div>         
                                                ';                    
                                            }
                                            else {
                                                echo 
                                                '/><span class="selectgroup-button" style="color: #8800ff !important; font-weight: bold">' . $login_validacao_usuario . '</span>                                                                  
                                                </label> 
                                            </div>                  
                                                ';   
                                            }
                                    }
                         }
    
            } else {
                echo "Nenhum local cadastrado para esse(s) contrato(s)";
            }
        
?>  