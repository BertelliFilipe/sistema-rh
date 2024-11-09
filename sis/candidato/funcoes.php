function consultarViaCEP($cep) {
    // Remover caracteres não numéricos do CEP
    $cep = preg_replace('/[^0-9]/', '', $cep);
    
    // Verifica se o CEP tem o formato correto
    if (strlen($cep) !== 8) {
        return false; // Retorna falso se o CEP não é válido
    }

    // URL da API ViaCEP
    $url = "https://viacep.com.br/ws/$cep/json/";

    // Faz a requisição à API
    $response = file_get_contents($url);
    
    if ($response === false) {
        return false; // Retorna falso em caso de erro na requisição
    }

    // Decodifica o JSON retornado
    $endereco = json_decode($response, true);

    // Verifica se o retorno contém um erro
    if (isset($endereco['erro'])) {
        return false; // Retorna falso se o CEP não foi encontrado
    }

    return $endereco; // Retorna os dados do endereço
}