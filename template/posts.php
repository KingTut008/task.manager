<?php
if(checkAuthorization()) {
    $massMasseges = showContentPost($_SESSION['login']);?>
    <div>
        <?php if($massMasseges[0]['groupName'] == 'register,validate' || $massMasseges[0]['groupName'] == 'validate,register' ) { ?>
        <div>
            <a class="add-massege" href="/route/posts/add/">Написать сообщение</a>
        </div>
        <div class="massege-conteiner">
            <div class="massege-status">
                <h3>Не прочитанные:</h3>
                    <?php for ($i = 0; $i < count($massMasseges); $i++){ 
                        if (!$massMasseges[$i]['read']) {?>
                            <div class="massege-post" style="border: 1px solid <?= $massMasseges[$i]['color']?>;">
                                <div><a href='/route/posts/view/?id=<?= $massMasseges[$i]['id']?>'><?= $massMasseges[$i]['description']?> / <?= $massMasseges[$i]['catName']?></div>
                                <div><?= $massMasseges[$i]['read']?> / <?= $massMasseges[$i]['date']?></a></div>
                            </div> 
                    <?php } 
                        } ?>  
            </div>
            <div class="massege-status">
                <h3>Прочитанные:</h3>
                    <?php for ($i = 0; $i < count($massMasseges); $i++){ 
                        if ($massMasseges[$i]['read']) {?>
                            <div class="massege-post" style="border: 1px solid <?= $massMasseges[$i]['color']?>;">
                                <div><a href='/route/posts/view/?id=<?= $massMasseges[$i]['id']?>'><?= $massMasseges[$i]['description']?> / <?= $massMasseges[$i]['catName']?></div>
                                <div><?= $massMasseges[$i]['read']?> / <?= $massMasseges[$i]['date']?></a></div>
                            </div> 
                    <?php } 
                        } ?>  
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
