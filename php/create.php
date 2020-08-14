<?php

	if($_POST['username'] && $_POST['password'] && $_POST['email'])
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
					if($user['name'] == $_POST['username'])
					{
						echo "This user already exists\n";
						?>
							<a href="../html/create.html">Retry</a>
						<?php
						return;
					}
				}

				mysqli_query($conn, "INSERT INTO ft_minishop.users (ft_minishop.users.name, ft_minishop.users.email, ft_minishop.users.password, 'other') VALUES ('".$_POST['name']."')")


			}
		}
		else
		{
			echo "Error\n";
			?>
			<a href="../html/create.html">Login again</a>
			<?php
		}
	}
	else
	{
		echo "Error\n";
		?>
		<a href="../html/create.html">Login again</a>
		<?php
	}
?>