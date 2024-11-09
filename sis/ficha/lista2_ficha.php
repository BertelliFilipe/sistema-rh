<?php
// Inicie a sessão, caso ainda não esteja iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifique o ID do usuário logado
$id_usu_logado = isset($_SESSION['UsuarioID']) ? $_SESSION['UsuarioID'] : 0;

// Verifique o nível de acesso do usuário
$nivel = isset($_SESSION['UsuarioNivel']) ? $_SESSION['UsuarioNivel'] : null;

// Se o usuário estiver logado e for do nível "candidato"
if ($nivel === '1' && $id_usu_logado > 0) {
    // Conecte-se ao banco de dados
    $con = mysqli_connect('localhost', 'root', '', 'projeto');
    
    if (!$con) {
        die("Erro de conexão: " . mysqli_connect_error());
    }

    // Consulta para obter apenas a ficha do candidato logado
    $query = "SELECT * FROM candidato WHERE id = $id_usu_logado LIMIT 1";
    $data_all = mysqli_query($con, $query);

    if (mysqli_num_rows($data_all) == 0) {
        echo "Candidato não encontrado!";
        exit;
    }
} else {
    // Se não for candidato ou ID de usuário não estiver na sessão, redireciona ou exibe uma mensagem de erro
    echo "Acesso negado! Você não tem permissão para acessar esta página.";
    exit;
}
?>

<div id="main" class="container-fluid">
    <div id="top" class="row">
        <div class="col-md-10">
            <h2>Ficha Cadastral</h2>
        </div>
    </div>
    <hr/>
    <div><?php include "mensagens.php"; ?></div>

    <div id="list" class="row">
        <div class="table-responsive">
            <table class='table table-striped' cellspacing='0' cellpadding='0'>
                <thead>
                    <tr>
                        <td><strong>Matrícula</strong></td>
                        <td><strong>Nome do candidato</strong></td>
                        <td class='d-none d-md-table-cell'><strong>Cadastro</strong></td>
                        <td class='d-none d-md-table-cell'><strong>E-mail</strong></td>
                        <td class='d-none d-md-table-cell'><strong>Status</strong></td>
                        <td class='actions'><strong>Ações</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($info = mysqli_fetch_array($data_all)) : ?>
                        <tr>
                            <td><?php echo $info['id_cand']; ?></td>
                            <td><?php echo $info['nome_cand']; ?></td>
                            <td class='d-none d-md-table-cell'><?php echo date('d/m/Y', strtotime($info['data_cad_cand'])); ?></td>
                            <td class='d-none d-md-table-cell'><?php echo $info['email_cand']; ?></td>
                            <td class='d-none d-md-table-cell'><?php echo $info['status_cand']; ?></td>
                            <td>
                                <div class='btn-group btn-group-xs'>
                                    <a class='btn btn-secondary btn-xs' href='?page=foradd_ficha&id_cand=<?php echo $info['id_cand']; ?>'>Minha Ficha</a>
                                    <a class='btn btn-danger' href='javascript:void(0);' onclick='confirmDesistir(<?php echo $info['id_cand']; ?>)'>Desistir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDesistir(id_cand) {
        if (confirm("Tem certeza de que deseja desistir da vaga?")) {
            window.location.href = "sis/ficha/desistir_ficha.php?id_cand=" + id_cand;
        }
    }
</script>
