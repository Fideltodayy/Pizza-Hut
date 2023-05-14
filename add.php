<?php 
    require("Config/db_connect.php");

    $title = $email = $ingredients = "";
    $errors = array("email" => "","title" => "","ingredients" => "");
    if (isset($_POST["submit"])) {
        // echo htmlspecialchars($_POST["email"]);  
        // echo htmlspecialchars( $_POST["title"]); 
        // echo htmlspecialchars($_POST["ingredients"]);
        
        //Check email
        if (empty($_POST["email"])) {
            $errors["email"] =  "<p>Please enter an email address.</p>";
        }else {
            $email = $_POST["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Your email should have an '@' and '.' symbol";
            }
        }

        //Check Title
        if (empty($_POST["title"])) {
            $errors["title"] =  "<p>Please enter a Pizza Name.</p>";
        }else {
            $title = $_POST["title"];
            if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
                $errors["title"] = "<p>Title must be letters and spaces only</p>";
            }
        }

        //Check ingredients
        if (empty($_POST["ingredients"])) {
            $errors["ingredients"] =  "<p>Please enter atleast one ingrdient</p>";
        }else {
            $ingredients = $_POST["ingredients"];
            if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
                $errors["ingredients"] = "<p>Ingredients must be separated by a comma </p>";
            }
        }
        //Redirecting the user with headers if form validation is satisfied
        if (array_filter($errors)) {
            echo "Errors in the form";
        }else {
            //We use this function to escape any malicious SQL characters to prevent us from SQL injections/attacks 
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $title = mysqli_real_escape_string($conn, $_POST["title"]);
            $ingredients = mysqli_real_escape_string($conn, $_POST["ingredients"]);
            
            //Create SQL statement to insert data into database
            $sql = "INSERT INTO pizza (email, title, ingredients) VALUES ('$email', '$title', '$ingredients')";

            //Execute the query & save to database and check
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                header("location: index.php");
                } else {
                    echo "Query Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            // echo "Valid forms";
            header("location: index.php");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
 
<?php require("Templates/header.php"); ?>  

<section class="container">
<form action="add.php" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Your email address</label>
    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email) ?>" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div><?php echo $errors["email"];?></div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Name of Pizza:</label>
    <input type="text" name="title"class="form-control" value="<?php echo htmlspecialchars($title) ?>" id="exampleInputPassword1">
    <div><?php echo $errors["title"];?></div>
</div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Ingredients (Separate ingredients with a comma):</label>
    <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>" class="form-control" id="exampleInputPassword1">
    <div><?php echo $errors["ingredients"];?></div>
</div>
  <!-- <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div> -->
  <input type="submit" name="submit" class="btn btn-primary"></input>
</form>
</section>

<?php require("Templates/footer.php");?>

</html>