<?php

namespace Extensions\HttpRequests;

use Extensions\HttpRequests\Response;

//оберетка для  REST запросов
class Helper
{

    /**
     * Выполняет роль клиента, аналог отправки обычной формы из браузера
     * @param string $url
     * @param array $arData
     * @param array $arHeaders
     * @return Response
     */
    static function sendPost(string $url, array $arData = [], array $arHeaders = []): Response
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($arData),
            CURLOPT_HTTPHEADER => $arHeaders,
        ));

        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return new Response($code, $response);
    }
}