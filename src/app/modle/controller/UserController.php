<?php 

	namespace app\modle\controller;

	/**
	 * 
	 * User
	 * 
	 */

	class UserController
	{

		public function login($username , $password)
		{
			config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

			);

			$command = "select * from users_table where username=:username;";

			$result = config\Main::db_fetch($command , ["username" => $username]);


			if($result)
			{

				if($result[0]["password"] === $password)
				{

					$_SESSION['user_id'] = $result[0]["user_id"];

					$_SESSION['user_name'] = $result[0]["username"];

					$_SESSION['logged'] = true;

					$_SESSION['login_msg'] = "Login successfully!!";

				}



				else
					 $_SESSION['login_msg'] = "wrong password";

			}

			else
				$_SESSION['login_msg'] = "no user has this email!";


			return [];

		}

		public function create_user($username , $password)
		{

			config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

			);	


			$command = "select user_id from users_table where username=:username";

			$result = config\Main::db_fetch($command , ["username" => $username]);


			if($result)
			{
				$_SESSION["new_user_msg"] = "This account has created before";
				return [];
			}
			

			$command = "insert into users_table (username , password) values (:username , :password)";

			$result = config\Main::db_execute($command , ["username" => $username , "password" => $password]);

			$_SESSION["new_user_msg"] = "Account has created successfully!!";


			return [];

		}

		public function show_cart()
		{
			config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

			);

			$command = "select username , product_name , records_table.product_id , price , amount from users_table join products_table on products_table.user_id = users_table.user_id join records_table on records_table.product_id = products_table.product_id where records_table.user_id = :user_id;";

			$query = config\Main::db_fetch($command , ["user_id" => $_SESSION['user_id']]);

			$total = 0;

			foreach ($query as $record)

				$total += floatval($record["price"]) * $record["amount"];

			return ["HTML_PROPS" => ["query" => $query , "total" => $total]];
		}

		public function drop_product($product_id , $user_id)
		
		{

			config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

			);

			$getAmount_command = "select amount from records_table where user_id = :user_id and product_id = :product_id";

			$delete_command = "delete from records_table where user_id = :user_id and product_id = :product_id";

			$return_command = "update products_table set count = count + :amount where product_id = :product_id";

			$amount = config\Main::db_fetch($getAmount_command , ["user_id" => $user_id , "product_id" => $product_id])[0]["amount"];


			config\Main::db_execute($delete_command , ["user_id" => $user_id , "product_id" => $product_id]);			

			config\Main::db_execute($return_command  , ["product_id" => $product_id , "amount" => $amount]);


			return ["ACTION" => "REDIRECT" , "ARGS" => ["GET" , "/account"]];

		}

	}


?>