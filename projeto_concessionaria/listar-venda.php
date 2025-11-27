<?php
// CORREÇÃO 1: Nomes das colunas ajustados conforme sua imagem (sem o _ depois de 'id')
// Nota: Assumi que nas tabelas 'cliente', 'funcionario' e 'modelo' as chaves também são 'idcliente', etc.
// Se der erro, verifique se nas outras tabelas tem o _ ou não.
$sql = "SELECT venda.*, cliente.nome_cliente, funcionario.nome_funcionario, modelo.nome_modelo 
        FROM venda 
        INNER JOIN cliente ON venda.cliente_idcliente = cliente.idcliente 
        INNER JOIN funcionario ON venda.funcionario_idfuncionario = funcionario.idfuncionario 
        INNER JOIN modelo ON venda.modelo_idmodelo = modelo.idmodelo";

$res = $conn->query($sql);

// Verifica se houve erro no SQL e mostra na tela (ajuda muito a debugar)
if (!$res) {
    die("Erro na consulta SQL: " . $conn->error);
}

$qtd = $res->num_rows;

if ($qtd > 0) {
    print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";
    print "<table class='table table-bordered table-striped table-hover'>";
    print "<thead>";
    print "<tr>";
    print "<th>#</th>";
    print "<th>Cliente</th>";
    print "<th>Funcionario</th>";
    print "<th>Modelo</th>";
    print "<th>Valor</th>";
    print "<th>Data</th>";
    print "<th>Ação</th>";
    print "</tr>";
    print "</thead>";
    print "<tbody>";
    while ($row = $res->fetch_object()) {
        print "<tr>";
        // CORREÇÃO 2: Alterado de id_venda para idvenda (conforme sua imagem)
        print "<td>" . $row->idvenda . "</td>";
        print "<td>" . $row->nome_cliente . "</td>";
        print "<td>" . $row->nome_funcionario . "</td>";
        print "<td>" . $row->nome_modelo . "</td>";
        print "<td>" . $row->valor_venda . "</td>";

        $dt_formatada = date('d/m/Y', strtotime($row->data_venda));
        print "<td>" . $dt_formatada . "</td>";

        // CORREÇÃO 3: Ajustado também nos botões de ação
        print "<td>
                <button class='btn btn-success' onclick=\"location.href='?page=editar-venda&id_venda={$row->idvenda}';\">Editar</button>
                <button class='btn btn-danger' onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=salvar-venda&acao=excluir&id_venda={$row->idvenda}';}else{false;}\">excluir</button>
               </td>";
        print "</tr>";
    }
    print "</tbody>";
    print "</table>";
} else {
    print "<div class='alert alert-info'>Não encontrou resultado.</div>";
}
print "<a href='?page=index.php' class='btn btn-secondary'> Voltar </a>";
