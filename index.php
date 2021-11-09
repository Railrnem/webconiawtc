<?php
$vornameErr = $nachnameErr = $emailErr = $firmaErr = "";
$vorname = $nachname = $email = $firma = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (empty($_POST["vorname"])) {
    $vornameErr = "Vorname wird benötigt";
    } else 
    {
    $vornameErr = "";
    $vorname = test_input($_POST["vorname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$vorname)) 
    {
        $vornameErr = "Es sind nur Buchstaben und Leerzeichen erlaubt";
    }
    }

  if (empty($_POST["nachname"])) 
    {
    $nachnameErr = "Nachname wird benötigt";
    } else 
    {
    $nachnameErr = "";
    $nachname = test_input($_POST["nachname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$nachname)) 
    {
        $nachnameErr = "Es sind nur Buchstaben und Leerzeichen erlaubt";
    }
    }

  if (empty($_POST["email"])) 
  {
    $emailErr = "Email wird benötigt";
  } else 
  {
    $emailErr = "";
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $emailErr = "Invalid email format";
    }
  }

  if (empty($_POST["firma"])) 
  {
    $firmaErr = "Firma wird benötigt";
  } else 
  {
    $firmaErr = "";
    $firma = test_input($_POST["firma"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$firma)) 
    {
        $firmaErr = "Es sind nur Buchstaben und Leerzeichen erlaubt";
    }
  }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>WTC Teilnahmebestätigung</title>
</head>

<body>
    <p>* benötigte Felder</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        Vorname:  <input type="text" name="vorname" value="<?php echo $vorname;?>"><span class="error">* <?php echo $vornameErr;?></span><br>
        Nachname: <input type="text" name="nachname" value="<?php echo $nachname;?>"><span class="error">* <?php echo $nachnameErr;?></span><br>
        E-Mail:   <input type="text" name="email" value="<?php echo $email;?>"><span class="error">* <?php echo $emailErr;?></span><br>
        Firma:    <input type="text" name="firma" value="<?php echo $firma;?>"><span class="error">* <?php echo $firmaErr;?></span><br>
        <input type="submit" name="Submit">
    </form>
</body>

</html>
<?php
    if(isset($_POST['Submit'])){ 
        if($vornameErr == "" && $nachnameErr == "" && $emailErr == "" && $firmaErr == "")
        {
            include "private/dbconnection.inc.php";

            $con = new mysqli($servername, $username, $password, $dbname);

            if($con->connect_error)
            {
                die("Connection failed: " . $con-connect_error);
            }

            $sql = "INSERT INTO `teilnehmer` (`t_id`, `vorname`, `nachname`, `email`, `firma`) VALUES (NULL, '"
                . $vorname .  "', '" 
                . $nachname . "', '" 
                . $email .    "', '" 
                . $firma .    "');";
            
            if($con->query($sql) === TRUE)
            {
                echo "Erfolgreich eingetragen!";;
            }
            else
            {
                echo $sql;
                echo "Datenbank Eintrag fehlgeschlagen";
            }

            $con->close();
        }
    }
?>
    