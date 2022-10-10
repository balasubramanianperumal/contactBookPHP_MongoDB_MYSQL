
<html>
    <body>
    <title>ContactBook</title>
    <form style="display:flex;flex-direction:column;width:100%;border:2px solid black;padding:8px;" class="body">
            <!-- <p>Name: <input type="text" name="name"></p> -->
            <!-- <p>Phone Number: <input type="text" name="number"></p> -->
            <!-- <input type="submit" action="find(name)"> -->
            <?php
            require 'vendor/autoload.php'; // include Composer's autoloader
            function connectDB(){
                
                
                $client = new MongoDB\Client('mongodb://localhost:27017');
                
                // echo "Connection to database successfully";
                // select a database
                $db = $client->admin->phonebook;
                // echo "Database admin selected";

                return $db;
            }
            function insertData($db,$name,$phoneNumber){
                $db->insertOne(['name'=>$name,'number'=>$phoneNumber]);
            }
            function find($db){
                echo "<h2>Contacts</h2><ol>";
                $result = $db->find();
                $template1 = "<!doctype html><html>
                    <head><meta charset='utf-8'>
                    <title>Contact Book</title>
                    </head><body>
                    <h1>Contact Book</h1><ul>";
                $template11 = "<li>";
                $template12 = "<li>";
                $template13 = "</li>";
                $template2 ="</ul>
                </body></html>";
                // echo $template1;
                foreach ($result as $document) {
                    // echo $template11. "\nName:" . $document['name']. "\nPhone:" . $document['number'] . $template13;
                    echo "<li><text>Name:</text>\n" . $document['name'] . "\n" . "<text>PhoneNumber:</text>\n".  $document['number']. '</li>';
                }
                // echo $template2;
                echo "</ol>";
                // print_r($result);
                
            }
            
            try{
                $db = connectDB();
                // $db->insertOne(['name'=>'Bala','number'=>'9940661358']);
                // $db->insertOne(['name'=>'Anitha','number'=>'9442159699']); 
                // print_r($db->find());   
                // insertData($db,$_POST["name"],$_POST["number"]);
                find($db);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            ?>
    </form>
    <br>
    </body>
    <style>
        .body li text{
            color:Red;
            padding:4px;
            margin:8px;
        }
        .body li{
            
            border:1px solid black;
            width:15%;
        }
    </style>
</html>

