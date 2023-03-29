<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="index.css" type="text/css">
	<title>Document</title>
</head>
	<body class="body">
		<?php 

			define("SERVERNAME","127.0.0.1");
			define("DB_LOGIN","root");
			define("DB_PASSWORD","");
			define("DB_NAME","info_test");

			// Подключаемся к 1 таблице.
			$connect = new mysqli(SERVERNAME, DB_LOGIN, DB_PASSWORD, DB_NAME);
			$sql = "SELECT * FROM `user`";
			$result = $connect->query($sql);
			for($user=array();$row=$result->fetch_assoc();$user[]=$row);
			$connect->close();

			// Подключаемся к 2 таблице.
			$connect = new mysqli(SERVERNAME, DB_LOGIN, DB_PASSWORD, DB_NAME);
			$sql = "SELECT * FROM `user2`";
			$result = $connect->query($sql);
			for($user2=array();$row=$result->fetch_assoc();$user2[]=$row);
			$connect->close();

			// Добавляем карточки из 1 тиблицы во 2 таблицу.
		if(isset($_POST['add'])){
			$name2 = $_POST['name'] ?? '';
			$price2 = $_POST['price'] ?? '';
			$imageURL2 = $_POST['image'] ?? '';
			$id2 = $_POST['id'] ?? '';
			$id2 = $id2 + rand(1,50);
			$connect = new mysqli(SERVERNAME, DB_LOGIN, DB_PASSWORD, DB_NAME);
			$sql = "INSERT INTO `user2` (`id`, `name`, `imageURL`, `price`) VALUES ('$id2','$name2', '$imageURL2', '$price2')";
			$connect->query($sql);
			$connect->close();
			header("Location:http://localhost/php/index.php");
		}

			// Удаляем карточки по ID
		if(isset($_POST['delete'])){
			$id5= $_POST['id2'];
			$connect = new mysqli(SERVERNAME, DB_LOGIN, DB_PASSWORD, DB_NAME);
			$sql = "DELETE FROM `user2` WHERE `id`='$id5'";
			$connect->query($sql);
			$connect->close();
			header("Location:http://localhost/php/index.php");
		}
			// Изменить данные во 2 таблице.
		if(isset($_POST['edit'])){
			$name = $_POST['name'] ?? '';
			$price = $_POST['price'] ?? '';
			$id4 = $_POST['id2'];
			$connect = new mysqli(SERVERNAME, DB_LOGIN, DB_PASSWORD, DB_NAME);
			$sql = "UPDATE `user2` SET `name`='$name', `price`='$price' WHERE `id`='$id4'";
			$connect->query($sql);
			$connect->close();
			header("Location:http://localhost/php/index.php");
		}

		?> 
		<h1>Лучшие чебуреки Ростова</h1>

				<!-- отрисовываем карточки из 1 таблицы -->
		<div class="container">
			<p class="p">Таблица user 1</p>
			<?php
				foreach($user as $k=>$v){
			 ?>
				<form action="#" method="POST" id="cheburek-<?php echo $v['id'] ?>";>
					<div class="card">
						<input type="hidden" name="image" value="<?php echo "$v[imageURL]" ?>">
							<img class='image' src='<?php echo "$v[imageURL]" ?>'/>
						<input type="hidden" name="name" value="<?php echo "$v[name]" ?>">
							<p><?php echo "$v[name]" ?></p>
						<input type="hidden" name="price" value="<?php echo "$v[price]" ?>">
							<p><?php echo "$v[price]" ?></p>
						<input type="hidden" name="id" value="<?php echo "$v[id]" ?>">
						<input type="submit" value="добавить в 2 таблицу" name="add" form="cheburek-<?php echo $v['id'] ?>">
					</div>
				</form>
			 <?php
				}
			 ?>
		</div>

				<!-- отрисовываем карточки из 2 таблицы -->
		<div class="container">
			<p class="p">Таблица user 2</p>
			<?php 
				foreach($user2 as $k=>$v){
			 ?>
				<div class="card">
					<form action="#" method="POST" id="chebyrek-<?php echo $v['id'] ?>"; >
						<img class='image' src='<?php echo "$v[imageURL]" ?>'/>
							<p><?php echo "$v[name]" ?></p>
						<input type="text" name="name" value="<?php echo "$v[name]" ?>">
							<p><?php echo "$v[price]" ?></p>	
						<input type="number" name="price" value="<?php echo "$v[price]" ?>">
						<div class="button">
							<input type="submit" value="удалить" name="delete">
							<input type="submit" value="изменить" name="edit" form="chebyrek-<?php echo $v['id'] ?>">
						</div>
						<input type="hidden" name="id2" value="<?php echo "$v[id]" ?>">
					</form>
					
				</div>
			 <?php
				}
			 ?>
		</div>
	</body>
</html>