<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
//for the session
if(!isset($_SESSION['adminname'])){
  echo "<script> window.location.href='".ADMINURL."/admins/login-admins.php' </script> "; //is user not set we go back to the hotel page
  
 }


 $hotels = $conn->query("SELECT * FROM hotels");
 $hotels->execute();

 $allHotels = $hotels->fetchAll(PDO::FETCH_OBJ);



 //for the form submission
 if(isset($_POST['submit'])){ //if the user clicked on the register button that is named submit

	//we need to validate the entered data inside the field
	if(empty($_POST['name']) OR empty($_POST['price']) OR empty($_POST['num_persons'])
  OR empty($_POST['num_beds']) OR empty($_POST['size']) OR empty($_POST['view']) OR empty($_POST['hotel_name']) OR empty($_POST['hotel_id'])){

		echo "<script> alert('one or more inputs are empty') </script>"; //if not valid display an alert
	}else{
		//if valid save the info submited by the form
		
		$name = $_POST['name'];
		$price = $_POST['price'];
		$num_persons =$_POST['num_persons'];
    $num_beds =$_POST['num_beds'];
    $size =$_POST['size'];
    $view=$_POST['view'];
    $hotel_name =$_POST['hotel_name'];
    $hotel_id =$_POST['hotel_id'];
    $image = $_FILES['image']['name'];
    

    //when grabbing the image we will put it inside a folder created inside hotels-admins
    //so we tell it to which folder or directory it should go
    $dir = "room_images/" . basename($image);


		$insert = $conn->prepare("INSERT INTO rooms(name, price, num_persons, num_beds, size, view, hotel_name, hotel_id, image)
		VALUES(:name, :price, :num_persons, :num_beds, :size, :view, :hotel_name, :hotel_id, :image)");

		$insert->execute([
			":name" => $name,
			":price" => $price,
			":num_persons" => $num_persons,
      ":num_beds" => $num_beds,
      ":size" => $size,
			":view" => $view,
			":hotel_name" => $hotel_name,
      ":hotel_id" => $hotel_id,
      ":image" => $image,
	
		]);

    if(move_uploaded_file($_FILES['image']['tmp_name'], $dir)){

      header("location: show-rooms.php");

    }


	} 
}

?>

       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Rooms</h5>
          <form method="POST" action="create-rooms.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>
                <div class="form-outline mb-4 mt-4">
                  <input type="file" name="image" id="form2Example1" class="form-control" />
                 
                </div>  
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="price" id="form2Example1" class="form-control" placeholder="price" />
                 
                </div> 
                 <div class="form-outline mb-4 mt-4">
                  <input type="text" name="num_persons" id="form2Example1" class="form-control" placeholder="num_persons" />
                 
                </div> 
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="num_beds" id="form2Example1" class="form-control" placeholder="num_beds" />
                 
                </div> 
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="size" id="form2Example1" class="form-control" placeholder="size" />
                 
                </div> 
               <div class="form-outline mb-4 mt-4">
                <input type="text" name="view" id="form2Example1" class="form-control" placeholder="view" />
               
               </div> 
               <select name="hotel_name" class="form-control">
                <option>Choose Hotel Name</option>
                <?php foreach($allHotels as $hotels) : ?>
                <option value="<?php echo $hotels->name; ?>" ><?php echo $hotels->name; ?></option>
                <?php endforeach; ?>
               </select>
               <br>
   
               <select name="hotel_id" class="form-control">
                <option>Choose Same Hotel ID</option>
                <?php foreach($allHotels as $hotels) : ?>
                <option value="<?php echo $hotels->id; ?>"><?php echo $hotels->name; ?></option>
                <?php endforeach; ?>
               </select>
               <br>

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
      <?php require "../layouts/footer.php"; ?>
