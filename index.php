<?php
// Where are we
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

$meme_image_dir = 'assets/memes/'; // Where are the images kept?
$json_file = 'assets/data.json'; // This is the file we will store the memes in

// Load the images in
$meme_images =glob(DOCROOT.$meme_image_dir.'*.jpg');

// Check for postage
$success = FALSE;
if ($_POST)
{
  // Add the pushed meme to the json
  $current_json = file_get_contents(DOCROOT.$json_file);
  $current_memes = json_decode($current_json, TRUE);

  // Put the new meme at the top
  array_unshift($current_memes, array(
    'image' => basename($_POST['memeimage']),
    'topText' => $_POST['topText'],
    'bottomText' => $_POST['bottomText']));

  // Save the json back out again
  file_put_contents(DOCROOT.$json_file, json_encode($current_memes));

  $success = TRUE;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Meme-berlater</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
  </head>

  <body>



    <!-- NAVBAR
    ================================================== -->
    <div class="navbar-wrapper">
      <!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
      <div class="container">

        <div class="navbar">
          <div class="navbar-inner">

            <a class="brand" href="#">1. Choose a picture</a>

          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->

      </div> <!-- /.container -->
    </div><!-- /.navbar-wrapper -->



    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">

<?php
// Echo the images in
$i = 0;
foreach ($meme_images as $image)
{
  $class= '';
  if ($i++ === 0)
  {
    $class = 'active';
  }
?>
        <div class="item <?php echo $class;?>">
          <img src="<?php echo $meme_image_dir.basename($image); ?>" alt="">
        </div>

<?php
}
?>

      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div><!-- /.carousel -->

    <?php if ($success) : ?>
  <div class="container">
    <div class="alert alert-success">
      <h4>Hooray!</h4> Your meme has been created. Have a look on the screen over there...
    </div>
  </div>
    <? endif; ?>



	<div id="formage" class="container">
		<form method="post">
		  <fieldset>
			<legend>2. Enter captions</legend>
			<label for="topText">Top caption</label>
			<input type="text" class="span12" name="topText" placeholder="This goes at the top of the image...">
			<label>Top caption</label>
			<input type="text" class="span12" name="bottomText" placeholder="This goes at the bottom of the image...">
      <input id="memeimage" type="hidden" name="memeimage" value="<?php echo basename($meme_images[0]); ?>" >
			<button type="submit" class="btn btn-block btn-info">MAKE IT</button>
		  </fieldset>
		</form>
	</div>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
      !function ($) {
        $(function(){
          // Carousel
          $('#myCarousel').carousel('pause');

          // Set the memeimage into the form
          $('#myCarousel').on('slide',function(e){
              $('#memeimage').val($(e.relatedTarget).children("img").attr("src"));
          });

        })
      }(window.jQuery)
    </script>
    <script src="assets/js/holder/holder.js"></script>
  </body>
</html>
