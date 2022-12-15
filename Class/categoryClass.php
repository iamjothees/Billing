<?php
require_once __DIR__ . '/DB_Conn.php';
class Category extends DB_conn{
    function create($name, $status) : string{
        $query = "INSERT INTO category (cat_name, cat_status) VALUES (:name, :status)";
        $sth = $this->conn->prepare($query);
        $out = $sth->execute(['name' => $name, 'status'=>$status]) !== false ? [1, "New category created"] : [0, "Error creating category"];
        return json_encode($out);
    }

    function edit($id, $name, $status) : string{
        $query = "UPDATE category SET cat_name = '$name', cat_status = '$status' WHERE cat_id = '$id'";
        $out = $this->conn->exec($query) !== false? [1,"Category updated"] : [0, "Error updating category"];
        return json_encode($out);
    }

    function delete($id) :string{
        $query = "DELETE FROM category WHERE cat_id = '$id'";
        $out = $this->conn->exec($query) !== false? [1, "Category deleted"] : [0, "Deleting category"];
        return json_encode($out);

    }

    function view($isViewAll = true, $id = null) : string{
        if ($isViewAll){
            $query = "SELECT * FROM category";
            $sth = $this->conn->prepare($query);
            $sth->execute();
        }else{
            $query = "SELECT * FROM category WHERE cat_id = :id";
            $sth = $this->conn->prepare($query);
            $sth->execute(['id'=>$id]);
        }
        $out = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        return json_encode($out);
    }

    function view_name() : string{
        
        $query = "SELECT cat_id, cat_name FROM category";
        
        $sth = $this->conn->prepare($query);
        $sth->execute();

        $out = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        return json_encode($out);
    }
}


?>