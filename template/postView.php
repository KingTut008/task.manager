<?php 
if(isset($_SESSION['login'])) {
    if(isset($_GET['id'])) {
        $dataPost = showViewPost($_GET['id'], $_SESSION['login']);  
        if (is_array($dataPost))  {
?>
<p>Тема сообщения: <?= $dataPost['description']?></p>
<p>Дата отправки: <?= $dataPost['date']?></p>
<p>Имя отправителя: <?= $dataPost['recipientName']?></p>
<p>Email отправителя: <?= $dataPost['recipientEmail']?></p>
<p>Сообщение: <?= $dataPost['text']?></p>
<?php } else { ?>
        <p><?= $dataPost ?></p>
    <?php    }
    } else { ?>
    <p>Данного сообщения не существует</p> 
    <?php   }
    } 
else { ?>
    <p>Эта страница не доступна, так как вы не авторизованы.</p>
    <?php
} ?>
