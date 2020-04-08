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
    $result = mysqli_query($connect, "SELECT masseges.id, masseges.description, masseges.text, masseges.date, masseges.read, categories.color ,
                                            categories.name as 'catName',
                                            users.name as 'senderName',
                                            users_two.name as 'recipientName',
                                            GROUP_CONCAT(groups.name) as 'groupName' 
                                            FROM masseges
                                            LEFT JOIN `categories` ON categories.id = masseges.cat_id
                                            LEFT JOIN `users` ON users.id = masseges.sender_id
                                            LEFT JOIN `users` as users_two ON users_two.id = masseges.recipient_id
                                            LEFT JOIN `group_user` ON group_user.id_user = masseges.recipient_id
                                            LEFT JOIN `groups` ON group_user.id_group = groups.id
                                            WHERE users_two.name = '$login'
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
                                            users.email as 'senderEmail',
                                            GROUP_CONCAT(groups.name) as 'groupName' 
                                            FROM masseges
                                            LEFT JOIN `categories` ON categories.id = masseges.cat_id
                                            LEFT JOIN `users` ON users.id = masseges.sender_id
                                            LEFT JOIN `users` as users_two ON users_two.id = masseges.recipient_id
                                            LEFT JOIN `group_user` ON group_user.id_user = masseges.sender_id
                                            LEFT JOIN `groups` ON group_user.id_group = groups.id
                                            WHERE masseges.id = '$idPost'");  
    $dataPost = mysqli_fetch_assoc($result); 
    if ($dataPost['recipientName'] == $login) {
        mysqli_query($connect, "UPDATE masseges SET `read` = '1' WHERE id = '$idPost'");
    } else {
        $dataPost = "Это не ваши сообщения";
    }   
    mysqli_close($connect);
    return $dataPost;
}

function inputUsersData($login) {
    $connect = mysqli_connect('localhost', 'mysql', 'mysql', 'task_manager');
    $users = mysqli_query($connect, "SELECT users.id, users.name, groups.name as 'group' FROM users
                                        LEFT JOIN `group_user` ON group_user.id_user = users.id
                                        LEFT JOIN `groups` ON group_user.id_group = groups.id
                                        WHERE users.name != '$login' AND groups.name = 'validate'");
    mysqli_close($connect);
    return $users;
}

function inputCatData() {
    $connect = mysqli_connect('localhost', 'mysql', 'mysql', 'task_manager');
    $cats = mysqli_query($connect, "SELECT * FROM categories WHERE id != 1");
    mysqli_close($connect);
    return $cats;
}

function sendMassege ($message, $login) {
    $connect = mysqli_connect('localhost', 'mysql', 'mysql', 'task_manager');
    $id_user = mysqli_query($connect, "SELECT id FROM users WHERE name = '$login'");
    $id = mysqli_fetch_assoc($id_user);
    $date = date("Y-m-d H:m:s", time());
    
    $user = $id['id'];
    $cat = $message['cat'];
    $recipien = $message['recipien'];
    $header = htmlspecialchars($message['header']);
    $text = htmlspecialchars($message['text']);

    $sendMessage = mysqli_query($connect, "INSERT INTO masseges (cat_id, sender_id, recipient_id, description, text, date) VALUES 
                                ('$cat','$user','$recipien', '$header', '$text','$date')");
    
    mysqli_close($connect); 
    return $sendMessage ? "Cообщение отправлено" : "Произошла ошибка";
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
