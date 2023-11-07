<?php 
    require_once 'config.php'; // On inclu la connexion à la bdd

    // Si les variables existent et qu'elles ne sont pas vides
    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['numero']) && !empty($_POST['poste']) && !empty($_POST['grade']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        // Patch XSS
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $numero = htmlspecialchars($_POST['numero']);
        $poste = htmlspecialchars($_POST['poste']);
        $grade = htmlspecialchars($_POST['grade']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);

        // On vérifie si l'utilisateur existe
        $check = $bdd->prepare('SELECT nom, email, password FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

       
        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        if($row == 0){ 
           
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){ 
                        if($password === $password_retype){ // si les deux mdp saisis sont bon

                            $password = hash('sha256',$password);
                            // On insère dans la base de données
                            $insert = $bdd->prepare('INSERT INTO utilisateurs(nom, prenom, email, numero, poste, grade, password) VALUES(:nom, :prenom, :email, :numero, :poste, :grade, :password)');
                            $insert->execute(array(
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'email' => $email,
                                'numero' => $numero,
                                'poste' => $poste,
                                'grade' => $grade,
                                'password' => $password,
                            ));
                            // On redirige avec le message de succès
                            header('Location:inscription.php?reg_err=success');
                            die();
                        }else{ header('Location: inscription.php?reg_err=password'); die();}
                    }else{ header('Location: inscription.php?reg_err=email'); die();}
        }else{ header('Location: inscription.php?reg_err=already'); die();}
    }