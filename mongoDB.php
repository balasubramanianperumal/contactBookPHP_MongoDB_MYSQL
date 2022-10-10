<!DOCTYPE html>
<html>
<head>
    <title>MongoDB</title>
</head>

<body class="body" style="">
    <div>
    <?php
            require 'vendor/autoload.php'; // include Composer's autoloader
            function connectDB(){
                $client = new MongoDB\Client('mongodb://localhost:27017');
                $db = $client->admin->phonebook;

                return $db;
            }
            function find($db){
                echo "<h2>Contacts</h2><ul>";
                $result = $db->find(array());
                foreach ($result as $document) {
                    echo "<li><text>Name:</text>\n" . $document['name'] . "\n" . "<text>PhoneNumber:</text>\n".  $document['number']. '</li>';
                }
                echo "</ul>";
                
            }
            
            
            function insertData($db,$name,$phoneNumber){
                $db->insertOne(['name'=>$name,'number'=>$phoneNumber]);
            }
            function deleteData($db,$name){
                $db->deleteOne(['name'=>$name]);
            }
            function updateData($db,$name,$number){
                $db->updateOne(['name'=>$name],['$set'=>['number'=>$number]]);
            }
            try{
                $db = connectDB();
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            ?>
    </div>
	
	<?php
    
		if(array_key_exists('insert', $_POST)) {
            insertData($db,$_POST['name'],$_POST['number']);
		}
        
		else if(array_key_exists('delete', $_POST)) {
            deleteData($db,$_POST['name']);
		}
        else if(array_key_exists('update', $_POST)) {
            updateData($db,$_POST['name'],$_POST['number']);
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
            <?php 
                function findByName($db,$name){
                    echo "<h2>Contacts</h2><ol>";
                    $result = $db->find(array("name"=>$name));
                    $template1 = "
                        <h1>Contact Book</h1><ul>";
                    $template11 = "<li>";
                    $template12 = "<li>";
                    $template13 = "</li>";
                    $template2 ="</ul>
                    </body></html>";
                    foreach ($result as $document) {
                        
                        echo "<li><text>Name:</text>\n" . $document['name'] . "\n" . "<text>PhoneNumber:</text>\n".  $document['number']. '</li>';
                    }
                    echo "</ul>";
                    
                }
                if(array_key_exists('view', $_POST)) {
                    find($db);
                }
                else if(array_key_exists('findByName', $_POST)) {
                    findByName($db,$_POST['name']);
                }
            ?>
            <form method="post" style="display:flex;flex-direction:column;height:50%;width:10%;">
                <input type="submit" name="view"
                        class="button" value="view" />		
            </form>
        </div>
    </div>
    <style>
        .body li text{
            color:Red;
            padding:4px;
            margin:8px;
        }
        .body li{
            
            border:1px solid black;
            width:100%;
        }
    </style>
</head>

</html>
