<?php
	session_start();

	if(file_exists("../database.db"))
	{
		$data = unserialize(file_get_contents("../database.db"));

		$servername = $data['servername'];
		$username = $data['db-username'];
		$password = $data['db-password'];

		$conn = new mysqli($servername, $username, $password);

		if(isset($_GET['product']))
		{
			$data = mysqli_query($conn, "SELECT * FROM ft_minishop.products where ft_minishop.products.id = ".$_GET['product']);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Product</title>

	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/bootstrap-grid.css">

</head>
<body>

		<div id="header" style="display: inline-block;">
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
							<?php if(isset($_SESSION['loggued_as_user']))
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
						<a href="basket.php"><span><img class="icon" src="../img/basket-cart.png" alt=""></span>Basket</a>
					</li>
				</ul>
			</div>
		</div>
	</div>


	<div>
		<div class="wrapper">
			<?php
			foreach ($data as $row)
			{
				?>
				<img src=".<?php echo $row['image']?>">
				<h1><?php echo $row['name']?></h1>
				<h3><?php echo $row['description']?></h3>
				<h3><?php echo $row['price']?>$</h3>

				<form action="addbasket.php" method="post">
					<input type="hidden" name="product" value="<?php echo $row['id']?>">
					<button type="submit">Add to basket</button>
				</form>
				<?php
			}
			?>
			
		</div>
	</div>
</body>
</html>