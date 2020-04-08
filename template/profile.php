<?php 
if(checkAuthorization()) {
    $dataProfile = showContentProfile($_SESSION['login']); 
?>
<p>Ваше имя: <?= $dataProfile['name']?></p>
<p>Ваше e-mail: <?= $dataProfile['email']?></p>
<p>Ваше телефон: <?= $dataProfile['phone']?></p>
<p>Вы принадлежите группе(группам): <?= $dataProfile['groupName']?></p>
<?php } else { ?>
    <p>Эта страница не доступна, так как вы не авторизованы.</p>
    <?php
} ?>
