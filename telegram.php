<?php
function post(string $url, string $data, bool $showOutput)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    if($showOutput) echo $response;
}

function sendMessage($showOutput=false)
{
    $config = json_decode(file_get_contents("config.json"), true);
    $filedata = file_get_contents("usernames.txt");
    $isTelegram = $config["telegram"];
    if($isTelegram==="yes") {
      $telegram_id = $config["telegram_id"];
      $bot_token = $config["bot_token"];
      $url = "https://api.telegram.org/bot" . $bot_token . "/sendMessage";
      $data = json_encode(json_decode('{"chat_id": "' . $telegram_id . '", "text": "' . str_replace(PHP_EOL, "\\n", $filedata) . '"}'));
      post($url, $data, $showOutput);
    }
}
?>
