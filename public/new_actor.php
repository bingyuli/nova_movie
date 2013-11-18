<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("actor_name", "gender");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("actor_name" => 20);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create
    $actor_name = mysql_prep($_POST["actor_name"]);
    $gender = $_POST["gender"];
    
    $query  = "INSERT INTO actor (";
    $query .= " name, gender";
    $query .= ") VALUES (";
    $query .= "  '{$actor_name}', '{$gender}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Actor added.";
      redirect_to("manage_actors.php");
    } else {
      // Failure
      $_SESSION["message"] = "Actor addition failed.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="hlinks">
   <a href="manage_actors.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2><br></br>Add New Acotr</h2>
    <form action="new_actor.php" method="post">	     
      <p>Actor name<br></br>
        <input type="text" name="actor_name" value="" />
      </p>
      <p>Gender <br></br>
	      <input type="text" name="gender" value="" />
	  </p>
      
      <input type="submit" name="submit" value="Add Actor" class= "blue"/>
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>