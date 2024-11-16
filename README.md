vCard Parser
Este script PHP foi desenvolvido para processar e tratar arquivos vCard (.vcf), separando os dados de forma legível. Ele pode ser executado em um terminal UNIX usando o comando php contatos.php ou pode ser chamado diretamente de um servidor web. O script interpreta o conteúdo dos arquivos vCard e exibe as informações de uma maneira estruturada, facilitando a visualização e análise.

Funcionalidades
Leitura de arquivos vCard (.vcf): O script pode ler arquivos no formato vCard e extrair informações como nome, telefone, email e outros dados de contato.
Saída legível: Os dados extraídos são organizados e apresentados de maneira legível, facilitando a análise.
Execução em servidor web: O script pode ser chamado em um ambiente web, utilizando PHP, ou diretamente no terminal UNIX com o comando php contatos.php.
Compatibilidade: Funciona tanto em ambientes de terminal UNIX como em servidores web.
Requisitos
PHP 7.0 ou superior.
Acesso ao terminal (para execução em UNIX).
Servidor web (caso queira executar via HTTP, como Apache ou Nginx com PHP).
Como Usar

1. Execução no Terminal UNIX
Para rodar o script diretamente no terminal, basta ter o PHP instalado em seu sistema. No terminal, navegue até o diretório onde o script está localizado e execute:


php contatos.php
O script pedirá o caminho para o arquivo .vcf que deseja processar e exibirá os dados de forma legível.

2. Execução via Servidor Web
Se você preferir executar o script em um servidor web, siga as instruções abaixo:

Coloque o arquivo contatos.php no diretório do servidor web.
Acesse o script via navegador, fornecendo a URL completa, por exemplo:

http://seu-servidor/contatos.php

O script irá processar o arquivo vCard e exibir as informações diretamente na página web.

3. Exemplo de Uso
Caso você tenha um arquivo vCard chamado contato.vcf, você pode executar o script com o comando:

Nome: João Silva
Telefone: (11) 91234-5678
Email: joao.silva@email.com
Como Funciona
O script realiza a leitura do arquivo vCard, faz a extração dos campos relevantes (como FN, TEL, EMAIL, etc.), e organiza essas informações em um formato legível. Ele é capaz de identificar os dados de forma automática, mesmo que o arquivo contenha múltiplos contatos.

Estrutura do Projeto
bash
Copiar código
vcard-parser/
│
├── contatos.php           # Script principal com a lógica que processa o arquivo vCard
├── numeros.txt              # Arquivo BaseVcard
└── numerosSeparados.txt            # Arquivo de saída após processamento

Contribuições
Contribuições são bem-vindas! Se você tiver ideias para melhorias ou quiser corrigir algum bug, por favor, envie um pull request ou crie uma issue.

Licença
Este projeto é licenciado sob a Licença MIT. Consulte o arquivo LICENSE para mais informações.

