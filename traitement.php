<?php
require_once 'config.php'; // On inclu la connexion à la bdd
// Récupération des données du formulaire
$user_id =$_POST['user_id'];
$message =$_POST['message'];

// Chiffrement du mot de passe avec OpenSSL


// Clé de chiffrement
$key = 'mokh';
// Cryptez le message
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("AES-256-CBC"));


$ciphertext = openssl_encrypt($message, 'AES-256-CBC', $key, 0, $iv);

// Vous devez stocker ou transmettre $iv avec $ciphertext pour le déchiffrement.
// Par exemple, vous pouvez concaténer $iv et $ciphertext.
$encryptedData = base64_encode($iv . $ciphertext);
// Préparez et exécutez une requête pour insérer les données
$insert = $bdd->prepare('INSERT INTO reclamation(user_id, message) VALUES(:user_id, :message)');
$insert->execute(array(
    'user_id' => $user_id,
    'message' => $encryptedData,
  
));

header('Location: affichage.php');


?>