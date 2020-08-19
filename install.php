<?php
	if(isset($_POST['servername']) && isset($_POST['db-username']) && isset($_POST['db-password']))
	{
		if($_POST['admin'] && $_POST['adminmail'] && $_POST['admpwd'])
		{
			// MySQL host
			$data['servername'] = $_POST['servername'];
			// MySQL username
			$data['db-username'] = $_POST['db-username'];
			// MySQL password
			$data['db-password'] = $_POST['db-password'];

			// Check connection of new data
			$conn = mysqli_connect($data['servername'], $data['db-username'], $data['db-password']);

			if(!$conn)
			{
				// Retry proposal
				echo "Connection failed! Do you want to retry ?";
				?><a href="install.php">Retry</a><?php
				return;
			}
			else
			{
				// Store database data
				file_put_contents("./database.db", serialize($data));

				// Perforing database query

				// Drop existing incorect database
				mysqli_query($conn, "DROP DATABASE IF EXISTS ft_minishop");

				// Create ft_minishop database
				mysqli_query($conn, "CREATE DATABASE ft_minishop");

				// Create products table
				mysqli_query($conn, "CREATE TABLE ft_minishop.products (
					id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
					name VARCHAR(16) NOT NULL,
					image VARCHAR(255) NOT NULL DEFAULT './img/default-product.jpeg',
					price INT DEFAULT '0',
					description VARCHAR(255) NOT NULL,
					sold INT NOT NULL default '0',
					category ENUM('microsoft', 'linux', 'macos'),
					creation_date DATE NOT NULL
				)");

				// Create user table
				mysqli_query($conn, "CREATE TABLE ft_minishop.users (
					id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
					name VARCHAR(64) NOT NULL,
					email VARCHAR(100) NOT NULL,
					password VARCHAR(1000) NOT NULL,
					type ENUM('admin', 'user') NOT NULL
				)");

				// Create basket table
				mysqli_query($conn, "CREATE TABLE ft_minishop.basket (
					id_product INT NOT NULL,
					id_user INT NOT NULL,
					FOREIGN KEY (id_product) REFERENCES ft_minishop.products(id),
					FOREIGN KEY (id_user) REFERENCES ft_minishop.users(id)
				)");

				// Create admin user
				$admin = $_POST['admin'];
				$adminemail = $_POST['adminmail'];
				$adminpwd = hash('whirlpool', $_POST['admpwd']);

				// Push admin user
				mysqli_query($conn, "INSERT INTO ft_minishop.users (name, email, password, type) VALUES
					('".$admin."','".$adminemail."','".$adminpwd."', 'admin')
				");

				// Push test product
				mysqli_query($conn, "INSERT INTO ft_minishop.products (name, price, description, creation_date, category) VALUES
					('WinowsXP', 40, 'Fastest windows in tha hood', '2020-12-12', 'microsoft')
				");

				// Test basket
				mysqli_query($conn, "INSERT INTO ft_minishop.basket (id_product, id_user) VALUES (1, 1)");

				// Redirect User to main page
				header("Location: ./index.php");
			}


		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Install ft_minishop</title>
	<style>
		* {
			margin: 0;
			padding: 0;
		}

		body {
			background: url("img/install-bg.jpeg");
			background-size: cover;
		}
		form {
			width: 30%;
			padding: 30px;
			margin: 100px auto 0;
			background-color: white;
		}

		input[type="text"], input[type="password"] {
			width: 100%;
			margin: 10px 0;
		}

		form p {
			margin: 10px 0 5px;
		}

		input[type="submit"] {
			margin-top: 20px;
			width: 100px;
			height: 50px;
		}

	</style>
</head>
<body>
	<form action="install.php" method="post">
		<p>Servername:</p> <input type="text" name="servername">
		<p>DB-Username:</p> <input type="text" name="db-username">
		<p>DB-Password:</p> <input type="password" name="db-password">
		<hr />
		<p>Admin Login:</p> <input type="text" name="admin">
		<p>Admin Email:</Ap> <input type="text" name="adminmail">
		<p>Admin Password:</p> <input type="password" name="admpwd">
		<hr />
		<input type="submit" value="Install">
	</form>	
</body>
</html>