<?php
function showContentProfile ($login){
    $connect = mysqli_connect('localhost','mysql','mysql','task_manager');
    $result = mysqli_query ($connect, "SELECT users.name, users.email, users.phone, users.password, GROUP_CONCAT(groups.name) as 'groupName' FROM users
                                    LEFT JOIN `group_user` ON group_user.id_user = users.id
                                    LEFT JOIN `groups` ON group_user.id_group = groups.id                                   
                                    WHERE users.name = '$login'
                                    GROUP BY users.name, users.email, users.phone, users.password");
    mysqli_close($connect);
    return $dataProfile = mysqli_fetch_assoc($result);
}
function showContent($menuItems){
    $idPages = array_search(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), array_column($menuItems, 'path'));
    if($menuItems[$idPages]['path'] != '/'){
        include $_SERVER['DOCUMENT_ROOT'] . "/template/" . $menuItems[$idPages]['template'];
    }
}