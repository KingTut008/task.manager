<?php
function checkAuthorization($value){
    if ($value == 'status') {
        return isset($_SESSION['login']);
    }

    if ($value == 'group') {
        return $_SESSION['groupName'] == 'register,validate' || $_SESSION['groupName'] == 'validate,register';
    }
}

function showContentProfile($login){
    $connect = dbconnect();
    $login = mysqli_real_escape_string($connect, $login);
    $result = mysqli_query ($connect, "SELECT users.name, users.email, users.phone, users.password, GROUP_CONCAT(groups.name) as 'groupName' FROM users
                                    LEFT JOIN `group_user` ON group_user.id_user = users.id
                                    LEFT JOIN `groups` ON group_user.id_group = groups.id                                   
                                    WHERE users.name = '$login'
                                    GROUP BY users.name, users.email, users.phone, users.password");
    mysqli_close($connect);
    return $dataProfile = mysqli_fetch_assoc($result);
}

function showContentPost($login){
    $massMessages = array();
    $connect = dbconnect();
    $login = mysqli_real_escape_string($connect, $login);
    $result = mysqli_query($connect, "SELECT messages.id, messages.description, messages.text, messages.created_at, messages.read, 
                                            color.name as 'color',
                                            categories.name as 'catName',
                                            users.name as 'senderName',
                                            users_two.name as 'recipientName',
                                            GROUP_CONCAT(groups.name) as 'groupName' 
                                            FROM messages
                                            LEFT JOIN `categories` ON categories.id = messages.cat_id
                                            LEFT JOIN `users` ON users.id = messages.created_by
                                            LEFT JOIN `users` as users_two ON users_two.id = messages.recipient_id
                                            LEFT JOIN `group_user` ON group_user.id_user = messages.recipient_id
                                            LEFT JOIN `groups` ON group_user.id_group = groups.id
                                            LEFT JOIN `color` ON categories.color_id = color.id
                                            WHERE users_two.name = '$login'
                                            GROUP BY messages.id, messages.description, messages.text, messages.created_at, messages.read, categories.name, users.name,  users_two.name
                                            ORDER BY messages.read asc");  
    mysqli_close($connect);
    while($row = mysqli_fetch_assoc($result)){
        array_push($massMessages, $row);
    }
    return $massMessages;
}

function showViewPost($idPost, $login){
    $connect = dbconnect();
    $idPost = mysqli_real_escape_string($connect, $idPost);
    $result = mysqli_query($connect, "SELECT messages.id, messages.description, messages.text, messages.created_at, messages.read,
                                            categories.name as 'catName',
                                            users.name as 'senderName',
                                            users_two.name as 'recipientName',
                                            users.email as 'senderEmail',
                                            GROUP_CONCAT(groups.name) as 'groupName' 
                                            FROM messages
                                            LEFT JOIN `categories` ON categories.id = messages.cat_id
                                            LEFT JOIN `users` ON users.id = messages.created_by
                                            LEFT JOIN `users` as users_two ON users_two.id = messages.recipient_id
                                            LEFT JOIN `group_user` ON group_user.id_user = messages.created_by
                                            LEFT JOIN `groups` ON group_user.id_group = groups.id
                                            WHERE messages.id = '$idPost'");  
    $dataPost = mysqli_fetch_assoc($result); 
    if ($dataPost['recipientName'] == $login) {
        mysqli_query($connect, "UPDATE messages SET `read` = '1' WHERE id = '$idPost'");
    } else {
        $dataPost = "Это не ваши сообщения";
    }   
    mysqli_close($connect);
    return $dataPost;
}

function showPostsList ($massMessages, $status) {
    if(!$status) {
        foreach($massMessages as $massMessage){ 
            if (!$massMessage['read']) {
                include $_SERVER['DOCUMENT_ROOT'] . '/template/postsList.php';
            }
        } 
    } else {
        foreach($massMessages as $massMessage){ 
            if ($massMessage['read']) {
                include $_SERVER['DOCUMENT_ROOT'] . '/template/postsList.php';
            }
        } 
    }
}

function inputUsersData($login) {
    $connect = dbconnect();
    $login = mysqli_real_escape_string($connect, $login);
    $users = mysqli_query($connect, "SELECT users.id, users.name, groups.name as 'group' FROM users
                                        LEFT JOIN `group_user` ON group_user.id_user = users.id
                                        LEFT JOIN `groups` ON group_user.id_group = groups.id
                                        WHERE users.name != '$login' AND groups.name = 'validate'");
    mysqli_close($connect);
    return $users;
}

function inputCatData() {
    $connect = dbconnect();
    $cats = mysqli_query($connect, "SELECT * FROM categories WHERE id != 1");
    mysqli_close($connect);
    return $cats;
}

function sendMessage ($message, $login) {
    $connect = dbconnect();
    $login = mysqli_real_escape_string($connect, $login);
    $id_user = mysqli_query($connect, "SELECT id FROM users WHERE name = '$login'");
    $id = mysqli_fetch_assoc($id_user);
    $date = date("Y-m-d H:m:s", time());
    
    $user = $id['id'];
    $cat = $message['cat'];
    $recipien = $message['recipien'];
    $header = mysqli_real_escape_string($connect, $message['header']);
    $text = mysqli_real_escape_string($connect, $message['text']);

    if ($user != $recipien) {
        if (strlen($header) <= 255) {
            $result = mysqli_query($connect, "INSERT INTO messages (cat_id, created_by, recipient_id, description, text, created_at) VALUES 
                                    ('$cat','$user','$recipien', '$header', '$text','$date')");
            if ($result) {
                $sendMessage = "Cообщение отправленно";
            } else {
                $sendMessage = "Произошла ошибка";
            }
        } else {
            $sendMessage = "Слишком длинный заголовок";
        }
    } else {
        $sendMessage = "Вы не можете отправлять самому себе";
    }
     
    mysqli_close($connect); 
    return $sendMessage;
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
