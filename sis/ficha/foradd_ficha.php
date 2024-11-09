<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("base/config.php");
$usuario_nivel = $_SESSION['nivel'] ?? null; 

// Pegue o id_cand (candidato) do parâmetro GET, ou defina como null caso não esteja presente
$id_cand = $_GET['id_cand'] ?? null;

if ($usuario_nivel == '1') {
    $page_redirect = '/projeto/dash.php?page=lista2_ficha'; // Usuários de nível 1 vão para lista2_ficha
} elseif ($usuario_nivel == '2' || $usuario_nivel == '3') {
    $page_redirect = '/projeto/dash.php?page=lista_ficha'; // Usuários de nível 2 e 3 vão para lista_ficha
} else {
    $page_redirect = '/projeto/dash.php'; // Redirecionamento padrão se o nível não for 1, 2 ou 3
}
// Consultar dados do candidato
$sql_candidato = "SELECT id_cand, nome_cand FROM candidato WHERE id_cand = ?";
$stmt_candidato = $con->prepare($sql_candidato);
$stmt_candidato->bind_param('i', $id_cand);
$stmt_candidato->execute();
$result_candidato = $stmt_candidato->get_result();
$candidato = $result_candidato->fetch_assoc();

// Consultar dependentes
$sql_dependentes = "SELECT * FROM dependentes WHERE id_cand = ?";
$stmt_dependentes = $con->prepare($sql_dependentes);
$stmt_dependentes->bind_param('i', $id_cand);
$stmt_dependentes->execute();
$result_dependentes = $stmt_dependentes->get_result();
$dependentes = $result_dependentes->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diretorio = "C:/xampp/htdocs/projeto/uploads/";
    $campos = ['cpfimg', 'rgimg', 'cnhimg', 'ctpsimg', 'residimg', 'escolimg', 'reservimg', 'nascimg'];
    $uploads = [];

    foreach ($campos as $campo) {
        if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === UPLOAD_ERR_OK) {
            $novo_nome = $campo . '_' . $id_cand . '.' . strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION));
            move_uploaded_file($_FILES[$campo]['tmp_name'], $diretorio . $novo_nome);
            $uploads[$campo] = $novo_nome;
        } else {
            $uploads[$campo] = null;
        }
    }

    // Inserir ou atualizar dados na tabela 'ficha'
    $sql_ficha = "INSERT INTO ficha (id_cand, cpfimg, rgimg, cnhimg, ctpsimg, residimg, escolimg, reservimg, nascimg)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE 
                  cpfimg=VALUES(cpfimg), rgimg=VALUES(rgimg), cnhimg=VALUES(cnhimg),
                  ctpsimg=VALUES(ctpsimg), residimg=VALUES(residimg), escolimg=VALUES(escolimg),
                  reservimg=VALUES(reservimg), nascimg=VALUES(nascimg)";
    
    $stmt_ficha = $con->prepare($sql_ficha);
    $stmt_ficha->bind_param('issssssss', $id_cand, $uploads['cpfimg'], $uploads['rgimg'], $uploads['cnhimg'], 
                            $uploads['ctpsimg'], $uploads['residimg'], $uploads['escolimg'], 
                            $uploads['reservimg'], $uploads['nascimg']);
    $stmt_ficha->execute();

    // Processar dados dos dependentes
    if (isset($_POST['dependentes']) && is_array($_POST['dependentes'])) {
        foreach ($_POST['dependentes'] as $index => $dependente_data) {
            $nome = $dependente_data['nome'];
            $idade = $dependente_data['idade'];
            $nascdepimg = null;
            $vacdepimg = null;

            // Upload dos documentos dos dependentes
            if (isset($_FILES['dependentes']['name'][$index]['nascdepimg']) && $_FILES['dependentes']['error'][$index]['nascdepimg'] === UPLOAD_ERR_OK) {
                $nascdepimg = 'nascdep_' . $id_cand . '_' . $index . '.' . strtolower(pathinfo($_FILES['dependentes']['name'][$index]['nascdepimg'], PATHINFO_EXTENSION));
                move_uploaded_file($_FILES['dependentes']['tmp_name'][$index]['nascdepimg'], $diretorio . $nascdepimg);
            }

            if (isset($_FILES['dependentes']['name'][$index]['vacdepimg']) && $_FILES['dependentes']['error'][$index]['vacdepimg'] === UPLOAD_ERR_OK) {
                $vacdepimg = 'vacdep_' . $id_cand . '_' . $index . '.' . strtolower(pathinfo($_FILES['dependentes']['name'][$index]['vacdepimg'], PATHINFO_EXTENSION));
                move_uploaded_file($_FILES['dependentes']['tmp_name'][$index]['vacdepimg'], $diretorio . $vacdepimg);
            }

            // Verificar se o dependente já existe na tabela antes de inserir
            $sql_verifica_dependente = "SELECT id FROM dependentes WHERE id_cand = ? AND nome = ?";
            $stmt_verifica_dependente = $con->prepare($sql_verifica_dependente);
            $stmt_verifica_dependente->bind_param('is', $id_cand, $nome);
            $stmt_verifica_dependente->execute();
            $result_verifica_dependente = $stmt_verifica_dependente->get_result();

            if ($result_verifica_dependente->num_rows > 0) {
                // Atualizar dependente existente
                $sql_update_dependente = "UPDATE dependentes SET idade = ?, nascdepimg = ?, vacdepimg = ? WHERE id_cand = ? AND nome = ?";
                $stmt_update_dependente = $con->prepare($sql_update_dependente);
                $stmt_update_dependente->bind_param('issis', $idade, $nascdepimg, $vacdepimg, $id_cand, $nome);
                $stmt_update_dependente->execute();
            } else {
                // Inserir novo dependente
                $sql_dependente = "INSERT INTO dependentes (id_cand, nome, idade, nascdepimg, vacdepimg)
                                   VALUES (?, ?, ?, ?, ?)";
                
                $stmt_dependente = $con->prepare($sql_dependente);
                $stmt_dependente->bind_param('isiss', $id_cand, $nome, $idade, $nascdepimg, $vacdepimg);
                $stmt_dependente->execute();
            }
        }
    }
}

// Consultar dados da ficha
$sql_ficha = "SELECT * FROM ficha WHERE id_cand = ?";
$stmt_ficha = $con->prepare($sql_ficha);
$stmt_ficha->bind_param('i', $id_cand);
$stmt_ficha->execute();
$result_ficha = $stmt_ficha->get_result();
$ficha = $result_ficha->fetch_assoc();
?>


<div id="main" class="container-fluid">
    <form enctype="multipart/form-data" action="?page=inserir_ficha&id_cand=<?php echo $id_cand; ?>" method="POST">
      
        <label><b><h3>Matrícula:</b> <?php echo htmlspecialchars($candidato['id_cand']); ?></label><br></h3>
        <label><b><h3>Nome do Candidato:</b> <?php echo htmlspecialchars($candidato['nome_cand']); ?></label><br></h3>

        <?php
        // Lista de campos e rótulos para os documentos
        $campos = [
            'cpfimg' => 'CPF',
            'rgimg' => 'RG',
            'cnhimg' => 'CNH',
            'ctpsimg' => 'CTPS',
            'residimg' => 'Comprovante de Residência',
            'escolimg' => 'Escolaridade',
            'reservimg' => 'Reservista',
            'nascimg' => 'Certidão de Nascimento/Casamento',
            
        ];

        // Exibir os campos de upload e links para os arquivos atuais, se existirem
        foreach ($campos as $campo => $label) {
            echo "<label for='$campo'><b>$label</b></label>";
            echo "<input type='file' name='$campo' class='form-control' />";
            
            if (!empty($ficha[$campo])) {
                $arquivo = "/projeto/uploads/" . htmlspecialchars($ficha[$campo]);
                echo "<p>Arquivo atual: <a href='$arquivo' target='_blank'>" . htmlspecialchars($ficha[$campo]) . "</a></p>";
            }
            echo "<br>";
        }
        ?>

        <hr><h4>Dependentes</h4>

        <div id="dependentes-section">
            <?php foreach ($dependentes as $index => $dependente): ?>
                <div class="dependente-item">
                    <label>Nome do Dependente:</label>
                    <input type="text" name="dependentes[<?php echo $index; ?>][nome]" value="<?php echo htmlspecialchars($dependente['nome']); ?>" class="form-control" />

                    <label>Idade do Dependente:</label>
                    <input type="number" name="dependentes[<?php echo $index; ?>][idade]" value="<?php echo htmlspecialchars($dependente['idade']); ?>" class="form-control" />

                    <label>Certidão de Nascimento:</label>
                    <input type="file" name="dependentes[<?php echo $index; ?>][nascdepimg]" class="form-control" />
                    <?php if (!empty($dependente['nascdepimg'])): ?>
                        <p>Arquivo atual: <a href="/projeto/uploads/<?php echo htmlspecialchars($dependente['nascdepimg']); ?>" target="_blank"><?php echo htmlspecialchars($dependente['nascdepimg']); ?></a></p>
                    <?php endif; ?>

                    <label>Carteira de Vacinação:</label>
                    <input type="file" name="dependentes[<?php echo $index; ?>][vacdepimg]" class="form-control" />
                    <?php if (!empty($dependente['vacdepimg'])): ?>
                        <p>Arquivo atual: <a href="/projeto/uploads/<?php echo htmlspecialchars($dependente['vacdepimg']); ?>" target="_blank"><?php echo htmlspecialchars($dependente['vacdepimg']); ?></a></p>
                    <?php endif; ?>
                    
                    <hr>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="button" onclick="adicionarDependente()" class="btn btn-secondary">Adicionar Dependente</button>

        <hr />
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="<?php echo $page_redirect; ?>" class="btn btn-danger">Cancelar</a>

       
    </form>
</div>

<script>
// Função para adicionar novos campos para dependentes dinamicamente
let dependenteIndex = <?php echo count($dependentes); ?>;

function adicionarDependente() {
    const section = document.getElementById('dependentes-section');
    const dependenteHTML = 
        <div class="dependente-item">
            <label>Nome do Dependente:</label>
            <input type="text" name="dependentes[${dependenteIndex}][nome]" class="form-control" />

            <label>Idade do Dependente:</label>
            <input type="number" name="dependentes[${dependenteIndex}][idade]" class="form-control" />

            <label>Certidão de Nascimento:</label>
            <input type="file" name="dependentes[${dependenteIndex}][nascdepimg]" class="form-control" />

            <label>Carteira de Vacinação:</label>
            <input type="file" name="dependentes[${dependenteIndex}][vacdepimg]" class="form-control" />

            <hr>
        </div>
    ;
    section.insertAdjacentHTML('beforeend', dependenteHTML);
    dependenteIndex++;
}
</script>