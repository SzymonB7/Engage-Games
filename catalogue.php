<?php
session_start();

//Include database connection
require_once('includes/db.inc.php');
//Include remember me login
require_once('includes/remember_cookie.inc.php');
//Include CSRFToken generator
require_once('includes/csrf_token.inc.php');
//Print function to avoid XSS
require_once('includes/xss.inc.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="The Official Page of Engage Games">
	<meta name="author" content="Szymon Bialkowski &amp; Shane Doyle">
	<link rel="icon" href="assets/img/favicon.ico">

	<title>Engage Catalogue</title>

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="assets/css/catalogue.css" rel="stylesheet">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,700" rel="stylesheet">

	<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <div id="loading"></div>

	<?php
		//Navbar
		require_once('includes/navbar.inc.php');
	?>

    <div class="main-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="catalogue">
						<form action="catalogue.php">
						  <div class="form-row">
						    <div class="col-auto sort">
						      <select onchange="this.form.submit()" name="q" class="custom-select mb-2 mr-sm-2 mb-sm-0 decorated" id="inlineFormCustomSelect">
                                  <?php
                                  // Check for sorting preference
                                  if (!empty($_GET['q'])) {

                                      if ($_GET['q'] == 'newest')
                                      { ?>
                                            <option value="">Random</option>
            						        <option selected="" value="newest">Newest</option>
            						        <option value="low-high">Price Low-High</option>
            						        <option value="high-low">Price High-Low</option>
                                      <?php
                                      }
                                      //Low to high sorting preference
                                      elseif ($_GET['q'] == 'low-high')
                                      { ?>
                                            <option value="">Random</option>
            						        <option value="newest">Newest</option>
            						        <option selected="" value="low-high">Price Low-High</option>
            						        <option value="high-low">Price High-Low</option>
                                      <?php
                                      }
                                      //High to low sorting preference
                                      elseif ($_GET['q'] == 'high-low')
                                      { ?>
                                            <option value="">Random</option>
            						        <option value="newest">Newest</option>
            						        <option selected="" value="low-high">Price Low-High</option>
            						        <option selected="" value="high-low">Price High-Low</option>
                                      <?php
                                      }
                                      //Invalid sorting preference, standard options
                                      else
                                      { ?>
                                            <option value="" selected="">Random</option>
            						        <option value="newest">Newest</option>
            						        <option value="low-high">Price Low-High</option>
            						        <option value="high-low">Price High-Low</option>
                                      <?php
                                      }
                                  }
                                  //No sorting preference, standard options
                                  else
                                  { ?>
                                    <option value="" selected="">Random</option>
      						        <option value="newest">Newest</option>
      						        <option value="low-high">Price Low-High</option>
      						        <option value="high-low">Price High-Low</option>
                                  <?php
                                  } ?>
						      </select>
						  	</div>
						  </div>
						</form>



                        <?php

                        // Check for sorting preference
                        if (!empty($_GET['q']))
                        {
                            //Newest games, sort by release date
                            if ($_GET['q'] == 'newest')
                            { ?>
                                <?php

                                    $result = mysqli_query($db, "SELECT game_id, title, console, price, cover_path from game order by -release_date limit 12");
                                    for ($i=0; $i < 12; $i++) {
                                        $row = mysqli_fetch_row($result);   ?>

                                        <div class="main-body-white-col">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <a href="game.php?q=<?php xss ($row[0]); ?>">
                                                            <img class="main-body-img" src="assets/img/games/<?php xss ($row[4]); ?>" alt="The cover for <?php xss ($row[1]); ?>">
                                                        </a>
                                                        <h3 class="text-black main-body-white-col-h3"><?php xss ($row[1]); ?></h3>
                                                        <p class="margin-0"><?php xss ($row[2]); ?></p>
                                                        <p class="main-body-white-col-p margin-0">€<?php xss ($row[3]); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        }//end of for loop
                                }//end of if
                            //Low to high sorting preference, games with lowest price
                            elseif ($_GET['q'] == 'low-high') { ?>
                                <?php

                                    $result = mysqli_query($db, "SELECT game_id, title, console, price, cover_path from game order by price limit 12");
                                    for ($i=0; $i < 12; $i++) {
                                        $row = mysqli_fetch_row($result);   ?>

                                        <div class="main-body-white-col">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <a href="game.php?q=<?php xss ($row[0]); ?>">
                                                            <img class="main-body-img" src="assets/img/games/<?php xss ($row[4]); ?>" alt="The cover for <?php xss ($row[1]); ?>">
                                                        </a>
                                                        <h3 class="text-black main-body-white-col-h3"><?php xss ($row[1]); ?></h3>
                                                        <p class="margin-0"><?php xss ($row[2]); ?></p>
                                                        <p class="main-body-white-col-p margin-0">€<?php xss ($row[3]); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        }//end of for loop
                                }//end of elseif
                            //High to low sorting preference, games with highest price
                            elseif ($_GET['q'] == 'high-low') { ?>
                            <?php

                                $result = mysqli_query($db, "SELECT game_id, title, console, price, cover_path from game order by -price limit 12");
                                for ($i=0; $i < 12; $i++)
                                {
                                    $row = mysqli_fetch_row($result);   ?>

                                    <div class="main-body-white-col">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="game.php?q=<?php xss ($row[0]); ?>">
                                                        <img class="main-body-img" src="assets/img/games/<?php xss ($row[4]); ?>" alt="The cover for <?php xss ($row[1]); ?>">
                                                    </a>
                                                    <h3 class="text-black main-body-white-col-h3"><?php xss ($row[1]); ?></h3>
                                                    <p class="margin-0"><?php xss ($row[2]); ?></p>
                                                    <p class="main-body-white-col-p margin-0">€<?php xss ($row[3]); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                    }//end of for loop
                                }//end of elseif
                                else {
                                    $result = mysqli_query($db, "SELECT game_id, title, console, price, cover_path from game order by RAND() limit 12");
                                    for ($i=0; $i < 12; $i++) {
                                        $row = mysqli_fetch_row($result);   ?>

                                        <div class="main-body-white-col">
                							<div class="container">
                								<div class="row">
                									<div class="col-sm-12">
                										<a href="game.php?q=<?php xss ($row[0]); ?>">
                											<img class="main-body-img" src="assets/img/games/<?php xss ($row[4]); ?>" alt="The cover for <?php xss ($row[1]); ?>">
                										</a>
                										<h3 class="text-black main-body-white-col-h3"><?php xss ($row[1]); ?></h3>
                										<p class="margin-0"><?php xss ($row[2]); ?></p>
                										<p class="main-body-white-col-p margin-0">€<?php xss ($row[3]); ?></p>
                									</div>
                								</div>
                							</div>
                						</div>

                                    <?php
                                        }//end of for loop
                                }//end of else
                            }//end of if
                        ////No sorting preference, random games
                        else
                        {
                            $result = mysqli_query($db, "SELECT game_id, title, console, price, cover_path from game order by RAND() limit 12");
                            for ($i=0; $i < 12; $i++)
                            {
                                $row = mysqli_fetch_row($result);   ?>

                                <div class="main-body-white-col">
        							<div class="container">
        								<div class="row">
        									<div class="col-sm-12">
        										<a href="game.php?q=<?php xss ($row[0]); ?>">
        											<img class="main-body-img" src="assets/img/games/<?php xss ($row[4]); ?>" alt="The cover for <?php xss ($row[1]); ?>">
        										</a>
        										<h3 class="text-black main-body-white-col-h3"><?php xss ($row[1]); ?></h3>
        										<p class="margin-0"><?php xss ($row[2]); ?></p>
        										<p class="main-body-white-col-p margin-0">€<?php xss ($row[3]); ?></p>
        									</div>
        								</div>
        							</div>
        						</div>

                            <?php
                            }
                         } ?>


                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
        //Print footer
        require_once('includes/footer.inc.php');
    ?>


    <!--  JQuery JavaScript     -->
	<script src="assets/js/jquery.min.js"></script>
    <!--  Bootstrap JavaScript  -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/custom.js"></script>
</body>
