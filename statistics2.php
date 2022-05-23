<?php
$page_title = "Startsida";
include("includes/header.php");
include('biblo/httpful.phar');
?>
	<div id= container5>
		<h2> Cirkeldiagrammet visar antalet examinerade år 2008 baserat på kön </h2>
		<div id="pieDiv"></div> <!-- div som innehåller stapeldiagramet -->
			<script> 

				pieDiv = document.getElementById('pieDiv'); 
	
				let url = "getStatistics2.php";
				var layout = {
                    title: "Examinerade i Sverige 2008", 
                    showlegend: true   //visar färgen för män och kvinnor
                };

				fetch( url, {method: 'GET'} )
					.then( resp => resp.json())
					.then( data => Plotly.newPlot(pieDiv, data, layout))
					.catch( data => console.error(data));
					
			</script>
		</div>

</body>
</html>
