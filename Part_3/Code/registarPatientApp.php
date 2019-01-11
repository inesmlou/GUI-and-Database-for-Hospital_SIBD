<html>
	<body>
		<form action="inserirPatientApp.php" method="post">
			<h3>Registar o paciente e marcar consulta</h3>
			<h4>Dados do paciente:</h4>
			<p>ID (P-XXX): <input type="text" name="patient_id"/></p>
			<p>Nome: <input type="text" name="name_pat"/></p>
			<p>Data de Nascimento: <input type="date"name="birthday"/></p>
			<p>Morada: <input type="text" name="address"/></p>
			<hr/>
			<h4>Marcação da Consulta:</h4>
			<p><input type="hidden" name="flag" value=1/></p>
			<p>Data: <input type="date" name="appDate"/></p>
			<p>Hora: <input type="time" name="appTime"/></p>
			<p>Consultório: <br/><input type="radio" name="office" value="A1"/>A1
			<input type="radio" name="office" value="A2"/>A2
			<input type="radio" name="office" value="A3"/>A3
			<input type="radio" name="office" value="A4"/>A4
			<input type="radio" name="office" value="A5"/>A5
			<input type="radio" name="office" value="A6"/>A6
			<input type="radio" name="office" value="A7"/>A7
			<input type="radio" name="office" value="A8"/>A8</p>
			<p>Médico:
				<select name="doctor_id">
<?php
				$host = "db.ist.utl.pt";
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

			$connection = null;
?>
				</select>
			</p>
			<p><input type="submit" value="Submeter"/></p>	
		</form>
		
		<hr/>
		<p>Para regressar ao início: <a href="proj3.php">Página Inicial</a></p>
	</body>
</html>