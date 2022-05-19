<?php
include('biblo/httpful.phar');
// Länk till nedladdade REST-biblioteket. Detta ligger i mappen biblo i överordnad katalog.
    
        if( isset( $_GET["code"])) {
            $occupationCode = $_GET["code"];
            $url = "https://api.scb.se/OV0104/v1/doris/sv/ssd/START/AM/AM0110/AM0110A/LonYrkeRegion4A";

            // Sökkoden som skickas med POST-anropet hämtas från en fil istället för att skrivas direkt här som i postExempel_1.php
            $postKod = file_get_contents( "postAnrop.json" ); 
        
            // Hämta data
            $response = \Httpful\Request::post( $url )
                ->body( $postKod )
                ->send();
        
            $inData =  json_decode( $response ); // utf8_encode( $response );
        
            $artalArr = array();
            $inkomstArrMen = array();
            $inkomstArrWom = array();

            foreach ( $inData->data as $saleryCode )
            {
                if (strcmp($saleryCode->key[2], $occupationCode) == 0) {
                    //echo $saleryCode->key[4]." ".$saleryCode->key[2]." ".$occupationCode." ";
                //var_dump($saleryCode);
                    if (strcmp($saleryCode->key[3], "1") == 0) {
                        $artalArr[] = $saleryCode->key[4];
                        $inkomstArrMen[] = $saleryCode->values[0];
                    } else {
                        $inkomstArrWom[] = $saleryCode->values[0];
                    }
                }
            }
            //JSON struktur i php
            $menData = [ 
                "x" => $artalArr,
                "y" => $inkomstArrMen,
                "name" => "Man",
                "type" => "bar",
                
            ];
  

             $womenData = [
                "x" => $artalArr,
                "y" => $inkomstArrWom,
                "name" => "Kvinna",
                "type" => "bar" 
            ]; 

            $data = [$menData, $womenData];
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($data);
        }
?>