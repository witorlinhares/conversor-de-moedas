<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Moedas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="assets/favicon.png" type="image/x-icon">
</head>

<body>
    <div class="general-convert">
    <div class="container-convert">
    <main>
        <h1 class="title-convert">Conversão realizada!</h1>

        <?php

            //Definindo as variáveis
            $inicio = date('m-d-Y', strtotime('-7 days'));
            $fim = date('m-d-Y');
            
            //URL da API
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $inicio . '\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';
            
            //Obtendo os dados da API
            $dados = json_decode(file_get_contents($url), true);
            
            //Verificando se a API retornou dados
            if (!$dados) {
                echo "Erro ao acessar a API do Banco Central.";
                exit;
            }
            
            //Extraindo a cotação de compra
            $cotacao = $dados['value'][0]['cotacaoCompra'];
            
            //Formatando a cotação
            $cotacao = number_format($cotacao, 2, '.', '.');
            
            //Exibindo a cotação
            echo "Cotação atualizada R$ {$cotacao}";
            
            //Recebendo o valor
            $real = $_REQUEST["din"] ?? 0;
            
            //Validando o valor
            if (!is_numeric($real)) {
                echo "Valor inválido.";
                exit;
            }
            
            //Calculando o valor em dólar
            $dolar = $real / $cotacao;
            
            //Formatando os valores
            $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);
            
            echo "<p>Seus <strong>" . numfmt_format_currency($padrao, $real, "BRL") . "</strong>
            equivalem a <strong>" . numfmt_format_currency($padrao, $dolar, "USD") . "</strong></p>";
            
            ?>
        <!--Retornar para tela principal-->
        <div class="div-button-return">
        <button class="button-return" onclick="javascript:history.go(-1)">Realizar outra conversão</button>
        </div>
        </div>
        </div>

    </main>
</body>

</html>