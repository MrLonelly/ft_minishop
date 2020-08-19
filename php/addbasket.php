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

if(isset($_SESSION['loggued_as_user']))
{
	if(isset($_POST['product']))
	{
		$users = mysqli_query($conn, "SELECT * FROM ft_minishop.users WHERE ft_minishop.users.name = '".$_SESSION['loggued_as_user']."'");
		$products = mysqli_query($conn, "SELECT * FROM ft_minishop.products where ft_minishop.products.id = ".$_POST['product']);

		$user = mysqli_fetch_assoc($users);
		$product = mysqli_fetch_assoc($products);

		mysqli_query($conn, "INSERT INTO ft_minishop.products (product_id, user_id) VALUES (".$product['id'].", ".$user['id'].")");
	}
}
else
{
	$products = mysqli_query($conn, "SELECT * FROM ft_minishop.products where ft_minishop.products.id = ".$_POST['product']);

	$data = mysqli_fetch_assoc($products);

	print_r($data);

 	$_SESSION['user_basket'][] = $data;

 	print_r($_SESSION);
}

header("Location: ../index.php");

?>