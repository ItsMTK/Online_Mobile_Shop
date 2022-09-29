<?php 

	defined("PRODUCT_PAGE_CONTENT") or define("PRODUCT_PAGE_CONTENT" ,  '

<?php 

	require_once app\Router::$main_obj->getViewPath("HTML") . DS . "view_config.php";
?>


<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">
	<title><?echo $_SESSION["product_name"]?></title>
	<meta name="viewport" value="width = device-width , initial-scale = 1.0">

	<link rel="stylesheet" type="text/css" href="<? echo get_path("LIB"  , "/bootstrap/css/bootstrap.min.css"); ?>">

	<link rel="stylesheet" type="text/css" href="<? echo get_path("CSS" , "/product_style.css"); ?>">


</head>

<body>

	<div class="container">

		<div class="align-items-center product_section text-lg-start text-center row">
				
				<div class="col-md">
					<img src="<? echo get_path("HTML" , "/products/" . $_GET["product_id"] . "/product_pic.png"); ?>" alt="product_img" class="img-fluid product_img rounded-3 m-lg-0 m-3">
				</div>
	
				<div class="col-md lead product_body">
					
					<p class="text-warning"><?echo $_SESSION["product_msg"]?></p>

					<h1><? echo $router->get_renderHTML()[0]["product_name"] ?></h1>
					
					<p><? echo $router->get_renderHTML()[0]["product_description"] ?></p>

					<p>Price: <? echo $_SESSION["price"] ?>$</p>

					<p>Amount: <? echo $_SESSION["count"]?></p>

					<p>Contant with seller: <? echo $_SESSION["seller_email"]?></p>

					<form method="post" action="/products/buy">
						
						<div class="form-group">
							
							<label>Amount: </label>
							<input type="number" name="amount" class="input_number" value="0">

						</div>

						<?

						if($router->get_renderHTML()[0]["count"] > 0)

							echo "

							<input type='."'submit'".' name='. "'buy'" . 'value='."'Add to the card'". 'class='."'bg-primary text-light border-0 rounded my-5 p-2'".'>

							";

						else

							echo "

							<input type='."'button'".' name='. "'buy'" . 'value='."'Sold out'".'class='."'bg-secondary text-light border-0 rounded my-5 p-2'".'>

							"
						
						?>

					</form>
	
				</div>
	
	
		</div>

	</div>

	<section class="comments">
		
		<div class="container">
		
			<h2>Comments</h2>

			<form method="post" action="/products/comments" class="my-3">
				
				<div class="form-group">

					<div class="input-group my-3">
						
						<textarea class="form-control" name="comment" placeholder="Enter your Comment.."></textarea>

					</div>

					<input type="submit" name="publish" value="publish" class="bg-primary rounded-3 text-light border-0 p-2">

				</div>


			</form>	

			<div class="container my-5 comments-area">

			</div>


		</div>

	</section>


</body>

<script type="text/javascript" src="<? echo get_path("LIB" , "/bootstrap/js/bootstrap.min.js") ?>"></script>
<script type="text/javascript" src="<? echo get_path("LIB" , "/jquery.js") ?>"></script>


<script type="text/javascript">

	$.ajax({

		method: "GET" , 

		url : "<? $path = "/products/".$_GET["product_id"]."/comments.json" ; echo get_path("HTML" , $path); ?>", 

		dataType: "json"

	}).done(

	data => {

		for(let comment of data)

			$(".comments-area").append(

					`<div class="border-bottom-3 border-black">

						<h6 class="text-secondary">${comment.user}</h6>
					
						<p>${comment.text}</p>

					</div>`

				)


	})

</script>



</html>');

?>