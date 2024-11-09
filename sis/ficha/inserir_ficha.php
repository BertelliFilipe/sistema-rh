<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("../../base/config.php");

$usuario_nivel = $_SESSION['nivel'] ?? null;
$id_cand = $_GET['id_cand'] ?? null;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificando se foi enviado um arquivo para os campos de documentos
    $campos = [
        'cpfimg' => $_FILES['cpfimg'] ?? null,
        'rgimg' => $_FILES['rgimg'] ?? null,
        'cnhimg' => $_FILES['cnhimg'] ?? null,
        'ctpsimg' => $_FILES['ctpsimg'] ?? null,
        'residimg' => $_FILES['residimg'] ?? null,
        'escolimg' => $_FILES['escolimg'] ?? null,
        'reservimg' => $_FILES['reservimg'] ?? null,
        'nascimg' => $_FILES['nascimg'] ?? null,
    ];

    // Caminho para os uploads
    $upload_dir = 'uploads/';
    $ficha_data = [];

    foreach ($campos as $campo => $file) {
        if ($file && $file['error'] == 0) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $novo_nome = uniqid($campo . '_') . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $upload_dir . $novo_nome)) {
                $ficha_data[$campo] = $novo_nome;
            } else {
                $ficha_data[$campo] = null; // Caso o upload falhe
            }
        } else {
            $ficha_data[$campo] = null;
        }
    }

    // Inserção ou atualização da ficha
    $sql_ficha = "SELECT * FROM ficha WHERE id_cand = ?";
    $stmt_ficha = $con->prepare($sql_ficha);
    $stmt_ficha->bind_param('i', $id_cand);
    $stmt_ficha->execute();
    $result_ficha = $stmt_ficha->get_result();

    if ($result_ficha->num_rows > 0) {
        // Atualiza se a ficha já existe
        $set_fields = [];
        foreach ($ficha_data as $campo => $valor) {
            if ($valor !== null) {
                $set_fields[] = "$campo = ?";
            }
        }

        if (count($set_fields) > 0) {
            $sql_update = "UPDATE ficha SET " . implode(', ', $set_fields) . " WHERE id_cand = ?";
            $stmt_update = $con->prepare($sql_update);

            $params = [];
            foreach ($ficha_data as $campo => $valor) {
                if ($valor !== null) {
                    $params[] = $valor;
                }
            }

            $params[] = $id_cand; // Adiciona o id_cand no final
            $types = str_repeat('s', count($params)); // Tipo dos parâmetros (s = string)

            $stmt_update->bind_param($types, ...$params);
            $stmt_update->execute();
        }
    } else {
        // Inserção caso a ficha não exista
        $sql_insert = "INSERT INTO ficha (id_cand, " . implode(', ', array_keys($ficha_data)) . ") VALUES (?, " . str_repeat('?,', count($ficha_data) - 1) . "?)";
        $stmt_insert = $con->prepare($sql_insert);

        $params = [$id_cand];
        foreach ($ficha_data as $valor) {
            $params[] = $valor;
        }

        $types = 'i' . str_repeat('s', count($ficha_data)); // Primeiro é um inteiro para id_cand, depois strings para os campos
        $stmt_insert->bind_param($types, ...$params);
        $stmt_insert->execute();
    }

    // Lidar com dependentes
    if (isset($_POST['dependentes']) && is_array($_POST['dependentes'])) {
        $sql_dependentes = "INSERT INTO dependentes (id_cand, nome, idade, nascdepimg, vacdepimg) VALUES (?, ?, ?, ?, ?)";
        $stmt_dependentes = $con->prepare($sql_dependentes);

        foreach ($_POST['dependentes'] as $dependente) {
            // Verifica os arquivos de dependente
            $dependente_data = [
                'nascdepimg' => $_FILES['dependentes'][$dependente['index']]['nascdepimg'],
                'vacdepimg' => $_FILES['dependentes'][$dependente['index']]['vacdepimg']
            ];

            $dependente_files = [];
            foreach ($dependente_data as $campo => $file) {
                if ($file && $file['error'] == 0) {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $novo_nome = uniqid($campo . '_') . '.' . $ext;
                    if (move_uploaded_file($file['tmp_name'], $upload_dir . $novo_nome)) {
                        $dependente_files[$campo] = $novo_nome;
                    } else {
                        $dependente_files[$campo] = null; // Caso o upload falhe
                    }
                } else {
                    $dependente_files[$campo] = null;
                }
            }

            $stmt_dependentes->bind_param('ssiss', $id_cand, $dependente['nome'], $dependente['idade'], $dependente_files['nascdepimg'], $dependente_files['vacdepimg']);
            $stmt_dependentes->execute();
        }
    }

    if($resultado){
		header('Location: \projeto/dash.php');
		mysqli_close($con);
	}else{
		header('Location: \projeto/dash.php');
		mysqli_close($con);
	}
}
?>
