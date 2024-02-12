<?php require "../includes/header.php"; //start the session at the head of our page, will start it in the header file?> 
<?php require "../config/config.php"; ?>

<?php

//we need to validate also, that if the user is logged in, he wont be able to access the login and register page

if(isset($_SESSION['username'])){
 echo "<script> window.location.href='".APPURL."' </script> "; //is user not set we go back to the hotel page
 //we use javascript
}


if(isset($_POST['submit'])){ 

	//we need to validate the entered data inside the field
	if(empty($_POST['email']) OR empty($_POST['password'])){

		echo "<script> alert('one or more inputs are empty') </script>"; //if not valid display an alert
	}else{

    $email = $_POST['email'];
    $password = $_POST['password'];

    //validate the email with th equery

    $login = $conn->query("SELECT * FROM users WHERE email = '$email'"); //this certain query returns a number, nb 1 since its only affecting one email
    $login->execute();

    $fetch = $login->fetch(PDO::FETCH_ASSOC);

    //get the row count

    if($login->rowCOUNT() > 0){ //to validate the email, where going to bring the query that we have and add to it the 
      //rowCount(), its goign to grab the nb of affected data, affected rows for a certain query, then if the user
      //entered the right email this is going to affect only one row, if it matches its going to grab a row 
      //if its one (>0), then 

      if(password_verify($password, $fetch['mypassword'])){
        //if they match, we create a session, so that we can carry info across pages
        

        //1.Creating our session variables
        $_SESSION['username'] = $fetch['username'];
        $_SESSION['id'] = $fetch['id'];

        echo "<script> window.location.href='".APPURL."' </script> ";

      }
      else{
        echo "<script> alert('email or password is wrong') </script>";
      }

    }else{
      echo "<script> alert('email or password is wrong') </script>";
    }

  }
}


  ?>
    <div class="hero-wrap js-fullheight" style="background-image: url('<?php echo APPURL;?>/images/image_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<!-- <h2 class="subheading">Welcome to Vacation Rental</h2>
          	<h1 class="mb-4">Rent an appartment for your vacation</h1>
            <p><a href="#" class="btn btn-primary">Learn more</a> <a href="#" class="btn btn-white">Contact us</a></p> -->
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
    	<div class="container">
	    	<div class="row justify-content-middle" style="margin-left: 397px;">
	    		<div class="col-md-6 mt-5">
						<form action="login.php" method="POST" class="appointment-form" style="margin-top: -568px;">
							<h3 class="mb-3">Login</h3>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
			    					    <input type="text" name="email"  class="form-control" placeholder="Email">
			    				    </div>
								</div>
                               
                                <div class="col-md-12">
									<div class="form-group">
			    					    <input type="password" name="password" class="form-control" placeholder="Password">
			    				    </div>
								</div>
								
							
							
								<div class="col-md-12">
                                    <div class="form-group">
                                        <input type="submit" name="submit" value="Login" class="btn btn-primary py-3 px-4">
                                    </div>
								</div>
							</div>
	    			</form>
	    		</div>
	    	</div>
	    </div>
    </section>

    <?php require "../includes/footer.php"; ?>