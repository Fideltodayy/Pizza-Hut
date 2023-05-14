<?php

    require("Config/db_connect.php");
    // On dubmit of delete button
    if (isset($_POST['delete'])) {
        //We get the actual id from the input field and avoid malicious code 
        $id_to_delete = mysqli_real_escape_string($conn,$_POST['id_to_delete']);

        //Sql statement to delete
        $sql = "DELETE FROM pizza WHERE id = $id_to_delete";

        //Make query and check if successfully done
        if (mysqli_query($conn, $sql)) {
            // if success, display success message
            echo "<script>alert('Pizza Deleted Successfully')</script>";
            // Redirect to display page
            header('Location: index.php');
            } else {
                // if failed, display error message
                echo "Query error: " . mysqli_error($conn);
                // Redirect to display page
                header('Location: pizza.php');
                }

    }

    //Check if we have GET data by checking request id param
    if (isset($_GET['id'])) {
        //Get id from GET data and escaping any sensitive data
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        //make SQL statement
        $sql = "SELECT * FROM pizza WHERE id = $id";

        //get query result
        $result = mysqli_query($conn, $sql);

        //Fetch result in array format
        $pizza = mysqli_fetch_assoc($result);

        //free the result
        mysqli_free_result($result);

        //Close the connection
        mysqli_close($conn);

        //print_r($pizza);
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php require("Templates/header.php"); ?>  
    <!-- Using bootstrap create a template for the details of the pizza -->
    <div class="container">
        <?php if($pizza): ?>

            <h4> <?php echo htmlspecialchars($pizza["title"]); ?> </h4>
            <p>Created By: <?php echo htmlspecialchars($pizza["email"]); ?> </P>
            <p>Created On: <?php echo date($pizza["created-on"]); ?> </P>
            <h5>
                Ingredients:
            </h5>
            <p> <?php echo htmlspecialchars($pizza["ingredients"]); ?> </p>
            
            <!-- Delete form -->
            <form action="details.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo htmlspecialchars($pizza["id"]); ?>">
                <!-- Submit button to delete -->
                <input type="submit" name="delete" value="Delete" class="btn btn-danger">

            </form>

        <?php else: ?>

            <h5>No such pizza exists</h5>

        <?php endif; ?>
                
    </div>

    <?php require("Templates/footer.php");?>


</html>