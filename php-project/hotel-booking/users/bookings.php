<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

//grabbing the data

if(isset($_GET['id'])){
  $id = $_GET['id'];

  if($_SESSION['id'] != $id ){//so that other users cant view the booking of eachothers

		echo "<script> window.location.href='".APPURL."' </script> ";
	} 

  $bookings = $conn->query("SELECT * FROM bookings WHERE user_id='$id'");
  $bookings->execute();

  $allBookings = $bookings->fetchAll(PDO :: FETCH_OBJ);

}else{
  echo "<script> window.location.href='".APPURL."/404.php' </script> ";
}

?>

<div class= "container">

<?php if(count($allBookings) > 0) : //will count the nb of elements in array ?> 
<table class="table mt-5">
  <thead>
    <tr>
      <th scope="col">check_in</th>
      <th scope="col">check_out</th>
      <th scope="col">email</th>
      <th scope="col">phone_number</th>
      <th scope="col">full_name</th>
      <th scope="col">hotel_name</th>
      <th scope="col">room_name</th>
      <th scope="col">status</th>
      <th scope="col">payment</th>
      <th scope="col">created_at</th>    
    </tr>

    
  </thead>

  <tbody>

    <?php foreach($allBookings as $booking) : ?>

    <tr>
      <th scope="row"><?php echo $booking->check_in ?></th>
      <td><?php echo $booking->check_out ?></td>
      <td><?php echo $booking->email ?></td>
      <td><?php echo $booking->phone_number ?></td>
      <td><?php echo $booking->full_name ?></td>
      <td><?php echo $booking->hotel_name ?></td>
      <td><?php echo $booking->room_name ?></td>
      <td><?php echo $booking->status ?></td>
      <td><?php echo $booking->payment ?></td>
      <td><?php echo $booking->created_at ?></td>
    </tr>   

    <?php endforeach ?>
  </tbody>
</table>
<?php else : ?>
  <div class="alert alert-primary" role="alert">
  You have not made any bookings just yet 
</div>

<?php endif; ?>

    </div>
<?php require "../includes/footer.php"; ?>


