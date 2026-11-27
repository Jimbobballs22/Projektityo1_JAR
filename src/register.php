<?php
//require "yhteys.php";

// Luo muuttujan mahdollisille virheviesteille, jotka halutaan näyttää lomakkeella
$virheviesti = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // HTML-Rekisteröinti sivun tiedot
    $etunimi = $_POST["firstname"];
    $sukunimi = $_POST["lastname"];
    $sahkoposti = $_POST["sahkoposti"];
    $salasana = $_POST["password"];
    
    // Kryptaa salasanan
    $salasana_hash = password_hash($salasana, PASSWORD_DEFAULT);
    
    // Tarkistaa, että onko sähköposti jo olemassa tietokannassa (Estetään siis tuplaantumiset)
    $check_email = $yhteys->prepare("SELECT User_email FROM User WHERE User_email = ?");
    $check_email->execute([$sahkoposti]);
    
    if ($check_email->fetch()) {
        $virheviesti = "Virhe: Sähköpostiosoite on jo rekisteröity!";
        $check_email = null;
    } else {
        $check_email = null;
        
        // Valmistaa SQL-lauseen tietojen lisäämiseksi tietokantaan User kohtaan
        $rektiedot = $yhteys->prepare("INSERT INTO User (User_etunimi, User_sukunimi, User_email, User_salasanahash) VALUES (?, ?, ?, ?)");
        
        // Kertoo käyttäjälle onnistuiko
        if ($rektiedot->execute([$etunimi, $sukunimi, $sahkoposti, $salasana_hash])) {
            $rektiedot = null;
            $yhteys = null;
            // Ohjaa käyttäjän kirjautumissivulle
            header("Location: kirjautuminen.php?viesti=rekisterointi_ok");
            exit();
        } else {
            $virheviesti = "Virhe: Jotain meni pieleen!";
            $rektiedot = null;
        }
    }
}

// Sulkee tietokantayhteyden
$yhteys = null;
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekisteröityminen</title>
    <link rel="stylesheet" href="logreg.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body id="register-body">
    <div class="container">
      <form class="form row g-3 card p-4 mx-auto" action="#" method="post" id="register">
        <div class="form-title text-center">
          <h2>Rekisteröidy</h2>
        </div>

        <?php if (!empty($virheviesti)): ?>
          <div class="alert alert-danger" role="alert">
              <?php echo $virheviesti; ?>
          </div>
        <?php endif; ?>
        
        <div class="row">
          <div class="col-md-6">
            <label for="firstname" class="form-label">Etunimi</label>
            <input type="email" class="form-control" id="firstname" placeholder="ex. Matti">
          </div>
          <div class="col-md-6">
            <label for="lastname" class="form-label">Sukunimi</label>
            <input type="text" class="form-control" id="lastname" placeholder="ex. Meikäläinen">
          </div>
        </div>
        <div class="col-12">
          <label for="sahkoposti" class="form-label">Sähköposti</label>
          <input type="text" class="form-control" id="sahkoposti" placeholder="example@gmail.com">
        </div>
        <div class="col-12">
          <label for="inputpassword" class="form-label">Salasana</label>
          <input type="password" class="form-control" id="password" placeholder="password">
        </div>
        
        <div class="col-12 d-flex justify-content-center">
          <button type="submit" class="btn btn-success">Sign in</button>
        </div>
        <p class="mt-3 text-center">Onko sinulla jo tili? <a href="login.php">Kirjaudu tästä!</a></p>
      </form>
      
    </div>

    
  </body>
</html>