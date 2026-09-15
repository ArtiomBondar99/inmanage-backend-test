<?php

class JsonPlaceholderService
{
    private string $baseUrl = "https://jsonplaceholder.typicode.com";

    private function get(string $endpoint): array
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->baseUrl . $endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);

            throw new Exception("cURL Error: " . $error);
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpCode !== 200) {
            throw new Exception("HTTP Error: " . $httpCode);
        }

        $data = json_decode($response, true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(
                "JSON decode error: " . json_last_error_msg()
            );
        }

        return $data;
    }

    public function getUsers(): array
    {
        return $this->get("/users");
    }

    public function getPosts(): array
    {
        return $this->get("/posts");
    }
}