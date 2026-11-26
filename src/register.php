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
    $check_email = $yhteys->prepare("SELECT sahkoposti FROM User WHERE sahkoposti = ?");
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
        <link rel="stylesheet" href="website.scss">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body id="register-body">
        <div class="container mt-3">
            <form action="rekisterointi.php" method="post"  class="card p-4 shadow-sm">
                <h2>Rekisteröidy</h2>

                <?php if (!empty($virheviesti)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $virheviesti; ?>
                    </div>
                <?php endif; ?>
                
                <br>
                <label for="firstname">Etunimi:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
                <br>
                <label for="lastname">Sukunimi:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
                <br>
                <label for="sahkoposti">Sähköposti:</label>
                <input type="email" class="form-control" id="sahkoposti" name="sahkoposti" required>
                <br>
                <label for="password">Salasana:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <br>
                <button type="submit" id="registerBtn" class="btn btn-primary w-100">Rekisteröidy</button>
            </form>
            <p class="mt-3 text-center">Onko sinulla jo tili? <a href="kirjautuminen.php">Kirjaudu tästä!</a></p>
        </div>


        <div>
            <form class="row g-3">
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail4">
              </div>
              <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword4">
              </div>
              <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
              </div>
              <div class="col-12">
                <label for="inputAddress2" class="form-label">Address 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
              </div>
              <div class="col-md-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity">
              </div>
              <div class="col-md-4">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" class="form-select">
                  <option selected>Choose...</option>
                  <option>...</option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="inputZip" class="form-label">Zip</label>
                <input type="text" class="form-control" id="inputZip">
              </div>
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="gridCheck">
                  <label class="form-check-label" for="gridCheck">
                    Check me out
                  </label>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Sign in</button>
              </div>
            </form>
        </div>
        
    </body>
</html>
