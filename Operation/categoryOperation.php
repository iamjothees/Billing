<?php
    session_start();
    require_once __DIR__ . '/../rootInfo.php';
    require __DIR__ . '/../Class/categoryClass.php';
    $catObj = new Category();
    $input = json_decode(file_get_contents('php://input'));
    if ($input->reqAction === 'view'){
        echo $catObj->view();
    }
    else if ($input->reqAction === 'add'){
        $_SESSION['res'] = json_decode($catObj->create($input->cat_name, $input->cat_status));
    }
    else if ($input->reqAction === 'delete'){
        $_SESSION['res'] =  json_decode($catObj->delete($input->cat_id));
    }
    else if ($input->reqAction === 'edit'){
        //echo "id = " . var_dump($input->cat_id);
        echo ($catObj->view(false, $input->cat_id));
    }
    else if ($input->reqAction === 'update'){
        //echo "id = " . var_dump($input->cat_id);
        $_SESSION['res'] = json_decode($catObj->edit($input->cat_id, $input->cat_name, $input->cat_status));
    }

    else if ($input->reqAction === 'cat_name'){
        //echo "id = " . var_dump($input->cat_id);
        echo $catObj->view_name();
    }

?>