<?php

	session_start();

	if(file_exists("./database.db"))
	{
		$data = unserialize(file_get_contents("./database.db"));

		$servername = $data['servername'];
		$username = $data['db-username'];
		$password = $data['db-password'];

		$conn = new mysqli($servername, $username, $password);

		if($conn->connect_error)
		{
			echo("Connection to db failed, Reinstall the site ?")
			?><a style="color: black;" href="./install.php">Reinstall</a><?php
			return;
		}
	}
	else
		header("Location: ./install.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ft_minishop</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/bootstrap-grid.css">
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
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
						<a href="php/account.php"><span><img class="icon" src="img/account.png" alt=""></span>
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
						<a href="php/basket.php"><span><img class="icon" src="img/basket-cart.png" alt=""></span>Basket</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<section id="info">
		<div class="wrapper">
			<div class="info-image">
				<h1>ft_minishop</h1>
				<p>Cel mai nou si moder shop vazut vreodata</p>
			</div>
		</div>
	</section>

	<section id="menu">
		<div class="wrapper">
			<div class="row">
				<div class="col-12 col-md-4 info-card"><h4>Rapid</h4></div>
				<div class="col-12 col-md-4 info-card"><h4>Comod</h4></div>
				<div class="col-12 col-md-4 info-card"><h4>Sigur</h4></div>
			</div>
		</div>
	</section>

	<section id="top">
		<div class="wrapper">
			<h1>- Top Sellers -</h1>
			<div class="row">

				<?php
				$top = mysqli_query($conn, "SELECT * FROM ft_minishop.products ORDER BY ft_minishop.products.name DESC");
				
				$i = 0;
				foreach($top as $row)
				{
					if($i < 4)
					{
						?>
						<div class="col-12 col-md-6 col-lg-3">
							<div class="card">
								<div class="card-image" style="width: 100%; height: 70%; overflow: hidden;">
									<img style="height: 100%;" class="image" src="<?php echo $row['image']?>">
								</div>
								<p class="card-title"><?php echo $row['name']?></p>
								<p class="card-text"><?php echo $row['price']?>$</p>
								<form action="./php/product.php" method="get">
									<input type="hidden" name="product" value="<?php echo $row['id']?>">
									<button type="submit" class="col-6 col-md-4 col-lg-4 detail-button">Detalii</button>
								</form>
							</div>
						</div>
						<?php
						$i++;
					}
					else
					{
						break;
					}
				}

				?>

			</div>
		</div>
	</section>

	<section id="categories">
		<div class="wrapper">
			<h1>- Our Category -</h1>
			<div class="row">
				<div class="col-12 col-md-4 col-md-4">
					<div class="category categ-ms">
						<a href="#" class="categ-title">Microsoft Products</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-md-4">
					<div class="category categ-lx">
						<a href="#" class="categ-title">Linux Products</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-md-4">
					<div class="category categ-os">
						<a href="#" class="categ-title">OSX Products</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="trends">
		<div class="wrapper">
			<h1>- Last Added -</h1>
			<div class="row">
				<?php
				$top = mysqli_query($conn, "SELECT * FROM ft_minishop.products ORDER BY ft_minishop.products.creation_date DESC");
				
				$i = 0;
				foreach($top as $row)
				{
					if($i < 4)
					{
						?>
						<div class="col-12 col-md-6 col-lg-3">
							<div class="card">
								<div class="card-image" style="width: 100%; height: 70%; overflow: hidden;">
									<img style="height: 100%;" class="image" src="<?php echo $row['image']?>">
								</div>
								<p class="card-title"><?php echo $row['name']?></p>
								<p class="card-text"><?php echo $row['price']?>$</p>
								<form action="./php/product.php" method="get">
									<input type="hidden" name="product" value="<?php echo $row['id']?>">
									<button type="submit" class="col-6 col-md-4 col-lg-4 detail-button">Detalii</button>
								</form>
							</div>
						</div>
						<?php
						$i++;
					}
					else
					{
						break;
					}
				}

				?>			
			</div>
		</div>
	</section>

	<section id="sales">
		<div class="wrapper">
			<h1>- Sales -</h1>
			<div class="row">
				<?php
				$top = mysqli_query($conn, "SELECT * FROM ft_minishop.products ORDER BY ft_minishop.products.price ASC");
				
				$i = 0;
				foreach($top as $row)
				{
					if($i < 4)
					{
						?>
						<div class="col-12 col-md-6 col-lg-3">
							<div class="card">
								<div class="card-image" style="width: 100%; height: 70%; overflow: hidden;">
									<img style="height: 100%;" class="image" src="<?php echo $row['image']?>">
								</div>
								<p class="card-title"><?php echo $row['name']?></p>
								<p class="card-text"><?php echo $row['price']?>$</p>
								<form action="./php/product.php" method="get">
									<input type="hidden" name="product" value="<?php echo $row['id']?>">
									<button type="submit" class="col-6 col-md-4 col-lg-4 detail-button">Detalii</button>
								</form>
								
							</div>
						</div>
						<?php
						$i++;
					}
					else
					{
						break;
					}
				}

				?>					
			</div>
		</div>
	</section>

	<footer>
		<div class="wrapper">
			<p>Created by APavalac(mr_l0n3lly)</p>
		</div>
	</footer>
</body>
</html>