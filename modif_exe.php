<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exercice";

//création de la connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Tester la connexion
if (!$conn) {
    die("Connection failed : " . mysqli_connect_error());
}

//Suite a l'appel de la page on recupere l'ID de l'exercice en question
if(isset($_GET["id"])){

    //protection des données
    $idm = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "SELECT * FROM exercice WHERE id=$idm";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows ($result) > 0) {
        //on recupere les informations de l'exercice en question qui seront par la suite afficher dans le formulaire en bas
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];
        $titre = $row["titre"];
        $auteur = $row["auteur"];
        $date = $row["date_creation"];
    

}else{
    //si il y a une erreur d envoie a la page exercice.php
    $message = "L'exercice est in trouvable";
    header("Location:exercice.php?message=$message");
}
}
//suite au clic sur le bouton modifier on recupere les données envoyées
if(count($_POST)>3) {
    $titre = mysqli_real_escape_string($conn, $_POST["titre"]);
    $auteur = mysqli_real_escape_string($conn, $_POST["auteur"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sql = "update exercice set titre='{$titre}', auteur='{$auteur}', date_creation='{$date}'
    WHERE id=$id";

    //executer la requete de l'update et rediriger vers la page exercice.php
    if (mysqli_query($conn, $sql)){
        $message = "L'exercice a été mis à jour avec succés";
    } else {
        $message = "Error : " . $sql . "<br>" . mysqli_error($conn);
    }
    header("Location:exercice.php?message=$message");
}
?>

<!--On affiche le formulaire remplit par les données de l exercice récupéré en haut--> 
<form name="exe" action="modif_exe.php" method="post">
    <fieldset>
        <legend>Modifier un exercice</legend>
        <input type="hidden" id="id" name="id" value="<?php if(isset($id)) {echo $id; } ?>"><br/>
        <label for="titre">Titre de l'exercice</label>
        <input type="text" id="titre" name="titre" required value="<?php if(isset($titre)) {echo $titre; } ?>"><br/>
        <label for="auteur">Auteur de l'exercice</label>
        <input type="text" id="auteur" name="auteur" required value="<?php if(isset($auteur)) {echo $auteur; } ?>"><br/>
        <label for="date">Date de création</label>
        <input type="date" id="date" name="date" required value="<?php if(isset($date)) {echo $date; } ?>"><br/>
        <input type="submit" value="Modifier">
</fieldset>
</form>
