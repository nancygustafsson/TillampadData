<?php
$page_title = "Startsida";
include("includes/header.php");
include('biblo/httpful.phar');
?>

    <div id="container2" >
       	<div class="div1">  <!-- div1 innehåller vänstertabellen -->
		   <?php
				$url = "https://api.scb.se/OV0104/v1/doris/sv/ssd/START/AM/AM0110/AM0110A/LonYrkeRegion4A"; //url från scb
				$response = \Httpful\Request::get( $url )->send();    //Rest-anrop (http-anrop med get). Httpful är ett bibliotek som möjliggör interaktion med API, $response är en json sträng
				$inData =  json_decode( $response );  // $response som är en sträng görs om till ett objekt så det blir en struktur

				$json = file_get_contents('postAnrop.json'); // läser in JSON filen
  
				$json_data = json_decode($json,true);  // Decodar JSON filen, gör om till ett objekt 

				$index = 0;   
				$validWorkCodes = $json_data['query'][2]['selection']['values'];  //hämtar ut yrkeskoder från postAnrop

				echo "<ul id='ul1'>";     //lista skapas
				foreach ($inData->variables[2]->values as $value)
				{
					if (in_array($value, $validWorkCodes)){
						echo "<li id='li1'><a href='statistics.php?code=".$value."&header=".$inData->variables[2]->valueTexts[$index]."'>".$inData->variables[2]->valueTexts[$index]."</a></li>"; //skapar url där query-parameter skickas med (se code = ... i url)
					}
					$index += 1;   //när länken klickas på börjar 
				
				}
				echo "</ul>";
			?>

    	</div>
	
		<h3> Klicka på ett yrke i tabellen för att få fram statistiken </h3>
		<h2> Yrke som jämförs: </h2>
		<h2 id="headerStatistics"> </h2>
			<div id="chartDiv"> </div> <!-- div som innehåller stapeldiagramet -->
			<script> /* javascriptet exekveras uppe i browsern och gör då anrop mot getStatistics som ligger på servern, getStatistics gör
			sedan ett anrop till scb för att hämta data, och retrunerar en json struktur som vi tar emot på serversidan och ritar graf mha javascript */

			
			chartDiv = document.getElementById('chartDiv');
			
			const params = new URLSearchParams(window.location.search); //sökparameter, får hela adressen som finns uppe i sökfältet
			if (params.has('code')){      // om det finns en kod i sökparametern så hämtas kod och header ut
				const workcode = params.get('code');   
				const statiticsHeader = params.get('header');
				document.getElementById('headerStatistics').innerHTML = statiticsHeader; //sätter yrkestitel 
				let url = "getStatistics.php?code="+workcode;  // bygger upp URL'n och gör ett anrop mha av fetch
				var layout = {barmode: 'group'};

				fetch( url, {method: 'GET'} )  
					.then( resp => resp.json() )
					.then( data => Plotly.newPlot(chartDiv, data, layout))
					.catch( data => console.error(data));
					
			}
			</script>
			
    	
	</div>
</div>

<!-- avslutar body och html som startar i header.php-->
</body>
</html>

	
