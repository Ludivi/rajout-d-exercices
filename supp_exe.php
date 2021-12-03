<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "exercice";

//creation de la connexion
$conn = mysqli_connect($severname, $username, $password, $dbname);

//tester la connexion
if (!$conn) {
    die("Connexion failed : " . mysqli_connect_error());
}

if(!empty($_GET["id"])){
    //supprime l exercice dont l'id est envoyé avec l'URL
    $ids = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "DELETE FROM exercice WHERE id=$ids";
    echo $sql;
    if (mysqli_query($conn, $sql)) {
        $message = "L'exercice a été supprimé avec succés";
    } else {
        $message = "Erreur pendant la suppression de l'exercice : " .mysqli_error($conn);

    }
    //redirection vers la page exercice.php avec un message résultat de la suppression
    header("Location:exercice.php?message=$message");
}
