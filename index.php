<?

function got($var, $value = null)
{
	if(isset($_GET[$var]))
	{
		if($value !== null)return $_GET[$var] == $value;
		else return $_GET[$var];
	}
	else return false;
}

if(got('action','match'))
{
	$matches = array();
	$ok      = preg_match_all(got('regexp'), got('text'), $matches);
	die(json_encode(array("ok" => $ok, "matches" => $matches)));
}

?>

<html>
	
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<style type="text/css">
			body
			{
				font-family:sans-serif;
			}
			div#main
			{
				width:600px;
				min-height:800px;
				margin: 0 auto;
				background-color:#eee;
				padding:15px;
				border-radius:5px;
				border:1px solid #777;
			}
			#regexp, #text
			{
				width: 600px;
			}
			#regexp
			{
				font-size:1.4em;
			}
			#text
			{
				height:100px;
			}
			span.match_number
			{
				font-size:0.6em;
				color:blue;
			}
			span.capture_number
			{
				font-size:0.6em;
				color:green;
			}
			div#matches
			{
				overflow:auto;
			}
		</style>
		<script type="text/javascript">
			var test = function(){
				var regexp = $('#regexp').val();
				$.getJSON('',{'action': 'match','regexp': regexp, 'text': $('#text').val()}, function(data){
					console.log(data);
					if(data['ok'])
					{
						var html = "<ul>";
						for(var i = 0; i < data['ok']; i++)
						{
							html += "<li><span class='match_number'>match "+i+":</span> " + data['matches'][0][i];
							html += "<ul>";
								for(var j = 1; j < data['matches'].length; j++)
								{
									html += "<li><span class='capture_number'>capture "+j+":</span> " + data['matches'][j][i] + "</li>";
								}
							html += "</ul>";
							html += "</li>";
						}
						html += "</ul>"
						$('#matches').html(html);
					}
					else
					{
						$('#matches').html("No match!");
					}
				});
			};
		
			$(function(){
				$('#regexp').keyup(function(){test();});
				$('#text').keyup(function(){test();});
			});
			
		</script>
	</head>
	
	<body>
		<div id="main">
			Expression (put the enclosing slashes!)<br/>
			<input id="regexp" type="text"></input>
			<br/>
			Test text<br/>
			<textarea id="text"></textarea>
			<div id="matches">
			</div>
		</div>
	</body>
	
</html>
