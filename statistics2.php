<?php
$page_title = "Startsida";
include("includes/header.php");
include('biblo/httpful.phar');
?>
	<div id= container5>
		<div id="pieDiv"></div> 

			<script> 

			pieDiv = document.getElementById('pieDiv');
			
			/*const params = new URLSearchParams(window.location.search);
			if (params.has('code')){
				const workcode = params.get('code');
				const statiticsHeader = params.get('header');
				document.getElementById('headerStatistics').innerHTML = statiticsHeader; */
				let url = "getStatistics2.php";
				var layout = {
                    title: "Exminerade i Sverige 2008", 
                    showlegend: false
                };

				fetch( url, {method: 'GET'} )
					.then( resp => resp.json())
					
					//.then( resp => console.log(JSON.stringify(resp.json())))
					.then( data => Plotly.newPlot(pieDiv, data, layout))
					.catch( data => console.error(data));
					
				
			</script>
		</div>
    	


        
<!-- avslutar body och html som startar i header.php-->
</body>
</html>