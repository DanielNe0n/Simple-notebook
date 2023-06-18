<?php 
    require 'multi_tool.php';
    use multi_tool\MultiTool;
    //use class with the necessary functions

    $notes = MultiTool::read_db();
    //static function receives data from the db

    $title_err = $description_err = " ";
    //variables if there are errors
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["title"]))){
            $title_err = "is required<br>";
            
        }elseif (preg_match('/\d/', $_POST["title"])) {
            $title_err = "title should not contain numbers<br>";
            
        }
        if (empty(trim($_POST["description"]))){
            $description_err = "is required<br>";
            
        }elseif (MultiTool::containsHTMLTags($_POST["description"])){
            $description_err = "description should not contain 
            html tags<br>";
        }
        if (!empty(trim($_POST["title"] &&
            !preg_match('/\d/', $_POST["title"]) &&
            !MultiTool::containsHTMLTags($_POST["description"]) &&
            !empty(trim($_POST["description"]))
            ))) {
                MultiTool::add_to_db($_POST["title"],
                                   $_POST["description"]
                                );
                header("Location: ".$_SERVER['PHP_SELF']);
                //refresh page after create new record
            }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
          crossorigin="anonymous">

    <title>Notes</title>
</head>
<body>
    <div class="container mt-5">
        <div class="form-block">
            <!---block with form---->
            <form 
              action="<?php 
                echo htmlspecialchars($_SERVER['PHP_SELF'])
                ?>"
              method="post" 
              class="d-flex flex-column 
              justify-content-center align-items-center w-100">

            <h2>Create notes</h2>
            <!---form title---->

            <div class="form-control  col-sm-6 text-center">
                <!---firt input ---->
                <label for="title">Title</label>
                  <?php echo "<br>
                                  <span class='text-danger'>
                                        $title_err
                                  </span>";
                  ?>
                <input type="text" class="form-control w-30" name="title"
                  placeholder="Enter title">
              </div>


            <div class="form-control col-sm-6 mt-2 pb-3 text-center">
                <!---second input ---->
			    <label for="description">Description</label>
			      <?php echo "<br>
                                  <span class='text-danger'>
                                        $description_err
                                  </span>";
                  ?>
			    <input type="text" class="form-control" name="description"
                  placeholder="Enter description">
		    </div>
            
            <input type="submit" class="btn border-danger mt-1" value="Add">  

            </form>
        </div>
        <div class="notes">
            <div class='row'>
            <?php 
                foreach ($notes as $key=>$note)
                echo "<div class='col-sm-6 mt-4 mb-5'>
                  <div class='card'>
                    <div class='card-body'>
                      <h5 class='card-title'>".$note[1]."</h5>
                      <p class='card-text'>".$note[2]."</p>
                      <form action='delete.php' method='post'>
                            <input type='hidden' name='note_id' 
                                   value=".$note[0].">
                            <input type='submit' class='btn-danger' 
                                   value='Delete'>
                        </form>
                    </div>
                  </div>
                </div>"
            ?>
        </div>
    </div>    
</body>
</html>