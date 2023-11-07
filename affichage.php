<?php

session_start();
if (!isset($_SESSION['user'])||!isset($_SESSION['poste']))
        header('Location:index.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Afficher les données</title>
</head>
<body>
    <h1>Données de la base de données</h1>
    
    <table border="1">
        <tr>
            <th>id</th>
            <th>user_id</th>
            <th>reclamation</th>
        </tr>

        <?php
        $mysqli = new mysqli("localhost", "root", "", "connexion");

        if ($mysqli->connect_error) {
            die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
        }

        $query = "SELECT * FROM reclamation";
        $result = $mysqli->query($query);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $user_id = $row['user_id'];
            $messageC = $row['message'];

            // Déchiffrement du mot de passe
           if ($_SESSION['poste']=="chefProjet" ){

            $key = 'mokh';

            // IV (vecteur d'initialisation) - assurez-vous qu'il correspond à celui utilisé pour le chiffrement
            $encryptedData = base64_decode($messageC);
            $iv = substr($encryptedData, 0, openssl_cipher_iv_length("AES-256-CBC"));
            $ciphertext = substr($encryptedData, openssl_cipher_iv_length("AES-256-CBC"));
            
            $messageC = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
                   } 
            


            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$user_id</td>";
            echo "<td>$messageC</td>";
            echo "</tr>";

        }
        
        $result->close();
        $mysqli->close();
        ?>

    </table>
    <a href="deconnexion.php" class="btn btn-danger btn-lg">Deconnexion </a>
        
    
</body>
</html>