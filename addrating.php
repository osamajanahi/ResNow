<?php
if (!isset($_POST['resid']))
{
    header("location:index.php");
}
try
{
    $comment="/^[a-z\s0-9?!#@$%,.()]{4,}$/i";
    if (!preg_match($comment, $_POST['comment']))
    {
        header("location:reservations.php?error=could not add comment, comment are too short or contains invalid character");
        die();
    }
    require ("connection.php");
    $db->beginTransaction();
    $sql = "SELECT id,userid,fieldid FROM reservation WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        $_POST['resid']
    ));
    if ($data = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        if (isset($_POST['rating']))
        {
            $sql = "UPDATE reservation SET rating= ? WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                $_POST['rating'],
                $_POST['resid']
            ));
            $sql = "SELECT AVG(rating) FROM reservation WHERE fieldid=?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($data['fieldid']));
            if($avg = $stmt->fetch(PDO::FETCH_NUM)){
            $sql = "UPDATE fields SET rating= ? WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                $avg[0],
                $data['fieldid']));
            }else{
                $db->rollBack();
                die("something went wrong");
            }

        }
        $sql = "INSERT INTO comments VALUES(null,:uid,:fid,:resid,:comment)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            ':uid' => $data['userid'],
            ':fid' => $data['fieldid'],
            ':resid' => $data['id'],
            ':comment' => $_POST['comment']
        ));
        $db->commit();
        $fid=$data['fieldid'];
        header("location:reservepage.php?card=$fid");
    }
}
catch(PDOException $e)
{
    $db->rollBack();
    die($e->getMessage());
}
?>
