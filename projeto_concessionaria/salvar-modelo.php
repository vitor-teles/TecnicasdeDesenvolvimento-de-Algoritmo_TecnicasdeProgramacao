<?php
// --- CONFIGURAÇÃO DE DIAGNÓSTICO (Caso dê erro, ele vai te mostrar o motivo exato) ---
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// ------------------------------------------------------------------------------------

switch ($_REQUEST['acao']) {
    case 'cadastrar':
        // Recebe do formulário (mantendo os nomes originais do seu HTML)
        $nome = $_POST['nome_modelo'];
        $cor  = $_POST['cor_modelo'];
        $ano  = $_POST['ano_modelo'];
        $tipo = $_POST['tipo_modelo'];
        // Tenta pegar com o nome antigo OU o novo (garante que funciona)
        $marca_id = isset($_POST['marca_id_marca']) ? $_POST['marca_id_marca'] : $_POST['marca_idmarca'];

        // Prepara o SQL com os nomes CORRETOS das colunas do banco
        // Assumindo: idmodelo, nome_modelo, cor_modelo, ano_modelo, tipo_modelo, marca_idmarca
        $sql = "INSERT INTO modelo (
                    nome_modelo, 
                    cor_modelo, 
                    ano_modelo, 
                    tipo_modelo, 
                    marca_idmarca
                ) VALUES (
                    '{$nome}',
                    '{$cor}',
                    '{$ano}',
                    '{$tipo}',
                    '{$marca_id}'
                )";

        try {
            $conn->query($sql);
            print "<script>alert('Cadastrou com sucesso!');</script>";
            print "<script>location.href='?page=listar-modelo';</script>";
        } catch (mysqli_sql_exception $e) {
            print "<div class='alert alert-danger'>Erro ao cadastrar: " . $e->getMessage() . "</div>";
            // Mostra o comando SQL na tela para você conferir se os dados chegaram
            print "<p>SQL tentado: $sql</p>";
        }
        break;

    case 'editar':
        $nome = $_POST['nome_modelo'];
        $cor  = $_POST['cor_modelo'];
        $ano  = $_POST['ano_modelo'];
        $tipo = $_POST['tipo_modelo'];
        $marca_id = isset($_POST['marca_id_marca']) ? $_POST['marca_id_marca'] : $_POST['marca_idmarca'];

        // Pega o ID que veio da URL (id_modelo)
        $id_modelo = $_REQUEST['id_modelo'];

        $sql = "UPDATE modelo SET 
                    nome_modelo='{$nome}', 
                    cor_modelo='{$cor}', 
                    ano_modelo='{$ano}', 
                    tipo_modelo='{$tipo}', 
                    marca_idmarca='{$marca_id}' 
                WHERE idmodelo={$id_modelo}"; // Atenção: idmodelo (banco) vs id_modelo (url)

        try {
            $conn->query($sql);
            print "<script>alert('Editou com sucesso!');</script>";
            print "<script>location.href='?page=listar-modelo';</script>";
        } catch (mysqli_sql_exception $e) {
            print "<div class='alert alert-danger'>Erro ao editar: " . $e->getMessage() . "</div>";
        }
        break;

    case 'excluir':
        $id_modelo = $_REQUEST['id_modelo'];

        $sql = "DELETE FROM modelo WHERE idmodelo={$id_modelo}";

        try {
            $conn->query($sql);
            print "<script>alert('Excluiu com sucesso!');</script>";
            print "<script>location.href='?page=listar-modelo';</script>";
        } catch (mysqli_sql_exception $e) {
            print "<div class='alert alert-danger'>Erro ao excluir: " . $e->getMessage() . "</div>";
        }
        break;
}
