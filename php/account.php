<?php
session_start();

if($_SESSION['loggued_as_user'])
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
			$users = mysqli_query($conn, "SELECT * FROM ft_minishop.users WHERE ft_minishop.users.name='".$_SESSION['loggued_as_user']."'");
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
	header("Location: ../html/login.html");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="../css/login.css">
	<link rel="stylesheet" href="../css/bootstrap-grid.css">
</head>
<body>
	<div id="header">
		<div class="wrapper">
			<div class="left">
				<div class="header-btn">
					<a href="../index.php">Home</a>
				</div>		
			</div>
			<div class="right">
				<ul class="nav-bar">
					<li class="header-btn">
						<a href="account.php"><span><img class="icon" src="../img/account.png" alt=""></span>
							<?php if($_SESSION['loggued_as_user'])
							{
								echo $_SESSION['loggued_as_user'];
							}
							else
							{
								echo "Acount";
							}?>
						</a>
					</li>
					<li class="header-btn">
						<a href="../php/basket.php"><span><img class="icon" src="../img/basket-cart.png" alt=""></span>Basket</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="data" style="margin:50px auto;text-align: center;">
		<?php
		foreach($users as $user)
		{
			?>
			<h3 style="margin-bottom: 20px;">Username: <?php echo $user['name']?></h3>
			<h3 style="margin-bottom: 20px;">Email: <?php echo $user['email']?></h3>
			<h3 style="margin-bottom: 20px;">Type: <?php echo $user['type']?></h3>
			<?php
		}
		?>
		<a style="color: black;" href="logout.php">Logout</a>
	</div>

</body>
</html>