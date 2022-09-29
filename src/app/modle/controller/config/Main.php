<?php 

	namespace app\modle\controller\config;


	class Main
	{


		private $main_path;
		
		private $app_path;

		static private $db_config;

		private static $pdo_obj;

		public function __construct()
		
		{

			$this->app_path = "app";

			$this->main_path = 

			[
	
				"ROUTER" => $this->app_path . DS . "Router.php" , 
	
				"CONTROLLER" => $this->app_path . DS . "modle" . DS . "controller" , 
	
				"VIEW" => $this->app_path . DS . "modle" . DS . "view"
	
			];

			$this->view_path = 

			[

				"HTML" => $this->main_path["VIEW"] . DS . "html" , 

				"CSS" => $this->main_path["VIEW"] . DS . "style" , 

				"SCRIPT" => $this->main_path["VIEW"] . DS . "script" , 

				"LIB" => $this->main_path["VIEW"] . DS . "lib" , 

				"PICTURES" => $this->main_path["VIEW"] . DS . "pictures" 

			];

			Main::$db_config = 

			[

				"HOST" => "localhost" 	, 

				"PORT" => "80"			,

				"DB_NAME"	=> "project" , 

				"DMS"		=> "mysql"  ,

				"DB_USER"	=> "root" 	,

				"DB_PASS"	=> ""		
			];


		}

		public function getPath($attr)
		
		{
			return $this->main_path[$attr];
		}

		public function getViewPath($attr)

		{
			return $this->view_path[$attr];
		}

		public function getDbConfig($attr)

		{
			return Main::$db_config[$attr];
		}


		/**
		 * 
		 * 	@param $DMS: string , 
		 * 
		 * 	@param $host: string , 
		 * 
		 * 	@param $port: integer , 
		 * 
		 * 	@param $db_name: string , 
		 * 
		 * 	@param $db_user: string , 
		 * 
		 * 	@param $db_pass: string 
		 * 
		 * */


		public static function db_connect($DMS , $host , $port , $db_name, $db_user , $db_pass)

		{

			try {


			$dsn = $DMS . ":" . "host=" . $host . ";dbname=" . $db_name .";port=" . $port; 


			Main::$pdo_obj = new \PDO($dsn , $db_user , $db_pass);

			}

			catch(Exception $exp)
			{
				die("Connection error: " . $exp);
			}

		}



		public static function db_execute($command , $placeholders)

		{

			try {

				Main::$pdo_obj->setAttribute(\ PDO::ATTR_ERRMODE , \ PDO::ERRMODE_EXCEPTION);

				$statement = Main::$pdo_obj->prepare($command);

				if(count($placeholders))

					$statement->execute($placeholders);

				else

					$statement->execute();


				return $statement;

			}

			catch(Exception $exp)
			{
				die("Execution error: " . $exp);
			}

		}

		public static function db_fetch($command , $placeholders)
		{
			try{

				Main::$pdo_obj->setAttribute(\ PDO::ATTR_ERRMODE , \ PDO::ERRMODE_EXCEPTION);

				$statement = Main::db_execute($command , $placeholders);

				$res = $statement->fetchAll();

				return $res;

			}

			catch(Exception $exp)
			{
				die("Execution error: " . $exp);
			}
		}


	}



?>