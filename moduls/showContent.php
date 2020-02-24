<?php
function showContentProfile($login){
    $connect = mysqli_connect('localhost', 'mysql', 'mysql', 'task_manager');
    $result = mysqli_query ($connect, "SELECT users.name, users.email, users.phone, users.password, GROUP_CONCAT(groups.name) as 'groupName' FROM users
                                    LEFT JOIN `group_user` ON group_user.id_user = users.id
                                    LEFT JOIN `groups` ON group_user.id_group = groups.id                                   
                                    WHERE users.name = '$login'
                                    GROUP BY users.name, users.email, users.phone, users.password");
    mysqli_close($connect);
    return $dataProfile = mysqli_fetch_assoc($result);
}

function showContentPost($login){
    $massMasseges = array();
    $connect = mysqli_connect('localhost', 'mysql', 'mysql', 'task_manager');
    $result = mysqli_query($connect, "SELECT masseges.id, masseges.description, masseges.text, masseges.date, masseges.read,
                                            categories.name as 'catName',
                                            users.name as 'senderName',
                                            users_two.name as 'recipientName',
                                            GROUP_CONCAT(groups.name) as 'groupName' 
                                            FROM masseges
                                            LEFT JOIN `categories` ON categories.id = masseges.cat_id
                                            LEFT JOIN `users` ON users.id = masseges.sender_id
                                            LEFT JOIN `users` as users_two ON users_two.id = masseges.recipient_id
                                            LEFT JOIN `group_user` ON group_user.id_user = masseges.sender_id
                                            LEFT JOIN `groups` ON group_user.id_group = groups.id
                                            WHERE users.name = '$login'
                                            GROUP BY masseges.id, masseges.description, masseges.text, masseges.date, masseges.read, categories.name, users.name,  users_two.name
                                            ORDER BY masseges.read asc");  
    mysqli_close($connect);
    while($row = mysqli_fetch_assoc($result)){
        array_push($massMasseges, $row);
    }
    return $massMasseges;
}

function showViewPost($idPost, $login){
    $connect = mysqli_connect('localhost', 'mysql', 'mysql', 'task_manager');
    $result = mysqli_query($connect, "SELECT masseges.id, masseges.description, masseges.text, masseges.date, masseges.read,
                                            categories.name as 'catName',
                                            users.name as 'senderName',
                                            users_two.name as 'recipientName',
                                            users_two.email as 'recipientEmail',
                                            GROUP_CONCAT(groups.name) as 'groupName' 
                                            FROM masseges
                                            LEFT JOIN `categories` ON categories.id = masseges.cat_id
                                            LEFT JOIN `users` ON users.id = masseges.sender_id
                                            LEFT JOIN `users` as users_two ON users_two.id = masseges.recipient_id
                                            LEFT JOIN `group_user` ON group_user.id_user = masseges.sender_id
                                            LEFT JOIN `groups` ON group_user.id_group = groups.id
                                            WHERE masseges.id = '$idPost'");  
    $dataPost = mysqli_fetch_assoc($result); 
    if ($dataPost['senderName'] == $login) {
        mysqli_query($connect, "UPDATE masseges SET `read` = '1' WHERE id = '$idPost'");
    } else {
        $dataPost = "Это не ваши сообщения";
    }   
    mysqli_close($connect);
    return $dataPost;
}

function showContent($menuItems){
    $idPages = array_search(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), array_column($menuItems, 'path'));
    if($menuItems[$idPages]['path'] != '/'){
        include $_SERVER['DOCUMENT_ROOT'] . "/template/" . $menuItems[$idPages]['template'];
    }

    if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/route/posts/add/'){
        include $_SERVER['DOCUMENT_ROOT'] . "/template/" . 'addPost.php';
    }

    if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/route/posts/view/'){
        include $_SERVER['DOCUMENT_ROOT'] . "/template/" . 'postView.php';
    }
}