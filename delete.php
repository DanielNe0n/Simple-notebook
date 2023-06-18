<?php 
    require 'multi_tool.php';
    use multi_tool\MultiTool;
    //use class with the necessary functions
    
    if (!empty($_POST["note_id"])){
        MultiTool::delete_from_db($_POST["note_id"]);
        //check if the id is not empty and delete    
    }
?>

<meta http-equiv="refresh" content="0; url=base.php">
<!-- redirect to main page -->