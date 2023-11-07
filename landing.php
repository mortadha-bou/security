<?php

session_start();
if (!isset($_SESSION['user']))
        header('Location:index.php');
?>


<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            
            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <title>Reclamation</title>
        </head>
        <body>
            <h1> Bonjour ! <?php echo $_SESSION['user']; ?></h1>
            
            <form action="traitement.php" method="post">
                <h2 class="text-center">Connexion</h2>       
                <div class="form-group">
                    <input type="text" name="user_id" class="form-control" placeholder="User" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" name="message" class="form-control" placeholder="votre Reclamation" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">envouyer</button>
                </div>   
            </form>
            

            <a href="deconnexion.php" class="btn btn-danger btn-lg">Deconnexion </a>
            <a href="affichage.php" class="btn btn-danger btn-lg">Affichage </a>
        
        
        </body>
</html>