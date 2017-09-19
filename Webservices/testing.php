<?php
    require __DIR__."/vendor/autoload.php";

    $client = new \GuzzleHttp\Client([
       //'base_url' => "http://localhost:8000",
        'defaults' => [
            'exceptions' => false,
        ]
    ]);

    //delete
   /* $url = 'http://localhost:8000/api/deletecategory';
    echo $url;
    echo "\n\n";

    $data = array(
        'node_id' => 10,
        'parent_id' => null,
        'node_name' => null,
    );

    $response = $client->post($url, [
        'body' => json_encode($data),
    ]);

    echo 'Status Code: '.$response->getStatusCode();
    echo "\n\n";
    echo 'Body: '.$response->getBody();
    echo "\n\n";
*/
    //insert
/*
    $url = 'http://localhost:8000/api/categories';
    echo $url;
    echo "\n\n";

    $data = array(
        'parent_id' => 1,
        'node_name' => 'new node',
    );

    $response = $client->post($url, [
        'body' => json_encode($data),
    ]);

    echo 'Status Code: '.$response->getStatusCode();
    echo "\n\n";
    echo 'Body: '.$response->getBody();
    echo "\n\n";
*/
    //search
/*
    $url = 'http://localhost:8000/api/categories';
    echo $url;
    echo "\n\n";

    $data = array(
        'node_id' => null,
        'parent_id' => null,
        'node_name' => null,
    );

    $response = $client->get($url, [
        'body' => json_encode($data),
    ]);

    echo 'Status Code: '.$response->getStatusCode();
    echo "\n\n";
    echo 'Body: '.$response->getBody();
    echo "\n\n";
*/

//change position

    $url = 'http://localhost:8000/api/changeposition';
    echo $url;
    echo "\n\n";

    $data = array(
        'node_id' => 3,
        'new_position' => 999,
    );

    $response = $client->post($url, [
        'body' => json_encode($data),
    ]);

    echo 'Status Code: '.$response->getStatusCode();
    echo "\n\n";
    echo 'Body: '.$response->getBody();
    echo "\n\n";


?>

