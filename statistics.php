<?php
$page_title = "Startsida";
include("includes/header.php");
include('biblo/httpful.phar');

?>

    <div id="container2" >
       	<div class="div1"> 
		   <?php
				$url = "https://api.scb.se/OV0104/v1/doris/sv/ssd/START/AM/AM0110/AM0110A/LonYrkeRegion4A"; //anrop mot scb
				$response = \Httpful\Request::get( $url )
				->send();
				$inData =  json_decode( $response ); // utf8_encode( $response );

				// Read the JSON file 
				$json = file_get_contents('postAnrop.json');
  
				// Decode the JSON file
				$json_data = json_decode($json,true);

				$index = 0; 
				$validWorkCodes = $json_data['query'][2]['selection']['values'];

				echo "<ul id='ul1'>"; //styla li och ul!
				foreach ($inData->variables[2]->values as $value)
				{
					if (in_array($value, $validWorkCodes)){
						//echo "<li>".$value." ".$inData->variables[2]->valueTexts[$index]."</li>";
						echo "<li id='li1'><a href='statistics.php?code=".$value."&header=".$inData->variables[2]->valueTexts[$index]."'>".$inData->variables[2]->valueTexts[$index]."</a></li>"; //skapar url där query-parameter skickas med (se code = ... i url)
					}
					//när länken klickas på börjar 
					$index += 1;
				
				}
				echo "</ul>";
			?>

    	</div>
	
		<h3> Klicka på ett yrke i tabellen för att få fram statistiken </h3>
		<h2> Yrke som jämförs: </h2><h2 id="headerStatistics"> </h2>
			<div id="chartDiv"> 
			<script> 

			
			chartDiv = document.getElementById('chartDiv');
			
			const params = new URLSearchParams(window.location.search);
			if (params.has('code')){
				const workcode = params.get('code');
				const statiticsHeader = params.get('header');
				document.getElementById('headerStatistics').innerHTML = statiticsHeader; 
				let url = "getStatistics.php?code="+workcode;
				var layout = {barmode: 'group'};

				fetch( url, {method: 'GET'} )
					.then( resp => resp.json() )
					.then( data => Plotly.newPlot(chartDiv, data, layout))
					.catch( data => console.error(data));
					
			}
			</script>
			
    	</div>
	</div>
</div>

<!-- avslutar body och html som startar i header.php-->
</body>
</html>

	
