<?php 

  include('config/db_connect.php');
  $email = $title = $ingredients = '';
  $errors  = ['email' => '', 'title' => '', 'ingredients' => ''];
  if(isset($_POST['submit'])):
    // Check Email
    if(empty($_POST['email'])):
      $errors['email'] = 'An Email Is Required';
    else:
      $email = $_POST['email'];
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        $errors['email'] = 'email must be a valid email address';
      endif;
    endif;
    // Check Title
    if(empty($_POST['title'])):
      $errors['title'] = 'A Title Is Required';
    else:
      $title = $_POST['title'];
      if(!preg_match('/^[a-zA-Z\s]+$/', $title)):
        $errors['title'] = 'Title Must Be Letters And Spaces';
      endif;
    endif;
    // Check Ingredients
    if(empty($_POST['ingredients'])):
      $errors['ingredients'] = 'A Least One Ingredients required';
    else:
      $ingredients = $_POST['ingredients'];
      if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]+)*$/', $ingredients)):
        $errors['ingredients'] = 'Ingredients Must Be A Comma Separated List';
      endif;
    endif;
    if(array_filter($errors)):
    else:
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $title = mysqli_real_escape_string($connection, $_POST['title']);
      $ingredients = mysqli_real_escape_string($connection, $_POST['ingredients']);
      // write create sql query
      $sql = "INSERT INTO pizzas(email, title, ingredients) VALUES ('$email', '$title', '$ingredients')";
      // make query 
      if(mysqli_query($connection, $sql)):
        // success
        header('Location: index.php');
      else:
        // errors
        echo 'query error ' . mysqli_error($connection);
      endif;
    endif;
  endif;

?>

<!DOCTYPE html>
<html lang="en">

  <?php include('templates/header.php'); ?>

  <section class='container grey-text'>
  <h4 class='center'>Add a Pizza</h4>
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST' class='white'>
    <!-- Email Input -->
    <label>Your Email:</label>
    <input type="text" name='email' value="<?php echo htmlspecialchars($email); ?>">
    <div class="red-text"><?php echo $errors['email']; ?></div>
    <!-- Title Input -->
    <label>Pizza Title:</label>
    <input type="text" name='title' value="<?php echo htmlspecialchars($title); ?>">
    <div class="red-text"><?php echo $errors['title']; ?></div>
    <!-- Ingredients Input -->
    <label>Ingredients (comma separated):</label>
    <input type="text" name='ingredients' value="<?php echo htmlspecialchars($ingredients); ?>">
    <div class="red-text"><?php echo $errors['ingredients']; ?></div>
    
    <div class='center'>
      <input type="submit" name='submit' value='submit' class='btn brand z-depth-0'>
    </div>
  </form>
</section>

  <?php include 'templates/footer.php'; ?>

</html>