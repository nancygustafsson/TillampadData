<?php
include('biblo/httpful.phar');

    $url = "https://api.scb.se/OV0104/v1/doris/sv/ssd/START/UF/UF0205/RegLasarN";

    // Sökkoden som skickas med POST-anropet hämtas från en fil istället för att skrivas direkt här som i postExempel_1.php
    $postKod = file_get_contents( "postAnrop2.json" ); 

    // Hämta data
    $response = \Httpful\Request::post( $url )
        ->body( $postKod )
        ->send();

    $inData =  json_decode( $response ); // utf8_encode( $response );

    $nrMenWom = array();
    $labels = array();
    
   //var_dump($response);

    foreach ( $inData->data as $examCode )
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
        "type" => "pie",
    ]];

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($data);
    
?>