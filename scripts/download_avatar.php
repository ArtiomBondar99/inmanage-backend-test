<?php

$imageUrl = "https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg";

$saveDirectory = __DIR__ . "/../public/images";
$savePath = $saveDirectory . "/default-avatar.jpg";

if (!is_dir($saveDirectory)) {
    mkdir($saveDirectory, 0777, true);
}

$curl = curl_init($imageUrl);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$imageData = curl_exec($curl);

if ($imageData === false) {
    $error = curl_error($curl);
    curl_close($curl);

    throw new Exception("cURL Error: " . $error);
}

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

if ($httpCode !== 200) {
    throw new Exception("Failed to download image. HTTP code: " . $httpCode);
}

if (file_put_contents($savePath, $imageData) === false) {
    throw new Exception("Failed to save image");
}

echo "Avatar downloaded successfully";