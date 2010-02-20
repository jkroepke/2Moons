<html>
    <head>
        <title>Session beendet</title>
        <link rel="shortcut icon" href="favicon.ico">
		<link rel="stylesheet" type="text/css" href="styles/css/default.css">
		<link rel="stylesheet" type="text/css" href="styles/css/formate.css">
		<link rel="stylesheet" type="text/css" href="{dpath}formate.css" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <script type="text/javascript" src="scripts/overlib.js"></script>

    </head>
    
    <body>
        <script type="text/javascript">
            var second = 5;

            function Init() {
                document.getElementById("CompteARebours").innerHTML = second;
                setInterval(AffichageCompteARebours,1000);
            }

            function AffichageCompteARebours() {
                document.getElementById("CompteARebours").innerHTML = --second;
				if (document.getElementById("CompteARebours").innerHTML == 0){
				window.location.href='./index.php';
				}
            }
 
            window.onload = function () { Init(); }
        </script>
        <center>
			<table width="519">
				<tr>
					<td class="c"><font color="">Logout erfolgreich! Bis bald!</font></td>
					</tr>
				<tr>
					<th class="errormessage">Session wurde beendet.</th>
				</tr>
			</table>
			<br><br>
			<table width="519">
			<tr>
				<td class="c">Weiterleitung</td>
			</tr>
			<tr>
			<th class="errormessage">Sie werden in <span id=CompteARebours></span> s weitergeleitet.<br /><a href="./index.php">Klicken Sie hier, um nicht zu warten</a></th>
				</tr>
			</table>
        </center>
    </body> 
</html> 