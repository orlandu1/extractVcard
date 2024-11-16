<?php


function normalizarTelefone($numero)
{

    /**
     * REMOVE O +55 DE TODOS OS NÚMEROS 
     */

    $numero = preg_replace('/^\+?55/', '', preg_replace('/\D/', '', $numero));

    /**
     * PEGA OS 8 DÍGITOS DE TRÁS PRA FRENTE E ONDE O NUMERO
     * COMEÇAR COM 8 OU 9, INDENTIFICOU NUMERO DE CELULAR
     * CASO CONTRÁRIO É NUMERO FIXO. E CASO NUMERO DE CELULAR ADICIONA
     * O 619 E CASO NUMERO FIXO APENAS 61
     */
    $numero = substr($numero, -8);

    if (strlen($numero) == 8) {
        if (in_array(substr($numero, 0, 1), ['8', '9'])) {
            return '619' . $numero;
        } else {
            return '61' . $numero;
        }
    }
    /**
     * DESCARTA QUALQUER NUMERO QUE ESTIVER FORA DESSAS REGRAS 
     */

    return "Número inválido";
}


/**
 * FUNÇÃO PARA TRATAR A EXTRAÇÃO DE DADOS DO VCARD
 * COM BASE EM REGRAS ESTABELECIDAS
 */
function extrairDados($arquivo)
{
    /**
     * CAPTURA O ARQUIVO COM O CONTEUDO PASSSADO ATRAVES DO ARGUMENTO DA FUNÇÃO
     */
    $conteudo = file_get_contents($arquivo);

    /**
     * FORÇA AS QUEBRAS DE LINHA POIS O ARQUIVO TEM QUEBRAS DE LINHA CORROMPIDAS
     */
    $conteudo = str_replace(["\r\n", "\r"], "\n", $conteudo);

    /**
     * CAPTURA A PRIMEIRA OCORRENCIA DO VCARD ONDE O FINAL É END:VCARD
     */
    $vcards = explode("END:VCARD", $conteudo);

    /**
     * INICIA OS ARRAYS VAZIOS
     */
    $contatos = [];
    $naoTratados = [];

    /**
     * FOREACH PARA TRATAMENTO INDIVIDUAL DE CADA CASO
     */
    foreach ($vcards as $vcard) {

        /**
         * SE A VARIAVEL VCARD VIER VAZIA, ISTO NÃO SERÁ PROCESSADO ELE SIMPLESMENTE IGNORA E VAI PRO PRÓXIMO
         */
        if (empty(trim($vcard))) continue;

        /**
         * REMOVE ENCODE QUE PREENCHE DE CAMPOS VAZIOS COM EXPRESSAO REGULAR
         * E FAZ TRATATIVA DE CAPTURAR A PRIMEIRA OCORRENCIA DO NOME APOS FN
         * ASSIM CAPTURADO O NOME
         */
        if (preg_match('/N;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE:(.*?)\n/', $vcard, $matches)) {
            $nomeCompleto = quoted_printable_decode(trim($matches[1]));
        } elseif (preg_match('/FN:(.*?)\n/', $vcard, $matches)) {
            $nomeCompleto = trim($matches[1]);
        } else {
            $nomeCompleto = "Sem Nome";
        }

        /**
         * FAZ A EXPRESSAO REGULAR PARA CAPTURAR O NUMERO DE TELEFONE
         *  E JA CHAMA FUNÇÃO PARA TRATATIVA ANTERIOR E COLCOA DENTRO DO ARRAY
         */
        if (preg_match('/TEL.*?:(.*?)\n/', $vcard, $matches)) {
            $numeroTelefone = normalizarTelefone(trim($matches[1]));
        } else {
            $numeroTelefone = "Número inválido";
        }

        /**
         * SE NUMERO DE TELEFONE FOR INVALIDO IGNORA TODA A LINHA E NÃO GRAVA
         * DESCARTE IMEDIATO DE CASO E GRAVA DADOS VALIDOS
         */
        if ($numeroTelefone != "Número inválido") {
            $contatos[] = $nomeCompleto . ";" . $numeroTelefone;
        } else {
            $naoTratados[] = $nomeCompleto . ";Número Inválido";
        }
    }

    /**
     * RETORNA OS DOIS ARRAYS DE TRATADOS E NÃO TRATADOS PARA ANALISE POSTERIOR
     */
    return [$contatos, $naoTratados];
}

/**
 * DEFINE O NOME DOS ARQUIVS A SEREM TRATADOS
 */
$arquivoVCard = 'numeros.txt';
$arquivoSaida = 'numerosSeparados.txt';
$arquivoNaoTratados = 'naoTratados.txt';

/**
 * DESESTRUTRA O MODULO DE VARIAVEIS RETORNADAS PELA FUNÇÃO
 */

list($contatos, $naoTratados) = extrairDados($arquivoVCard);

/**
 * PROMOVE A QUEBRA DE LINHA E EMPURRA OS DADOS PRA DENTRO DO ARQUIVO
 */
$saida = implode("\n", $contatos);
file_put_contents($arquivoSaida, $saida);

/**
 * PROMOVE A QUEBRA DE LINHA E EMPURRA OS DADOS PRA DENTRO DO ARQUIVO
 */
$saidaNaoTratados = implode("\n", $naoTratados);
file_put_contents($arquivoNaoTratados, $saidaNaoTratados);


/**
 * MOSTRA DADOS NO CONSOLE
 */
echo "Arquivo gerado com sucesso: $arquivoSaida\n";
echo "Arquivo com números não tratados: $arquivoNaoTratados\n";
