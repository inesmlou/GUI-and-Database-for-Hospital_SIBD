<html>
	<body>
		<h3>Verificar a existência do paciente</h3>
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
		
		$patient_name = $_REQUEST['patient_name'];
		$sql = "SELECT * FROM patient WHERE name_pat like '%$patient_name%'";

		$result = $connection->query($sql);
		$nrows = $result->rowCount();
		if ($nrows == 0)
		{
			echo("<p>Não existe nenhum paciente com esse nome.</p>");
			echo("<p></p>");
			echo("<p><a href=\"registarPatientApp.php\">Registar paciente e marcação</a></p>");
		}
		else
		{
			echo("<p>O paciente é algum destes?</p>");
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
			}
			echo("</table>");
			
			echo("<p></p>");
			echo("<p>Se não: <a href=\"registarPatientApp.php\">Registar paciente e marcação</a></p>");
			
			echo("<p></p>");
			echo("<form action=\"marcarAppPatient.php\" method=\"post\">");
			echo("<p>Se sim, qual é o paciente?</p>");		
			echo("<p>ID:<select name=\"idpatient\">");
			
			$sql = "SELECT patient_id FROM patient WHERE name_pat like '%$patient_name%'";
			$result = $connection->query($sql);
			if ($result == FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[2]}</p>");
				exit();
			}

			foreach($result as $row)
			{
				$patient_id = $row['patient_id'];
				echo("<option value=\"$patient_id\">$patient_id</option>");
			}
			
			echo("</select></p>");
			echo("<p><input type=\"submit\" value=\"Selecionar\"/></p>");
			echo("</form>");
		
		}
		
	$connection = null;
?>

		<hr/>
		<p>Para regressar ao início: <a href="proj3.php">Página Inicial</a></p>
		
	</body>
 </html>