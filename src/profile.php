<!DOCTYPE html>
<html lang="fi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profiili</title>
        <link rel="stylesheet" href="website.scss">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="profile-body">
        <section class="container text-center">
            <div class="row g-3 justify-content-center mx-auto">
                <div class="col-md-12">
                    <!-- Person Icon -->
                    <h1 class="display-1" style="font-size: 10rem;"><i class="bi bi-person"></i></h1>
                </div>

                <!--Below here should be coded with php the logged in person's name-->
                <div>
                    <h2>Terve [user]!</h2>
                </div>
                <!--above this line here should be coded with php the logged in person's name-->

                <div class="col-md-12">
                    <button type="submit" class="btn btn-info">Tilauksien hallinta</button>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Vaihda salasana</button>
                </div>
                
                <div class="col-md-12"> <!--make the website ask if they actually wanna log out-->
                    <button type="submit" class="btn btn-primary">Kirjaudu ulos</button>
                </div>

                <div class="col-md-12"> <!--make the website ask if they actually wanna delete their account-->
                    <button type="submit" class="btn btn-danger">Poista tili</button>
                </div>
            </div>
            
        </section>
        
    </body>
</html>