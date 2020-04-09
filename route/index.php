<?php 
session_start();
if(isset($_SESSION['loginKey'])){
    setcookie('loginName', $_COOKIE['loginName'], time() + 60 * 60 * 24 * 30, '/');
    setcookie('loginKey', $_COOKIE['loginKey'], time() + 60 * 20, '/');
}
error_reporting(E_ALL);

if(isset($_GET['login']) && $_GET['login'] == 'exit') {
    unset($_SESSION['loginKey']);
    setcookie('loginKey', $_COOKIE['loginKey'], time() - 1000, '/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/moduls/dbconnect.php";

?>

<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td class="left-collum-index">			
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/template/blockTitle.php"; ?>
			</td>
            <td class="right-collum-index">
				<div class="project-folders-menu">
					<ul class="project-folders-v">
                        <li class="project-folders-v-active"><?php if (isset($_SESSION['loginKey'])){ ?><a href="/?login=exit">Выход</a><?php } else { ?><a href="/?login=yes">Авторизация</a><?php } ?></li>
    					<li><a href="#">Регистрация</a></li>
    					<li><a href="#">Забыли пароль?</a></li>
					</ul>
				    <div class="clearfix"></div>
				</div>              
			</td>
        </tr>
    </table>
  
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php";
?>    
