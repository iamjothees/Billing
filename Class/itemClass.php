<?php
    require_once __DIR__ . '/DB_Conn.php';
    class Item extends DB_Conn{
        function create($name, $category, $status){
            $query = "INSERT INTO item (item_name, item_category, item_status) VALUES (:name, :category, :status)";
            $sth = $this->conn->prepare($query);
            $out = $sth->execute(['name' => $name, 'category' => $category, 'status'=>$status]) !== false ?  [1, "Item Created successfully"] : [0, "Error creating item"];
            return json_encode($out);
        }
    

        function edit($id, $name, $category, $status) : string{
            $query = "UPDATE item SET item_name = :name, item_category = :category,  item_status = :status WHERE item_id = :id ";
            $sth = $this->conn->prepare($query);
            echo $query;
            $out = $sth->execute(['name'=>$name, 'category'=>$category, 'status'=>$status, 'id'=>$id]) !== false? [1, "Item Updated Successfully"] : [0, "Error updating item"];
            return json_encode($out);
        }

        function delete($id) :string{
            $query = "DELETE FROM item WHERE item_id = :id";
            $sth = $this->conn->prepare($query);
            $out = $sth->execute(['id'=>$id]) !== false? [1, "Item Deleted  Successfully"] : [0, "Error deleting item"];
            return json_encode($out);
        }

        function view($isViewAll = true, $id = null) : string{

            if ($isViewAll){
                $query = "SELECT * FROM item";
                $sth = $this->conn->prepare($query);
                $sth->execute();
    
            }else{
                $query = "SELECT * FROM item WHERE item_id = :id";
                $sth = $this->conn->prepare($query);
                $sth->execute(['id'=>$id]);
            }
            $out = $sth->fetchAll(\PDO::FETCH_ASSOC);
            
            return json_encode($out);

        }

        function cat_id_name($id){
            require_once 'categoryClass.php';
            $catObj = new Category();

        }
    }
?>