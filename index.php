<?php 

    require("Config/db_connect.php");

    //Write query for retreiving all pizzas
    $sql = "SELECT title,ingredients,id FROM pizza";

    //Making the query and getting the result
    $result = mysqli_query($conn, $sql);

    //check if the query is successful
    if (!$result) {
        echo "Error in SQL query: " . mysqli_error($conn);
        }else {
            //Fetch the resulting row as an array
            $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

            //Freee the result from memory
            mysqli_free_result($result);

            //Close the connection
            mysqli_close($conn);

            //reading an associative array in php
            // print_r($pizzas);
        }
?>

<!DOCTYPE html>
<html lang="en">
 
<?php require("Templates/header.php"); ?>  

<h4 class="align-cenetr">
    Pizzas
</h4>

<div class="container">
    <div class="row">
        <?php foreach($pizzas as $pizza): ?>
            <div class="col-md-4 col-sm-6">
                <div class="card">
                    <img class="pizza" src="Images/images.jpg">
                    <div class="card-body center">
                        <h5 class="card-title"><?php echo htmlspecialchars($pizza["title"]); ?><h5>
                        <div>
                            <ul>
                            <?php foreach(explode(",", $pizza["ingredients"]) as $ingred): ?> 
                                <li>
                                    <?php echo htmlspecialchars($ingred); ?>
                                </li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    </div>  
                    <div class="card-footer">
                        <!-- We send along the info to allow us to get info about the individual pizza -->
                        <a href="details.php?id=<?php echo htmlspecialchars($pizza["id"]); ?>" class="btn btn-primary">View more info </a>
                    </div>
                </div>
            </div>

        <?php endforeach ?>

    </div>
</div>

<?php require("Templates/footer.php");?>

</html>