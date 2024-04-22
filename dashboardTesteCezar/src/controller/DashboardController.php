<?php

namespace Controller;

class DashboardController
{
    public function index()
    {
        $apiData = $this->fetchApiData();
        $apiChartData = $this->fetchApiDataForChart();

        $basePath = dirname(__DIR__);  // Obtém o diretório pai do diretório atual
        require $basePath . '/views/dashboard.php';
    }




    private function fetchApiData()
    {
        $apiUrl = 'http://dados.cultura.gov.br/dataset/72d4e4e0-6506-49ee-be75-cb4ce46844f2/resource/ab517acf-3001-44b5-8e70-ccb297c62bed/download/total-consumo-por-cnaeregiao-uf-ano-mes.json';

        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            throw new \Exception('Erro no consumo da Api: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        $json = json_decode($response, true);
        $contagemPorAnoERegiao = [];
        
        
        foreach ($json["benf_autorizadas_completo"] as $item) {
            if (isset($item["ANO DO CONSUMO"]) && isset($item["REGIÃO"])) {
                $ano = $item["ANO DO CONSUMO"];
                $regiao = $item["REGIÃO"];
    
                if (!isset($contagemPorAnoERegiao[$ano])) {
                    $contagemPorAnoERegiao[$ano] = [];
                }
    
                if (!isset($contagemPorAnoERegiao[$ano][$regiao])) {
                    $contagemPorAnoERegiao[$ano][$regiao] = 0;
                }
    
                $contagemPorAnoERegiao[$ano][$regiao]++;
            }
        }
        return $contagemPorAnoERegiao;
    }

    private function fetchApiDataForChart()
    {
        $contagemPorAnoERegiao = $this->fetchApiData();

        $labelsDoChart = [];
        $datasetsDoChart = [];

        foreach ($contagemPorAnoERegiao as $ano => $contagemDaRegiao) {
            $labelsDoChart[] = $ano;

            foreach ($contagemDaRegiao as $regiao => $count) {
                if (!isset($datasetsDoChart[$regiao])) {
                    $datasetsDoChart[$regiao] = [
                        'label' => $regiao,
                        'data' => [],
                        //caso necessário definir uma cor padrão
                        //'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'borderWidth' => 1
                    ];
                }

                $datasetsDoChart[$regiao]['data'][] = $count;
            }
        }
        return [
            'labels' => $labelsDoChart,
            'datasets' => array_values($datasetsDoChart)
        ];
    }

}
