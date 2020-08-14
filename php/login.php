<?php

	session_start();

	if($_POST['username'] && $_POST['password'])
	{
		if(file_exists("../database.db"))
		{
			$data = unserialize(file_get_contents("../database.db"));

			$servername = $data['servername'];
			$username = $data['db-username'];
			$password = $data['db-password'];

			$conn = new mysqli($servername, $username, $password);

			if($conn->connect_error)
			{
				echo("Connection to db failed, Reinstall the site ?")
				?><a style="color: black;" href="../install.php">Reinstall</a><?php
				return;
			}
			else
			{
				$users = mysqli_query($conn, "SELECT * FROM ft_minishop.users");
				
				foreach ($users as $user)
				{
					if($user['name'] == $_POST['username'] && $user['password'] == hash('whirlpool', $_POST['password']))
					{
						$_SESSION['loggued_as_user'] = $_POST['username'];

						if(isset($_SESSION['user-basket']))
						{
							foreach ($_SESSION['user-basket'] as $row)
							{
								mysqli_query($conn, "INSERT INTO ft_minishop.basket (id_product, id_user) VALUES (".$row['id'].", ".$user['id'].")");
							}
						}

						header("Location: ../index.php");
						return;
					}
				}

				echo "Error\n";
				?>
				<a href="../html/login.html">Login again</a>
				<?php


			}
		}
		else
		{
			echo "Error\n";
			?>
			<a href="../html/login.html">Login again</a>
			<?php
		}
	}
	else
	{
		echo "Error\n";
		?>
		<a href="../html/login.html">Login again</a>
		<?php
	}

?>