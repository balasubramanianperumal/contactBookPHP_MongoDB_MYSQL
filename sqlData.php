<html>
    <title>SQL</title>
    <body style="display:flex;flex-direction:column;border:2px solid black;padding:8px;" class="body">
    <?php
        function connectionEstablish(){
            $servername = "localhost";
            $username="bala";
            $password="z()@plcs4Inb-cFN";
            $ccon= mysqli_connect($servername,$username,$password);

            if(!$ccon){
                die("Connection Failed:" . mysqli_connect_error());
            }
            else{
                    echo "<div style='color:green;background-color:yellow;width:11%;padding:8px;'>Connection Established</div>";
            }
            return $ccon;
        }    
        function createDB($db){
            $createQuery = "CREATE DATABASE phonedb";
            if($db->query($createQuery)==True){
                echo "Database created successfully";
            }
            else{
                echo "Error creating Datasbase:". $db->error;
            }
            $ccon->close();
        }
        function createTablePhoneBook($db){
            $database = "USE phonedb";
            if($db->query($database)){
                $createTableQuery = "CREATE TABLE phoneBook(name VARCHAR(30),phonenumber BIGINT(15))";
                if($db->query($createTableQuery)==True){
                    echo "Database created successfully";
                }
                else{
                    echo "Error creating Table in phoneDB:". $db->error;
                }
            }
            else{
                echo "Error creating Table in phoneDB:". $db->error;
            }
            // $db->close();
        }
        function insertIntoDB($db,$name,$phoneNumber){
            $database = "USE phonedb";
            if($db->query($database)){
                $createTableQuery = "INSERT INTO phoneBook VALUES('{$name}',{$phoneNumber})";
                if($db->query($createTableQuery)==True){
                    echo "Record inserted successfully";
                }
                else{
                    echo "Error in inserting in phoneDB:". $db->error;
                }
            }
            else{
                echo "Error connection to Table in phoneDB:". $db->error;
            }
            // $db->close();
        }
        function updateData($db,$name,$phoneNumber){
            $database = "USE phonedb";
            if($db->query($database)){
                $createTableQuery = "UPDATE PHONEBOOK SET PHONENUMBER={$phoneNumber} WHERE NAME='{$name}'";
                $result = $db->query($createTableQuery);
                if($result == True){
                    echo "<p>{$name} " . "phone number has been updated to " . "{$phoneNumber}</p>";
                }  
                else{
                    echo "Error in inserting in phoneDB:". $db->error;
                }
            }
            else{
                echo "Error connection to Table in phoneDB:". $db->error;
            }
            // $db->close();
        }
        function deleteData($db,$name){
            $database = "USE phonedb";
            if($db->query($database)){
                $createTableQuery = "DELETE FROM PHONEBOOK WHERE NAME='{$name}'";
                $result = $db->query($createTableQuery);
                if($result == True){
                    echo "<p>{$name} phone number has been deleted.</p>";
                }  
                else{
                    echo "Error in inserting in phoneDB:". $db->error;
                }
            }
            else{
                echo "Error connection to Table in phoneDB:". $db->error;
            }
            // $db->close();
        }
        try{
            $db = connectionEstablish();
            // createTablePhoneBook($db);
            // insertIntoDB($db,'Mom',9487419569);
            // updateData($db,'Mano',8904561358);
            // deleteData($db,'Mom');
            // echo '<br>';
            if(array_key_exists('insert', $_POST)) {
                insertIntoDB($db,$_POST['name'],$_POST['number']);
            }
            
            else if(array_key_exists('delete', $_POST)) {
                deleteData($db,$_POST['name']);
            }
            else if(array_key_exists('update', $_POST)) {
                updateData($db,$_POST['name'],$_POST['number']);
            }

        }
        catch(Exception $e){
            print_r($e);
        }
    ?>
    <div style="display:flex;flex-direction:row;width:100%;height:70%;justify-content:center;align-items:center;">
        <div style="display:flex;flex-direction:column;width:50%;height:100%;border:1px solid black;">
            <form method="post" style="display:flex;flex-direction:column;height:50%;width:20%;">
                <p>Name: <input type="text" name="name"></p>
                <p>Phone Number: <input type="text" name="number"></p>
                <input type="submit" name="insert"
                        class="button" value="insert" />
            </form>
            <hr style="width:100%;">    
            <form method="post" style="display:flex;flex-direction:column;height:50%;width:20%;">
                <p>Enter Name to Delete</p>
                <p>Name: <input type="text" name="name"></p><br>
                <input type="submit" name="delete" class="button1" value="delete"/>
            </form>
            <hr style="width:100%;"> 
            <form method="post" style="display:flex;flex-direction:column;height:50%;width:20%;">
                <p>Enter Name to Update</p>
                <p>Name: <input type="text" name="name"></p><br>
                <p>Updated Number: <input type="text" name="number"></p><br>
                <input type="submit" name="update" class="button1" value="update">
            </form>
            <hr style="width:100%;"> 
            <form method="post" style="display:flex;flex-direction:column;height:50%;width:20%;">
                <p>Name: <input type="text" name="name"></p><br>
                <input type="submit" name="findByName"
                        class="button1" value="findByName" />
            </form>
        </div>
        <div  style="display:flex;flex-direction:column;width:50%;height:100%;border:1px solid black;align-items:center;justify-content:center;">
            <form method="post" style="display:flex;flex-direction:column;height:50%;width:70%;">
                <?php
                    function getData($db){
                        echo "<h2>Contacts</h2><ol>";
                        $database = "USE phonedb";
                        if($db->query($database)){
                            $createTableQuery = "SELECT * FROM PHONEBOOK";
                            $result = $db->query($createTableQuery);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<li><text>Name:</text>\n" . $row['name'] . "\n" . "<text>PhoneNumber:</text>\n".  $row['phonenumber']. '</li>';
                                }
                            }  
                            else{
                                echo "<p>NO DATA AVAILABLE</p>";
                            }
                        }
                        else{
                            echo "Error connection to Table in phoneDB:". $db->error;
                        }
                        // $db->close();
                        echo "</ol>";
                    }
                    function findByName($db,$name){
                        echo "<h2>Contacts</h2><ol>";
                        $database = "USE phonedb";
                        if($db->query($database)){
                            $createTableQuery = "SELECT * FROM PHONEBOOK WHERE NAME='{$name}'";
                            $result = $db->query($createTableQuery);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<li><text>Name:</text>\n" . $row['name'] . "\n" . "<text>PhoneNumber:</text>\n".  $row['phonenumber']. '</li>';
                                }
                            }  
                            else{
                                echo "<p>NO DATA AVAILABLE</p>";
                            }
                        }
                        else{
                            echo "Error connection to Table in phoneDB:". $db->error;
                        }
                        // $db->close();
                        echo "</ol>";
                    }
                    if(array_key_exists("view",$_POST)){
                        getData($db);
                    }
                    else if(array_key_exists('findByName', $_POST)) {
                        findByName($db,$_POST['name']);
                    }
                ?>
                <input type="submit" name="view"
                        class="button" value="view" />		
            </form>
        </div>
    </div>
    </body>
<style>
    .body li text{
        color:Red;
        padding:4px;
        margin:8px;
        width:100%;
    }
    .body li{
        
        border:1px solid black;
        width:100%;
    }
</style>
</html>