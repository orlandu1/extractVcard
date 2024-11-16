<?php

function extrairDados($arquivo) {

    $conteudo = file_get_contents($arquivo);
    $vcards = explode("END:VCARD", $conteudo);
    
    $contatos = [];

    foreach ($vcards as $vcard) {

        if (empty($vcard)) continue;

        if (preg_match('/N;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE:(.*?)\r?\n/', $vcard, $matches)) {

            $nomeCompleto = "Nome não adicionado";
        } else {

            if (preg_match('/FN:(.*?)\r?\n/', $vcard, $matches)) {
                $nomeCompleto = trim($matches[1]);
            } else {
                $nomeCompleto = "Nome não encontrado";
            }
        }

        if ($nomeCompleto == "Nome não adicionado" || $nomeCompleto == "Nome não encontrado") {
            continue;
        }

        if (preg_match('/TEL;CELL:(.*?)\r?\n/', $vcard, $matches)) {
            $numeroTelefone = trim($matches[1]);

            if (substr($numeroTelefone, 0, 1) == '9' && substr($numeroTelefone, 0, 2) != '61') {
                $numeroTelefone = '61' . $numeroTelefone;
            }
        } else {
            $numeroTelefone = "Telefone não encontrado";
        }

        if ($numeroTelefone == "Telefone não adicionado" || $numeroTelefone == "Telefone não encontrado") {
            continue;
        }

        $contatos[] = $nomeCompleto . ";" . $numeroTelefone;
    }

    return $contatos;
}

$arquivoVCard = 'numeros.txt'; 
$arquivoSaida = 'numerosSeparados.txt'; 
$contatos = extrairDados($arquivoVCard);

$saida = implode("\n", $contatos);

if (file_put_contents($arquivoSaida, $saida)) {
    echo "Arquivo gerado com sucesso: $arquivoSaida";
} else {
    echo "Erro ao gerar o arquivo.";
}
?>
