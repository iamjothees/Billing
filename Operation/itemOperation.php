<?php
    session_start();
    require_once __DIR__ . '/../Class/itemClass.php';
    $itemObj = new item();
    $input = json_decode(file_get_contents('php://input'));
    if ($input->reqAction === 'view'){
        echo $itemObj->view();
    }
    else if ($input->reqAction === 'add'){
        $_SESSION['res'] =  json_decode($itemObj->create($input->item_name, $input->item_category, $input->item_status));
    }
    else if ($input->reqAction === 'delete'){
        $_SESSION['res'] =  json_decode($itemObj->delete($input->item_id));
    }
    else if ($input->reqAction === 'edit'){
        //echo "id = " . var_dump($input->cat_id);
        echo $itemObj->view(false, $input->item_id);
    }
    else if ($input->reqAction === 'update'){
        //echo "id = " . var_dump($input->cat_id);
        $_SESSION['res'] =  json_decode($itemObj->edit($input->item_id, $input->item_name, $input->cat_id, $input->item_status));
    }
?>