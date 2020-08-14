<?php
	session_start();

	if(file_exists("../database.db"))
	{
		$data = unserialize(file_get_contents("../database.db"));

		$servername = $data['servername'];
		$username = $data['db-username'];
		$password = $data['db-password'];

		$conn = new mysqli($servername, $username, $password);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ft_minishop - Basket</title>
	<link rel="stylesheet" href="../css/bootstrap-grid.css">
	<link rel="stylesheet" type="text/css" href="../css/basket.css">
</head>
<body>
	<div id="header">
		<div class="wrapper">
			<div class="left">
				<div class="header-btn">
					<p><a href="../index.php">Home</a></p>
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
						<a href="basket.php"><span><img class="icon" src="../img/basket-cart.png" alt=""></span>Basket</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<section id="basket-content">
		<div class="wrapper">
			<div class="row">
				<?php
				if($_SESSION['loggued_as_user'])
				{
					$data = mysqli_query($conn, "SELECT products.id, products.name, products.description, products.price, products.image
						FROM ft_minishop.basket
						INNER JOIN ft_minishop.users ON ft_minishop.basket.id_user = ft_minishop.users.id
						INNER JOIN ft_minishop.products ON ft_minishop.basket.id_product = ft_minishop.products.id
						WHERE ft_minishop.users.id=1
					");
				}
				else
				{
					$data = $_SESSION['user_basket'];
				}
					
				if($data)
				{
					foreach ($data as $row)
					{
						//print_r($row);
						?>
						<div class="col-12">
							<div class="card">
								<img class="product-image" src=".<?php echo $row['image']?>" alt="product-image">
								<div>
									<p class="product-title"><?php echo $row['name']?></p>
									<p class="product-desc"><?php echo $row['description']?></p>
									<p class="product-price"><?php echo $row['price']?>$</p>
								</div>

								<form action="basket.php" method="post" class="delete-prod">
									<input type="hidden" name="prod-id" value="<?php echo $row['id']?>">
									<input type="submit" name="delete" value="X">
								</form>
							</div>
						</div>
						<?php
					}

					?>
					<form action="basket.php" method="post" class="checkout">
						<input type="hidden" name="checkout" value="ok">
						<input type="submit" value="Checkout">
					</form>
					<?php
				}
				else
				{
					?>
					<h1 style="margin: 30px 0; text-align: center;">NOTHING HERE</h1>
					<?php
				}
				?>

				
			</div>
		</div>
	</section>
</body>
</html>