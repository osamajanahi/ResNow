<?php
if (!isset($_POST['contactusbtn']))
{
    header("location:contactus.php");
}
try
{
    $textval = "/^[a-z\s]{2,}$/i";
    $emailval="/^(?=.*[a-z])[a-z0-9][a-z0-9-._]{1,}@[a-z]{2,}\.[a-z]{2,6}$/i";
    if (!preg_match($textval, $_POST['name']))
    {
        header("location:contactus.php?error=field name is invalid, make sure to enter letter only");
        die();
    }
    if (!preg_match($textval, $_POST['subject']))
    {
        header("location:contactus.php?error=field name is invalid, make sure to enter letter only");
        die();
    }
    if (!preg_match($emailval, $_POST['email']))
    {
        header("location:contactus.php?error=the email is invalid, make sure to enter the right email");
        die();
    }
    $msg = trim($_POST['text']);
    $msg = stripslashes($msg);
    $msg = htmlspecialchars($msg);
    require ("connection.php");
    $sql = "INSERT INTO contactus VALUES(null,:name,:email,:subject,:message)";
    $stmt = $db->prepare($sql);
        $stmt->execute(array(
            ':name' => $_POST['name'],
            ':email' => $_POST['email'],
            ':subject' => $_POST['subject'],
            ':message' => $msg
        ));
        header('location:index.php');
}
catch(PDOException $e)
{
    die($e->getMessage());
}
?>
