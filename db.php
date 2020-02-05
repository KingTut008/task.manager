<?php
$hots = "localhost";
$user = "mysql";
$password = "mysql";
$dbName = "task_manager";

$conect = mysqli_connect($hots, $user, $password, $dbName);

if(mysqli_connect_error()){
    echo mysqli_connect_error();
} else {
    $result = mysqli_query ($conect, "SELECT users.name, users.email, users.phone, users.password, GROUP_CONCAT(groups.name) as 'groupName' FROM users
                                    LEFT JOIN `group_user` ON group_user.id_user = users.id
                                    LEFT JOIN `groups` ON group_user.id_group = groups.id
                                    GROUP BY users.name, users.email, users.phone, users.password");
    if(mysqli_error($conect))
    {
        echo mysqli_error($conect);
    }
    // $result = mysqli_query($conect, "SELECT * FROM users WHERE name='ivan'");
    // $row = mysqli_fetch_assoc($result);
    // var_export($row);
    //, groups.name as 'groupName'
    //LEFT JOIN groups ON (group_user.id_group = groups.id)
    //var_export($result);
    while($row = mysqli_fetch_assoc($result)){
    echo "<p>";
        var_dump($row);
    echo "</p>";
    }

    
}
mysqli_close($conect);

?>
