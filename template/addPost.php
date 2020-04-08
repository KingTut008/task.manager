<?php 
if(isset($_POST['message'])) {
    $sendMessage = sendMassege($_POST, $_SESSION['login']);
}
?>
<h2>Отправить сообщение:</h2>
<?php
if(isset($_SESSION['login'])) { 
    $users = inputUsersData($_SESSION['login']);
    $cats = inputCatData();
    ?>
    <form action="/route/posts/add/" method="POST">
        <label>Заголовок:</label></br>
        <input type="text" name="header" id="header" maxlength="255" required></br>
        <label>Cообщение:</label></br>
        <textarea name="text" id="" cols="30" rows="10" required></textarea></br>
        <label>Получатель:</label></br>
        <select name="recipien" id="recipien" required>
            <?php 
                while($user = mysqli_fetch_assoc($users)){
                ?> 
                    <option value="<?=$user['id']?>"><?=$user['name']?></option>
                <?php
                }
            ?>
        </select></br>
        <label>Раздел:</label></br>
        <select name="cat" id="cat" required>
            <?php 
                while($cat = mysqli_fetch_assoc($cats)){
                ?> 
                    <option style="background-color: <?=$cat['color']?>" value="<?=$cat['id']?>"><?=$cat['name']?></option>
                <?php
                }
            ?>
        </select></br>
        <input name="message" type="submit" value="Отправить">
    </form>
    <div>
        <?= $sendMessage ?? " " ?>
    </div>
    <?php } 
else { ?>
    <p>Эта страница не доступна, так как вы не авторизованы.</p>
    <?php
} ?>