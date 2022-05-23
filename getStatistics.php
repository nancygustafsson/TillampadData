<?php
include('biblo/httpful.phar');
    
        if( isset( $_GET["code"])) {  // gör ett till anrop till scb, sidan är tom när vi inte valt ett yrke
            $occupationCode = $_GET["code"];
            $url = "https://api.scb.se/OV0104/v1/doris/sv/ssd/START/AM/AM0110/AM0110A/LonYrkeRegion4A";

            $postKod = file_get_contents( "postAnrop.json" );  // läser in JSON filen
        
            $response = \Httpful\Request::post( $url )  //gör post-anropet , fråga till scb servern
                ->body( $postKod )  //skickar med argument till scb 
                ->send();
        
            $inData =  json_decode( $response );   // $response som är en sträng görs om till ett objekt så det blir en struktur
        
            $artalArr = array();
            $inkomstArrMen = array();
            $inkomstArrWom = array();

            foreach ( $inData->data as $saleryCode )  // Värden läggs in i arrayerna 
            {
                if (strcmp($saleryCode->key[2], $occupationCode) == 0) {
                    if (strcmp($saleryCode->key[3], "1") == 0) {
                        $artalArr[] = $saleryCode->key[4];
                        $inkomstArrMen[] = $saleryCode->values[0];
                    } else {
                        $inkomstArrWom[] = $saleryCode->values[0];
                    }
                }
            }

            $menData = [  //skapar stapeldiagram
                "x" => $artalArr,
                "y" => $inkomstArrMen,
                "name" => "Man",
                "type" => "bar", 
                
            ];
  
            $womenData = [ //skapar stapeldiagram
                "x" => $artalArr,
                "y" => $inkomstArrWom,
                "name" => "Kvinna",
                "type" => "bar" 
            ]; 

            $data = [$menData, $womenData];
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($data); //möjliggör att tabellen visas
        }
?>