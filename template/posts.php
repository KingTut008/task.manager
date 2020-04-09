<?php
if(checkAuthorization('status')) {
    $massMessages = showContentPost($_SESSION['login']);?>
    <div>
        <?php if(checkAuthorization('group')) { ?>
        <div>
            <a class="add-massege" href="/route/posts/add/">Написать сообщение</a>
        </div>
        <div class="massege-conteiner">
            <div class="massege-status">
                <h3>Не прочитанные:</h3>
                    <?php showPostsList($massMessages, 0)?>  
            </div>
            <div class="massege-status">
                <h3>Прочитанные:</h3>
                    <?php showPostsList($massMessages, 1)?> 
            </div>    
        </div>
        <?php } else { ?>
        <div>
            <a class="add-massege-no" href="#">Написать сообщение</a> / Вы сможете отправлять сообщения после прохождения модерации
        </div>
        <?php } 
    } else { ?>
    <p>Эта страница не доступна, так как вы не авторизованы.</p>
    <?php } 
?>
