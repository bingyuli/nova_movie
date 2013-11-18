<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $actor = find_actor_by_id($_GET["id"]);  
  if (!$actor) {
    // actor ID was missing or invalid or 
    // actor couldn't be found in database
    redirect_to("manage_actors.php");
  }
?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("actor_name","gender");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("actor_name" =>30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $id = $actor["id"];
    $actor_name = mysql_prep($_POST["actor_name"]);
    $gender = $_POST["gender"];

    $query  = "UPDATE actor SET ";
    $query .= "name = '{$actor_name}', ";
    $query .= "gender = '{$gender}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "actor updated.";
      redirect_to("manage_actors.php");
    } else {
      // Failure
      $_SESSION["message"] = "actor update failed.";
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
    
    <h2>Edit actor: <?php echo htmlentities($actor["name"]); ?></h2>
    <form action="edit_actor.php?id=<?php echo urlencode($actor["id"]); ?>" method="post">

      <p>Actor Name: <br></br>
        <input type="text" name="actor_name" value="<?php echo htmlentities($actor["name"]); ?>" />
      </p>

      <p>Gender:
        <input type="radio" name="gender" value = "male" 
		 <?php
	         if ($actor["gender"] =="male") {
	     ?>
	        checked="checked"
	        <?php } ?>	
        /> Male 

        <input type="radio" name="gender" value = "female"
		 <?php
	         if ($actor["gender"] =="female") {
	     ?>
	        checked="checked"
	        <?php } ?>
        /> Female 
     </p>

      <input type="submit" name="submit" value="Edit actor" class="blue" />
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>