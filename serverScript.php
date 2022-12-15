<?php
    class Category{
        function create($name, $status) : string{
            include 'DB_Conn.php';
            $query = "INSERT INTO category (cat_name, cat_status) VALUES (:name, :status)";
            $sth = $conn->prepare($query);
            $out = $sth->execute(['name' => $name, 'status'=>$status]) !== false ? "New category created" : "Error creating category";
            $conn = null;
            return $out;
        }

        function edit($id, $name, $status) : string{
            include 'DB_Conn.php';
            $query = "UPDATE category SET cat_name = '$name', cat_status = '$status' WHERE cat_id = '$id'";
            $out = $conn->exec($query) !== false? "Category updated" : "Error updating category";
            $conn = null;
            return $out;
        }

        function delete($id) :string{
            include 'DB_Conn.php';
            $query = "DELETE FROM category WHERE cat_id = '$id'";
            $out = $conn->exec($query) !== false? "Category deleted" : "Error deleting category";
            $conn = null;
            return $out;
        }

        function view($isViewAll = true, $id = null) : string{
            include 'DB_Conn.php';
            if ($isViewAll){
                $query = "SELECT * FROM category";
                $sth = $conn->prepare($query);
                $sth->execute();

            }else{
                $query = "SELECT * FROM category WHERE cat_id = :id";
                $sth = $conn->prepare($query);
                $sth->execute(['id'=>$id]);
            }
            $out = $sth->fetchAll(\PDO::FETCH_ASSOC);
            
            $conn = null;
            return json_encode($out);
        }

        function show_name() : string{
            include 'DB_Conn.php';
            
            $query = "SELECT cat_id, cat_name FROM category";
            
            $sth = $conn->prepare($query);
            $sth->execute();

            $out = $sth->fetchAll(\PDO::FETCH_ASSOC);
            
            $conn = null;
            return json_encode($out);
        }
    }

    class Item{
        function create($name, $category, $status){
            include 'DB_Conn.php';
            $query = "INSERT INTO item (item_name, item_category, item_status) VALUES ('$name', '$category', '$status')";
            $out = $conn->exec($query) !== false ?  "Item Created successfully" : "Error creating item";
            $conn = null;
            return $out;
        }
    

        function edit($id, $name, $category, $status) : string{
            include 'DB_Conn.php';
            $query = "UPDATE item SET item_name = '$name', item_category = '$category'  item_status = '$status' WHERE item_id = '$id'";
            $out = $conn->exec($query) !== false? "Item updated" : "Error updating item";
            $conn = null;
            return $out;
        }

        function delete($id) :string{
            include 'DB_Conn.php';
            $query = "DELETE FROM item WHERE item_id = '$id'";
            $out = $conn->exec($query) !== false? "Item deleted" : "Error deleting item";
            $conn = null;
            return $out;
        }

        function view($isViewAll = true, $id = null) : string{
            include 'DB_Conn.php';
            if ($isViewAll){
                $query = "SELECT * FROM item";
            }else{
                $query = "SELECT * FROM item WHERE item_id = '$id'";
            }

                $sth = $conn->prepare($query);
                $sth->execute();

                $out = $sth->fetchAll(\PDO::FETCH_ASSOC);
                
                $conn = null;
                return json_encode($out);
        }
    }

    //to print
    function printer($out){
        $out = json_decode($out, true);
        echo "<br>";
        foreach( $out as  $row){
            foreach($row as $key => $val){
                if ($key == "item_category"){
                    include 'DB_Conn.php';
                    $query = "SELECT cat_name FROM category WHERE cat_id = '$val'";
                    $sth = $conn->prepare($query);
                    $sth->execute();
                    $out = $sth->fetchAll(\PDO::FETCH_ASSOC);
                    //print_r($out);
                    $val = $out[0]['cat_name'];
                }
                echo "$key: $val<br>";
            }
            echo "<br><br>";
        }
    }

    
    
    $input = json_decode(file_get_contents('php://input'));
    if ($input->reqObj === 'category'){
        $catObj = new category();
        if ($input->reqAction === 'view'){
            echo $catObj->view();
        }
        else if ($input->reqAction === 'add'){
            echo $catObj->create($input->cat_name, $input->cat_status);
        }
        else if ($input->reqAction === 'delete'){
            echo $catObj->delete($input->cat_id);
        }
        else if ($input->reqAction === 'edit'){
            //echo "id = " . var_dump($input->cat_id);
            echo $catObj->view(false, $input->cat_id);
        }
        else if ($input->reqAction === 'update'){
            //echo "id = " . var_dump($input->cat_id);
            echo $catObj->edit($input->cat_id, $input->cat_name, $input->cat_status);
        }

        else if ($input->reqAction === 'cat_name'){
            //echo "id = " . var_dump($input->cat_id);
            echo $catObj->show_name();
        }
    }

    if ($input->reqObj === 'item'){
        $itemObj = new item();
        if ($input->reqAction === 'view'){
            echo $itemObj->view();
        }
        else if ($input->reqAction === 'add'){
            echo $itemObj->create($input->item_name, $input->item_category, $input->item_status);
        }
        else if ($input->reqAction === 'delete'){
            echo $itemObj->delete($input->item_id);
        }
        else if ($input->reqAction === 'edit'){
            //echo "id = " . var_dump($input->cat_id);
            echo $catObj->view(false, $input->item_id);
        }
        else if ($input->reqAction === 'update'){
            //echo "id = " . var_dump($input->cat_id);
            echo $catObj->edit($input->item_id, $input->item_name, $input->item_status);
        }
    }
    


    /* $catObj = new category();
    $itemObj = new item(); */


    //To Create Category
    /* echo $catObj->create('Bag', 'Sling Bag');
    echo "<br>";
    printer ($catObj->view()); */

    //To Edit Category
    /* echo $catObj->edit(2, 'edited Cloth', 'ed Non-veg');
    echo "<br>";
    printer ($catObj->view()); */

    //To Delete Category
    /* echo $catObj->delete(3);
    printer ($catObj->view()); */

    //To View
    /* printer( $catObj->view(false, 7));
    echo "<br>"; */
    

    //To Create Item
    /* $itemObj->create('Dosa', 1, 'Available');
    printer ($itemObj->view()); */

    //To Edit Item
    /* echo $itemObj->edit(2, 'edited Cloth', 'ed Non-veg');
    echo "<br>";
    printer ($itemObj->view()); */

    //To Delete Item
    /* echo $itemObj->delete(3);
    printer ($itemObj->view()); */


    //To View
    /* printer( $itemObj->view(false, 7));
    echo "<br>"; */
  
?>