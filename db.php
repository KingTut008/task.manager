<?php
$hots = "localhost";
$user = "mysql";
$password = "mysql";
$dbName = "task_manager";

$connect = mysqli_connect($hots, $user, $password, $dbName);

if(mysqli_connect_error()){
    echo mysqli_connect_error();
} else {
    // $date = date("Y-m-d H:i:s",time());
    // $result = mysqli_query($connect, "INSERT INTO masseges (cat_id, sender_id, recipient_id, description, text, date) VALUES 
    //                                 ('5','1','2', 'Первое письмо', 'письмо иван петру по работе','$date'),
    //                                 ('5','1','2', 'Второе письмо', 'письмо иван петру по работе','$date'),
    //                                 ('6','1','2', 'Первое письмо', 'письмо иван петру по личному','$date'),
    //                                 ('6','1','2', 'Второе письмо', 'письмо иван петру по личному','$date'),
    //                                 ('7','1','2', 'Первое письмо', 'письмо иван петру с форму','$date'),
    //                                 ('8','1','2', 'Первое письмо', 'письмо иван петру с магазина','$date'),
    //                                 ('5','2','1', 'Первое письмо', 'письмо петра ивану по работе','$date'),
    //                                 ('5','2','1', 'Второе письмо', 'письмо петра ивану по работе','$date'),
    //                                 ('6','2','1', 'Первое письмо', 'письмо петра ивану по личному','$date'),
    //                                 ('6','2','1', 'Второе письмо', 'письмо петра ивану по личному','$date'),
    //                                 ('7','2','1', 'Первое письмо', 'письмо петра ивану с форму','$date'),
    //                                 ('8','2','1', 'Первое письмо', 'письмо петра ивану с магазина','$date')");
    
    
    // $result = mysqli_query ($connect, "SELECT users.name, users.email, users.phone, users.password, GROUP_CONCAT(groups.name) as 'groupName' FROM users
    //                                 LEFT JOIN `group_user` ON group_user.id_user = users.id
    //                                 LEFT JOIN `groups` ON group_user.id_group = groups.id
    //                                 GROUP BY users.name, users.email, users.phone, users.password");
    
    // $result = mysqli_query($connect, "SELECT masseges.id, masseges.description, masseges.text, masseges.date, masseges.read,
    //                                         categories.name as 'catName',
    //                                         users.name as 'senderName',
    //                                         users_two.name as 'recipientName',
    //                                         GROUP_CONCAT(groups.name) as 'groupName' 
    //                                         FROM masseges
    //                                         LEFT JOIN `categories` ON categories.id = masseges.cat_id
    //                                         LEFT JOIN `users` ON users.id = masseges.sender_id
    //                                         LEFT JOIN `users` as users_two ON users_two.id = masseges.recipient_id
    //                                         LEFT JOIN `group_user` ON group_user.id_user = masseges.sender_id
    //                                         LEFT JOIN `groups` ON group_user.id_group = groups.id
    //                                         WHERE users.name = 'ivan'
    //                                         GROUP BY masseges.id, masseges.description, masseges.text, masseges.date, masseges.read, categories.name, users.name,  users_two.name
    //                                         ORDER BY masseges.read asc");   
        //  $result = mysqli_query($connect, "SELECT masseges.id, masseges.description, masseges.text, masseges.date, masseges.read,
        //                                         categories.name as 'catName',
        //                                         users.name as 'senderName',
        //                                         users_two.name as 'recipientName',
        //                                         users_two.email as 'recipientEmail',
        //                                         GROUP_CONCAT(groups.name) as 'groupName' 
        //                                         FROM masseges
        //                                         LEFT JOIN `categories` ON categories.id = masseges.cat_id
        //                                         LEFT JOIN `users` ON users.id = masseges.sender_id
        //                                         LEFT JOIN `users` as users_two ON users_two.id = masseges.recipient_id
        //                                         LEFT JOIN `group_user` ON group_user.id_user = masseges.sender_id
        //                                         LEFT JOIN `groups` ON group_user.id_group = groups.id
        //                                         WHERE masseges.id = '5'");    
        $result = mysqli_query($connect, "UPDATE masseges SET read = '1' WHERE id = '5' ");
    if(mysqli_error($connect))
    {
        echo mysqli_error($connect);
    }
    // echo "<pre>";
    //     var_dump(mysqli_fetch_assoc($result));
    // echo "</pre>";

}
mysqli_close($connect);

?>
