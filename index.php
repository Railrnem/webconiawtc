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
    if (!preg_match("/^[a-zA-Z0-9-' ]*$/",$firma)) 
    {
        $firmaErr = "Es sind nur Buchstaben, Zahlen und Leerzeichen erlaubt";
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
    <style>
      body {background: #DCDCDC;}
      h1 {text-align: center;}
      p {
        padding-left: 45%;
      }
      form {
        padding-left: 45%;
        text-align: left;
        height: 100px;
      }
      div {
        background-color: #FFFFFF;
        height: 300px;
        border: 15px;
        padding: 50px;
        margin: 100px;
      }
    </style>
</head>

<body>
    <div>
      <h1>webconia Technology Conference</h1>
      <p>* benötigte Felder</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <label for="vorname">Vorname:</label><br>
          <input type="text" name="vorname" value="<?php echo $vorname;?>"><span class="error">* <?php echo $vornameErr;?></span><br>

          <label for="vorname">Nachname:</label><br>
          <input type="text" name="nachname" value="<?php echo $nachname;?>"><span class="error">* <?php echo $nachnameErr;?></span><br>

          <label for="vorname">E-Mail:</label><br>
          <input type="text" name="email" value="<?php echo $email;?>"><span class="error">* <?php echo $emailErr;?></span><br>

          <label for="vorname">Firma:</label><br>     
          <input type="text" name="firma" value="<?php echo $firma;?>"><span class="error">* <?php echo $firmaErr;?></span><br>

          <input type="submit" name="Submit">
      </form>
    </div>
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
    