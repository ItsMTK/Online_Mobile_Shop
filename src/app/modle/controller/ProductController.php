<?php

	namespace app\modle\controller;

	/**
	 * 
	 * 	Product: has all props and methods to add , search on products
	 * 
	 */

	class ProductController
	{

		public function show_products()
		
		{
			config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

			);

			$command = "select  product_id , product_name , product_description from products_table";

			$query = config\Main::db_fetch($command , []);

			return array("HTML_PROPS" => $query);

		}

		public function search_product($product_name)
		
		{


			config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

			);


			if($product_name)
				$command = "select product_id , product_name , product_description from products_table where product_name like '%".$product_name."%'";

			else
				return array("HTML_PROPS" => []);

			$query = config\Main::db_fetch($command , [$product_name]);

			return array("HTML_PROPS" => $query);

		}


		public function make_comment($comment)
		
		{
			return ["ACTION" => "SHOW_COMMENTS" , "ARGS" => [ $_SESSION['user_name'] , $comment]];

		}


		public function select_product($product_id)

		{

			config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

			);

			$command = "select * from products_table join users_table on products_table.user_id = users_table.user_id where product_id = :product_id;";

			$query = config\Main::db_fetch($command , ["product_id" => $product_id]);

			$_SESSION['product_id'] 	= $query[0]["product_id"];

			$_SESSION['product_name'] 	= $query[0]["product_name"];

			$_SESSION['count']			= $query[0]["count"];

			$_SESSION['price']			= $query[0]["price"];

			$_SESSION['seller_id']		= $query[0]["user_id"];

			$_SESSION['seller_email']	= $query[0]["username"];

			return array("HTML_PROPS" => $query);
		}


		public function add_product(
		
			$product_name , 

			$product_price , 
	
			$product_amount , 
	
			$product_description
			
		
		)

		{

			if(!$_SESSION['logged'])
			{
				$_SESSION['add_product_msg'] = "you have to be logged before!!";
				return [];
			}


			config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

			);	

			$command = "insert into products_table 
							(
								product_name , 
								product_description , 
								count , 
								price , 
								user_id

							) values (

								:product_name , 
								:product_description , 
								:product_count , 
								:product_price , 
								:user_id
							)";

			config\Main::db_execute($command , [

					"product_name" => $product_name , 
					"product_description" => $product_description , 
					"product_count" => $product_amount , 
					"product_price" => $product_price , 
					"user_id" => $_SESSION['user_id']
				]);

			$_SESSION['add_product_msg'] = "Product added successfully!!";

			$command = "select product_id from products_table order by product_id desc limit 1";

			$product_id = config\Main::db_fetch($command , [])[0];

			$user_email = "select username from users_talbe where user_id = " . $_SESSION['user_id'];

			return array("ACTION" => "CREATE_PRODUCT" , "ARGS" 	=> 	$product_id); 
				

		}

		public function buy($amount)

		{

			if($_SESSION['logged'])
			{
				config\Main::db_connect(

				config\Main::getDbConfig("DMS") , 

				config\Main::getDbConfig("HOST") , 

				config\Main::getDbConfig("PORT") , 

				config\Main::getDbConfig("DB_NAME") , 

				config\Main::getDbConfig("DB_USER") , 

				config\Main::getDbConfig("DB_PASS")

				);


				if($_SESSION['count'] - $amount >= 0)
				{


					$search_command = "select * from records_table where user_id = :user_id and product_id = :product_id";

					$query = config\Main::db_fetch($search_command , ["user_id" => $_SESSION['user_id'] , "product_id" => $_SESSION['product_id']]);

					if(count($query))
					{
						$_SESSION['product_msg'] = "you added this item to your card before!!";
						return[];
					}


					$insert_command = "insert into records_table (user_id , product_id , amount) values (:user_id , :product_id , :amount)";


					config\Main::db_execute($insert_command , ["user_id" => $_SESSION['user_id']  , "product_id" => $_SESSION['product_id'] , "amount" => $amount]);

					$dec_command = "update products_table set count = count - :amount where product_id = 	:product_id";

					config\Main::db_execute($dec_command , ["product_id" => $_SESSION['product_id'] , "amount" => $amount]);

				}

				else
				{
					$_SESSION['product_msg'] = "items number is not enough!!";
					return [];

				}
				


				return [];				
			}
	
			else 
			{	
				$_SESSION["login_msg"] = "You have to be logged first!!";

				return ["ACTION" => "REDIRECT" , "ARGS" => ["POST" , "/login"]];
			}
		}
		
	}

?>