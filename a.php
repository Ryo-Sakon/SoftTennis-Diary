<?php

$url = '送り先URL';
$data = [];

// $dataに送るデータを詰めます。
$data['name'] = 'salumarine';
$data['type'] = 'monkey';

// 送信データをURLエンコード。
$data = http_build_query($data, "", "&");

// これを指定しないと動かない？
$header = [
    "Content-Type: application/x-www-form-urlencoded",
    "Content-Length: ".strlen($data)
];
// 送信の準備(ストリームを作る)
$options =[
   'http' => [
      'method' => 'POST',
      'header' => implode("\r\n", $header),
      'content' => $data
   ]
];

$context = stream_context_create($options);

$contents =file_get_contents($url, false, $context);

?>