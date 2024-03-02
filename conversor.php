<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Conversor de Moedas</title>
</head>

<body>
    <main>
        <h1>Conversão realizada!</h1>
        <?php
            
                 // Definindo as variáveis
                 $inicio = date('m-d-Y', strtotime('-7 days'));
                 $fim = date('m-d-Y');

                 // URL da API
                 $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $inicio . '\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

                 // Obtendo os dados da API
                 $dados = json_decode(file_get_contents($url), true);
                 
                 // Extraindo a cotação de compra
                 $cotacao = $dados['value'][0]['cotacaoCompra'];

                // Formatando a cotação
                 $cotacao = number_format($cotacao, 2, '.', '.');

                 // Exibindo a cotação
                 echo "Cotação atualizada R$ {$cotacao}";
                
                 // Recebendo o valor
                 $real = $_REQUEST["din"] ?? 0;

                 // Validando o valor
                 if (is_numeric($real))
                
                 // Calculando o valor em dólar
                 $dolar = $real / $cotacao;

                 // Formatando os valores
                 $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

                 echo "<p>Seus <strong>" . numfmt_format_currency($padrao, $real, "BRL") . "</strong>
                 equivalem a <strong>" . numfmt_format_currency($padrao, $dolar, "USD") . "</strong></p>";
                                 
                
            ?>
        <!-- //Botão -->
        <button onclick="javascript:history.go(-1)">Voltar</button>

    </main>

</body>

</html>