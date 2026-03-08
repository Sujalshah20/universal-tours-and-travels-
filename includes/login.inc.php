<?php
if(isset($_POST['login_but'])) {
    require '../helpers/init_conn_db.php';   
    $email_id = $_POST['user_id'];
    $password = $_POST['user_pass'];
    $sql = 'SELECT * FROM Users WHERE username=? OR email=?;';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        header('Location: ../login.php?error=sqlerror');
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt,'ss',$email_id,$email_id);            
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $id, $uname, $mail, $pwd);
            if (mysqli_stmt_fetch($stmt)) {
                $pwd_check = password_verify($password, $pwd);
                if ($pwd_check == false) {
                    header('Location: ../login.php?error=wrongpwd');
                    exit();
                } else if ($pwd_check == true) {
                    session_start();
                    $_SESSION['userId'] = $id;
                    $_SESSION['userUid'] = $uname;
                    $_SESSION['userMail'] = $mail;
                    setcookie('Uname', $email_id, time() + (86400 * 30), "/");
                    setcookie('Upwd', $password, time() + (86400 * 30), "/");
                    header('Location: ../index.php?login=success');
                    exit();
                } else {
                    header('Location: ../login.php?error=invalidcred');
                    exit();
                }
            }
        }
        header('Location: ../login.php?error=invalidcred');
        exit();
    }
    header('Location: ../login.php?error=invalidcred');
    exit();      
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header('Location: ../login.php');
    exit();  
}    