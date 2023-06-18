<?php 
    namespace multi_tool;


    class MultiTool {
        static $db_host = "localhost";
        static $db_user = "root";
        static $db_password = "" ;
        static $db_name = "tz_notes" ;
        //define variables that will be used frequently

        static function read_db() {
            //name function - its meaning
            $conn = mysqli_connect(self::$db_host, self::$db_user,
                self::$db_password, self::$db_name) 
            or 
                die(); 

            $query = "SELECT * FROM notes ORDER BY id DESC";
            $db_request = mysqli_query($conn, $query);
            $result = mysqli_fetch_all($db_request);

            mysqli_close($conn);
            return $result;
        }

        static function delete_from_db($note_id){
            //name function - its meaning
            $conn = mysqli_connect(self::$db_host, self::$db_user,
                self::$db_password, self::$db_name) 
            or 
                die(); 

            $query = "DELETE FROM notes WHERE id=$note_id";
            mysqli_query($conn, $query);

            mysqli_close($conn);
        }

        static function add_to_db($title, $description){
            //name function - its meaning
            $conn = mysqli_connect(self::$db_host, self::$db_user,
                self::$db_password, self::$db_name) 
            or 
                die(); 
            
            $title = self::clear_data($title);
            $description = self::clear_data($description);

            $query = "INSERT INTO notes (title, description) 
                       VALUES ('$title','$description')";
            mysqli_query($conn, $query);
            
            mysqli_close($conn);
        }

        static function clear_data($data){
            //clearing data from forms
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;

        }
        static function containsHTMLTags($data) {
            //checking for html tags in forms
            $pattern = '/<[^>]*>/'; 
            return preg_match($pattern, $data);
        }
    }
?>
