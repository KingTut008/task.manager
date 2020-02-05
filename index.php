<?php 
session_start();
if (isset($_SESSION['loginKey'])){
    setcookie('loginName', $_COOKIE['loginName'], time() + 60 * 60 * 24 * 30, '/');
    setcookie('loginKey', $_COOKIE['loginKey'], time() + 60 * 20, '/');
}

error_reporting(E_ALL);
$message = false;

$connect = mysqli_connect('localhost','mysql','mysql','task_manager');

if (isset($_POST['send'])) {
    if(mysqli_connect_error()){
        echo mysqli_connect_error();
    } else {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);
        $result = mysqli_query($connect, "SELECT name, password FROM users WHERE name='$login'");
        $user_data = mysqli_fetch_assoc($result);

        if($user_data['password'] == $password){
            setcookie('loginName', $login, time() + 60 * 60 * 24 * 30, '/');
            $_SESSION['login'] = $login;
            $_SESSION['loginKey'] = md5(rand(0,1000000));
            setcookie('loginKey', $_SESSION['loginKey'], time() + 60 * 20, '/');
            $message = true;
        }
    }
}

if (isset($_GET['login']) && $_GET['login'] == 'exit') {
    unset($_SESSION['loginKey']);
    session_destroy();
    setcookie('loginKey', $_COOKIE['loginKey'], time() - 1000, '/');
}

mysqli_close($connect);

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
    					<li class="project-folders-v-active"><?php if (isset($_SESSION['loginKey'])){ ?><a href="/?login=exit">Выход</a><?php } else { ?><a href="/?login=yes">Авторизация</a><?php } ?></li></li>
    					<li><a href="#">Регистрация</a></li>
    					<li><a href="#">Забыли пароль?</a></li>
					</ul>
				    <div class="clearfix"></div>
				</div>              
				<div class="index-auth">
                <?php 
                    if (isset($_GET['login']) && $_GET['login'] == "yes"):
                        if (!$message): ?>
                    <form action="/?login=yes" method="POST">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td class="iat">
                                    <?php if (isset($_COOKIE['loginName'])): ?>
                                        <label for="login_id">Здраствуйте, <?= $_COOKIE['loginName'] ?>!</label>
                                        <input type="hidden" id="login_id" name="login" value=<?= $_COOKIE['loginName'] ?>>
                                    <?php else: ?>
                                    <label for="login_id">Ваш e-mail:</label>
                                    <input id="login_id" size="30" name="login" value=<?= $_POST['login'] ?? '' ?>>
                                    <?php endif; ?>
                                </td>
							</tr>
							<tr>
								<td class="iat">
                                    <label for="password_id">Ваш пароль:</label>
                                    <input id="password_id" size="30" name="password" type="password" value=<?= $_POST['password'] ?? '' ?>>
                                </td>
							</tr>
                            <?php if (!$message && isset($_POST['send'])): ?>
                            <tr>
								<td class="iat">
                                    <?php include $_SERVER['DOCUMENT_ROOT'] . "/template/error.php" ?>
                                </td>
							</tr>
                            <?php endif; ?>
							<tr>
								<td><input type="submit" name="send" value="Войти"></td>
							</tr>
						</table>
                    </form>
                <?php else: 
                    include $_SERVER['DOCUMENT_ROOT'] . "/template/success.php";
                    endif; 
                endif;?>
                </div>
			</td>
        </tr>
    </table>
  
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php";
?>    
