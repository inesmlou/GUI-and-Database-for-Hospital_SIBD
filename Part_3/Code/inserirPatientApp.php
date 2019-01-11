<html>
	<body>
		<h3>Registar o paciente e marcar consulta</h3>
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
		
		$flag = $_REQUEST['flag'];
		$patient_id = $_REQUEST['patient_id'];
		$name_pat = $_REQUEST['name_pat'];
		$birthday = $_REQUEST['birthday'];
		$address = $_REQUEST['address'];
		$appDate = $_REQUEST['appDate'];
		$appTime = $_REQUEST['appTime'];
		$office = $_REQUEST['office'];
		$doctor_id = $_REQUEST['doctor_id'];
		$totaldate = "$appDate $appTime";
		
		if ($flag == 1)
		{
			$sql = "SELECT patient_id FROM patient WHERE patient_id like '%$patient_id%'";
			$result = $connection->query($sql);
			$nrowsp = $result->rowCount();			
		}
		else
		{
			$nrowsp = 0;
		}
		
		$sql = "SELECT date_ap FROM appointment WHERE patient_id like '%$patient_id%' AND doctor_id like '%$doctor_id%' and date_ap like '%$totaldate%'";
		$result = $connection->query($sql);
		$nrowsa = $result->rowCount();
			
		if (($nrowsp == 0) && ($nrowsa == 0))
		{
		
			if (empty($patient_id) || empty($name_pat) || empty($birthday) || empty($address) || empty($appDate) || empty($appTime) || empty($office) || empty($doctor_id))
			{
				echo("<p>Preenchimento inválido</p>");
				echo("<p></p>");
				echo("<p>Todos os campos devem ser preenchidos.</p>");
				echo("<p></p>");
				echo("<p>Retroceda e tente novamente.</p>");
				echo("<hr/>");
				echo("<p>Para regressar ao início: <a href=\"proj3.php\">Página Inicial</a></p>");
				
			}
			else
			{
				$connection->beginTransaction();
				
				if ($flag == 1)
				{

					$stmt = $connection->prepare("INSERT INTO patient VALUES (:patient_id, :name_pat, :birthday, :address)");
		
					$stmt->bindParam(':patient_id', $patient_id);
					$stmt->bindParam(':name_pat', $name_pat);
					$stmt->bindParam(':birthday', $birthday);
					$stmt->bindParam(':address', $address);
					$stmt->execute();
				}
				
				$stmt = $connection->prepare("INSERT INTO appointment VALUES (:patient_id, :doctor_id, :totaldate, :office)");
		
				$stmt->bindParam(':patient_id', $patient_id);
				$stmt->bindParam(':doctor_id', $doctor_id);
				$stmt->bindParam(':totaldate', $totaldate);
				$stmt->bindParam(':office', $office);
				$stmt->execute();
				
				
				if (date('Y-m-d H:i:s') < date('Y-m-d H:i:s', strtotime("$appDate $appTime")))
				{			
					if (date('w', strtotime("$appDate $appTime")) == 0 || date('w', strtotime("$appDate $appTime")) == 6)
					{
						echo("<p>Preenchimento inválido</p>");
						echo("<p></p>");
						echo("<p>A data da consulta tem de ser a um dia de semana.</p>");
						echo("<p></p>");
						echo("<p>Retroceda e tente novamente.</p>");
						echo("<hr/>");
						echo("<p>Para regressar ao início: <a href=\"proj3.php\">Página Inicial</a></p>");
						$connection->rollback();
					}
					else
					{ 
						echo("<p>Preenchimento válido</p>");
						echo("<p></p>");
						echo("<p>Regressar ao início: <a href=\"proj3.php\">Página Inicial</a></p>");
						$connection->commit();
					
					}
				}
				else
				{
					echo("<p>Preenchimento inválido.</p>");
					echo("<p></p>");
					echo("<p>A data da consulta tem de ser posterior ao dia de hoje.</p>");
					echo("<p></p>");
					echo("<p>Retroceda e tente novamente.</p>");
					echo("<hr/>");
					echo("<p>Para regressar ao início: <a href=\"proj3.php\">Página Inicial</a></p>");
					$connection->rollback();
				}
			}
			
		}
		else
		{
			echo("<p>Preenchimento inválido</p>");
			echo("<p></p>");
			echo("<p>O ID introduzido já existe ou essa consulta já se encontra marcada.</p>");
			echo("<p></p>");
			echo("<p>Retroceda e tente novamente.</p>");
			echo("<hr/>");
			echo("<p>Para regressar ao início: <a href=\"proj3.php\">Página Inicial</a></p>");
		}
	$connection = null;
?>
	</body>
</html>