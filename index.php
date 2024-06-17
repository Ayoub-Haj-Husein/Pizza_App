<?php 

  include('config/db_connect.php');
  // write query for all pizzas
  $sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';
  // make query and get result
  $result = mysqli_query($connection, $sql); 
  // fetch the resultlting rows as an array
  $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);
  // free result from memory
  mysqli_free_result($result);
  // clos connection
  mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="en">
  <?php include('templates/header.php'); ?>
  <h4 class="center grey-text">Pizzas!</h4>
  <div class="container">
    <div class="row">
      <?php foreach($pizzas as $pizza): ?>
        <div class="col s6 md3">
          <div class="card z-depth-0">
            <img src="img/pizza.svg" alt="Pizza Picture" class='pizza'>
            <div class="card-content center">
              <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
              <ul>
                <?php foreach(explode(',', $pizza['ingredients']) as $ingredient): ?> 
                  <li><?php echo htmlspecialchars($ingredient); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="card-action right-align">
              <a class='brand-text' href="details.php?id=<?php echo ($pizza['id']) ?>">More Info</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php include 'templates/footer.php'; ?>
</html>
