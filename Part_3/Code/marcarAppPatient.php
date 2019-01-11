<html>
	<body>
		<h3>Marcar consulta</h3>
<?php
		$host = "db.tecnico.ulisboa.pt";
		$user = "ist175988";
		$pass = "tifn6509";
		$dsn = "mysql:host=$host;dbname=$user";
		try
		{
			$connection = new PDO($dsn, $user, $pass);
		}
		catch(PDOException $exception)
		{
			echo("<p>Error: ");
			echo($exception->getMessage());
			echo("</p>");
			exit();
		}
		
		echo("<h4>Dados do paciente:</h4>");
		echo("<p></p>");
		
		$idpatient = $_REQUEST['idpatient'];
		$sql = "SELECT * FROM patient WHERE patient_id like '%$idpatient%'";
	
		$result = $connection->query($sql);
		$nrows = $result->rowCount();
		if ($nrows == 0)
		{
			echo("<p>Esse paciente não existe.</p>");
			echo("<p></p>");
			echo("<p><a href=\"registarPatientApp.php\">Registar paciente e marcação</a></p>");
		}
		else
		{
		
			echo("<table border=\"1\">");
			echo("<tr><td>ID</td><td>Nome de paciente</td><td>Data de Nascimento</td><td>Morada</td></tr>");
			foreach($result as $row)
			{
				echo("<tr><td>");
				echo($row['patient_id']);
				echo("</td><td>");
				echo($row['name_pat']);
				echo("</td><td>");
				echo($row['birthday']);
				echo("</td><td>");
				echo($row['address']);
				echo("</td></tr>");
				$patient_id = $row['patient_id'];
				$name_pat = $row['name_pat'];
				$birthday = $row['birthday'];
				$address = $row['address'];
			}
			echo("</table>");
			
			
			echo("<form action=\"inserirPatientApp.php\" method=\"post\">");
			echo("<h4>Marcação da Consulta:</h4>");
			echo("<p><input type=\"hidden\" name=\"patient_id\" value='$patient_id'/></p>");
			echo("<p><input type=\"hidden\" name=\"name_pat\" value='$name_pat'/></p>");
			echo("<p><input type=\"hidden\" name=\"flag\" value=0/></p>");
			echo("<p><input type=\"hidden\" name=\"birthday\" value='$birthday'/></p>");
			echo("<p><input type=\"hidden\" name=\"address\" value='$address'/></p>");
			echo("<p>Data: <input type=\"date\" name=\"appDate\"/></p>");
			echo("<p>Hora: <input type=\"time\" name=\"appTime\"/></p>");
			echo("<p>Consultório: <br/><input type=\"radio\" name=\"office\" value=\"A1\"/>A1");
			echo("<input type=\"radio\" name=\"office\" value=\"A2\"/>A2");
			echo("<input type=\"radio\" name=\"office\" value=\"A3\"/>A3");
			echo("<input type=\"radio\" name=\"office\" value=\"A4\"/>A4");
			echo("<input type=\"radio\" name=\"office\" value=\"A5\"/>A5");
			echo("<input type=\"radio\" name=\"office\" value=\"A6\"/>A6");
			echo("<input type=\"radio\" name=\"office\" value=\"A7\"/>A7");
			echo("<input type=\"radio\" name=\"office\" value=\"A8\"/>A8</p>");
			echo("<p>Médico: <select name=\"doctor_id\">");
			
			$sql = "SELECT name_doc, doctor_id FROM doctor ORDER BY name_doc";
			$result = $connection->query($sql);
			if ($result == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}

			foreach($result as $row)
			{
				$name_doc = $row['name_doc'];
				$doctor_id = $row['doctor_id'];
				echo("<option value=\"$doctor_id\">$name_doc $doctor_id</option>");
			}
			
			echo("</select></p>");
			echo("<p><input type=\"submit\" value=\"Submeter\"/></p>");
			echo("</form>");
		}
		
	$connection = null;
?>	

		<hr/>
		<p>Para regressar ao início: <a href="proj3.php">Página Inicial</a></p>
		
	</body>
 </html>