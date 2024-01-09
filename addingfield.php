<?php
if (isset($_POST['addfield']))
{
    //valedation
    $textval = "/^[a-z\s]{2,}$/i";
    $textandnumval = "/^[a-z\s0-9]{2,}$/i";
    $numval = "/^[0-9]+$/";
    $linkval = "/^(https:\/\/www\.google\.com\/maps\/embed\?)[0-9a-z!._=%]+$/i";
    $time="/^[0-9]{2}:[0-9]{2}/";
    // no need to redirect back just die and admin can back using the browser to get the values back, if redirect inputed values will be lost, since its admin only UI not important.
    if (!preg_match($time, $_POST['start']))
    {
        die('time must be of the following format hh:mm example: 12:21 , 23:00');
    }
    if (!preg_match($time, $_POST['end']))
    {
        die('time must be of the following format hh:mm example: 12:21 , 23:00');
    }
    if (!preg_match($textandnumval, $_POST['fname']))
    {
        die('field name is invalid, make sure to enter letter and numbers only');
    }
    if (!preg_match($numval, $_POST['Avcourts']))
    {
        die('Court number are invalid, make sure to enter numbers only');
    }
    if (!preg_match($textval, $_POST['location']))
    {
        die('location are invalid, make sure to enter letters only');
    }
    if (!preg_match($linkval, $_POST['loclink']))
    {
        die('location link are invalid, make sure to copy the link only from google correctly');
    }
    if (!preg_match($numval, $_POST['price']))
    {
        die('price are invalid, make sure to enter numbers only');
    }
    $facilitytext = "";
    if (isset($_POST['facility'][0]))
    {
        $facilitytext .= 'B#';
    }
    if (isset($_POST['facility'][1]))
    {
        $facilitytext .= 'S#';
    }
    if (isset($_POST['facility'][2]))
    {
        $facilitytext .= 'W#';
    }
    if (isset($_POST['facility'][3]))
    {
        $facilitytext .= 'T#';
    }
    //main pic
    $filedata = getimagesize($_FILES['mainpic']['tmp_name']);
    if ($filedata === false)
    {
        die("please upload images only");
    }
    if ($_FILES['mainpic']['size'] > 5242880)
    {
        die("image size must be under 5MB");
    }
    $uploadfiletype = $_FILES['mainpic']['type'];
    $filestype = array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/jpg'
    );
    if (!in_array($uploadfiletype, $filestype))
    {
        die("image must be of type jpeg, jpg, png or gif");
    }

    // adding
    try
    {
        require ("connection.php");
        $db->beginTransaction();
        $arraytype = explode("/", $uploadfiletype);
        $typetext = end($arraytype);
        $trimname = trim($_POST['fname']," ");
        $mainpictext = $trimname . "-main.$typetext";
        $filelocation = "fieldspic/" . $mainpictext;
        if (!move_uploaded_file($_FILES['mainpic']['tmp_name'], $filelocation))
        {
            die('could not upload the image correctly');
        }
        $sql = "INSERT INTO fields VALUES(null,:cat,:fname,:location,:loclink,:price,null,:faci,:courtnum,:start,:end,:mainpic)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            ':cat' => $_POST['cat'],
            ':fname' => $_POST['fname'],
            ':location' => $_POST['location'],
            ':loclink' => $_POST['loclink'],
            ':price' => $_POST['price'],
            ':faci' => $facilitytext,
            ':courtnum' => $_POST['Avcourts'],
            ':start' => $_POST['start'],
            ':end' => $_POST['end'],
            ':mainpic' => $mainpictext
        ));
        $fid = $db->lastInsertId();
        $sql = "INSERT INTO fieldpic VALUES(null,$fid,:picname)";
        $stmt = $db->prepare($sql);
        //images validation
        if (isset($_FILES['fieldimg']))
        {
            for ($i = 0;$i < count($_FILES['fieldimg']['name']);$i++)
            {
                //if file is not uploaded skip it
                if ($_FILES['fieldimg']['name'][$i] == null)
                {
                    break;
                }
                $filedata = getimagesize($_FILES['fieldimg']['tmp_name'][$i]);
                if ($filedata === false)
                {
                    $db->rollBack();
                    die("please upload images only");
                }
                if ($_FILES['fieldimg']['size'][$i] > 5242880)
                {
                    $db->rollBack();
                    die("file size must be under 5MB");
                }
                $uploadfiletype = $_FILES['fieldimg']['type'][$i];
                $filestype = array(
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/jpg'
                );
                if (!in_array($uploadfiletype, $filestype))
                {
                    $db->rollBack();
                    die("file must be of type jpeg, jpg, png or gif");
                }
                $arraytype = explode("/", $uploadfiletype);
                $typetext = end($arraytype);
                $filename = $trimname . "-" . uniqid(rand()) . ".$typetext";
                $filelocation = "fieldspic/" . $filename;
                if (move_uploaded_file($_FILES['fieldimg']['tmp_name'][$i], $filelocation))
                {
                    $stmt->execute(array(
                        ':picname' => $filename
                    ));
                }

            }
        }
        $db->commit();
        header('location:control.php');
    }
    catch(PDOException $e)
    {
        $db->rollBack();
        die($e->getMessage());
    }
}
else
{
    header('location:control.php');
}

