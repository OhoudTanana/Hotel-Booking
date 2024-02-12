<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php
//for the session
if(!isset($_SESSION['adminname'])){
  echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php' </script> "; //is user not set we go back to the hotel page
  
 }

 //for the form submission
 if(isset($_POST['submit'])){ //if the user clicked on the register button that is named submit

	//we need to validate the entered data inside the field
	if(empty($_POST['name']) OR empty($_POST['description']) OR empty($_POST['location'])){

		echo "<script> alert('one or more inputs are empty') </script>"; //if not valid display an alert
	}else{
		//if valid save the info submited by the form
		
		$name = $_POST['name'];
		$description = $_POST['description'];
		$location =$_POST['location'];
    $image = $_FILES['image']['name'];

    //when grabbing the image we will put it inside a folder created inside hotels-admins
    //so we tell it to which folder or directory it should go
    $dir = "hotel_images/" . basename($image);


		$insert = $conn->prepare("INSERT INTO hotels(name, description, location, image)
		VALUES(:name, :description, :location, :image)");

		$insert->execute([
			":name" => $name,
			":description" => $description,
			":location" => $location,
      ":image" => $image,
    
		]);

    if(move_uploaded_file($_FILES['image']['tmp_name'], $dir)){

      header("location: show-hotels.php");

    }


	} 
}

?>

       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Hotels</h5>
          <form method="POST" action="create-hotels.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>

                <div class="form-outline mb-4 mt-4">
                  <input type="file" name="image" id="form2Example1" class="form-control"/>
                 
                </div>

                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Description</label>
                  <textarea name="description" class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>

                <div class="form-outline mb-4 mt-4">
                  <label for="exampleFormControlTextarea1">Location</label>

                  <input type="text" name="location" id="form2Example1" class="form-control"/>
                 
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>

          <?php require "../layouts/footer.php"; ?>
