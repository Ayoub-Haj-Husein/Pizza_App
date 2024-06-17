<?php 

  include('config/db_connect.php');
  // check GET request id param
  if(isset($_GET['id'])):
    $id = mysqli_real_escape_string($connection, $_GET['id']);
    // write query sql for fetch record
    $sql = "SELECT * FROM pizzas WHERE id = $id";
    // get the query result 
    $result = mysqli_query($connection, $sql);
    // fetch result in array format
    $pizza = mysqli_fetch_assoc($result);
    // free result from memory
    mysqli_free_result($result);
    // close connection
    mysqli_close($connection);
  endif;

  // Delete Pizza From DB
  if(isset($_POST['delete'])):
    $id_to_delete = mysqli_real_escape_string($connection, $_POST['id_to_delete']);
    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";
    if(mysqli_query($connection, $sql)):
      // Success
      mysqli_close($connection);
      header('Location: index.php');
    else:
      echo 'Error Query ' . mysqli_error($connection);
    endif;
  endif;
?>

<!DOCTYPE html>
<html lang="en">
  <?php include('templates/header.php'); ?>
  <div class="container center grey-text">
    <?php if($pizza): ?>
      <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
      <p>Created By: <?php echo htmlspecialchars($pizza['email']); ?></p>
      <p><?php echo $pizza['created_at']; ?></p>
      <h5>Ingredients:</h5>
      <ul>
        <?php foreach(explode(',', $pizza['ingredients']) as $ingredient): ?>
          <li><?php echo htmlspecialchars($ingredient); ?></li>
        <?php endforeach; ?>
      </ul>
      <form action="details.php" method='POST'>
        <input type="hidden" name='id_to_delete' value='<?php echo $pizza['id']; ?>'>
        <input type="submit" name='delete' value='Delete' class='btn brand z-depth-0'>
      </form>
    <?php else: ?>
      <h5>No Such Pizza Exists!</h5>
    <?php endif; ?> 
  </div>
  <?php include('templates/footer.php'); ?>
</html>

