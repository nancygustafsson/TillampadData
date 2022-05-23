<?php
include('biblo/httpful.phar');

    $url = "https://api.scb.se/OV0104/v1/doris/sv/ssd/START/UF/UF0205/RegLasarN";

    $postKod = file_get_contents( "postAnrop2.json" ); // läser in JSON filen

    $response = \Httpful\Request::post( $url ) //gör post-anropet , fråga till scb servern
        ->body( $postKod ) //skickar med argument till scb 
        ->send();

    $inData =  json_decode( $response ); // $response som är en sträng görs om till ett objekt så det blir en struktur

    $nrMenWom = array();
    $labels = array();
    
   //var_dump($response);

    foreach ( $inData->data as $examCode ) // Värden läggs in i arrayerna 
    {
            if (strcmp($examCode->key[2], "1") == 0) {
                $nrMenWom[] = $examCode->values[0];
                $labels[] = "Män";
            } else {
                $nrMenWom[] = $examCode->values[0];
                $labels[] = "Kvinnor";
            }
    }

    $data = [ [
        "values" => $nrMenWom,
        "labels" => $labels,
        "type" => "pie", //pie-diagram tilldelas 
    ]];

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($data); //möjliggör att diagrammet visas
    
?>