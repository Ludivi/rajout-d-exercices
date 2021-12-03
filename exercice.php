<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exercice";

//Creation de la connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Tester la connexion
if (!$conn) {
    die("Connection failed : " . mysqli_connect_error());
}

//Suite au clic sur le bouton envoyer on envoie les données par post
if(count($_POST)>2) {
    //récupération et protection des données envoyées
    $titre = mysqli_real_escape_string($conn, $_POST["titre"]);
    $auteur = mysqli_real_escape_string($conn, $_POST["auteur"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $sql = "INSERT INTO exercice (titre, auteur, date_creation)
    VALUES ('{$titre}', '{$auteur}', '{$date}')";

    //executer la requete d'insertion
    if (mysqli_query($conn, $sql)) {
        $message= "L'exercice a été rajouté avec succés";
    }else {
        $message = "Error : " .$sql . "<br>" . mysqli_error($conn);
    }
}

//les autres pages envoyer un message dans l'URL : on le récupére
if(isset($_GET["message"])) {
    $message=$_GET["message"];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP rajouts exercices</title>
        <meta charset="utf-8">
        <style type="text/css">

            /*Des styles pour la mise en forme de la page */ 
            div{
                margin: auto;
                width: 600px;
                margin-bottom: 20px;
            }
            label{
                display: block;
                width: 150px;
                float: left;
            }

            thead{
                background: #f39c12;
            }

            tbody{
                background: #3498db;
                color: white;
            }

            td, th{
                width: 100px;
                text-align: center;
                border: 1px solid white;
            }

            a{
                color: white;
            }

            .message{
                background: #d35400;
                color: white;
                padding: 5px;
            }
            </style>
            </head>

        
            <body>

<?php if(isset($message)) { echo "<div class='message'>".$message."</div>"; } ?>
<div class="frm">

<form name="exe" action="exercice.php" method="post">
    <fieldset>
        <legend>Ajouter un exercice</legend>

        <label for="titre">Titre de l'exercice</label>
        <input type="text" id="titre" name="titre" required autofocus><br/>
        <label for="auteur">Auteur de l'exercice</label>
        <input type="text" id="auteur" name="auteur" required><br/>
        <label for="date">Date de creation</label>
        <input type="date" id="date" name="date" required placeholder="YYYY/MM/DD"><br/>
        <input type="submit" value="Envoyer">
        </fieldset>
        </form>

        </div>

        <div class="grid">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Date</th>
                        <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>

        <!--Recupération de la liste des exercices-->
        <?php
        $sql = "SELECT * FROM exercice";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            //parcourir les lignes de resultats

            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td> " . $row["id"]. "</td><td>" . $row["titre"]. "</td><td>" . $row["auteur"]."</td><td>" . $row["date_creation"] 
        					."</td><td><a href=\"modif_exe.php?id=".$row["id"]."\">Modifier</a></td>"
        					."</td><td><a href=\"supp_exe.php?id=".$row["id"]."\" onclick=\"return confirm('Vous voulez vraiment supprimer cet exercice')\">Supprimer</a></td></tr>";
    					}

    					          //Le lien modifie l envoie vers la page modif_exe.php avec l'id de l'exercice
                        //Le lien supprimé l envoie vers la page supp_exe.php avec l'id de l exercice 
                        //L'attribue "onlick" fait appel à la fonction confirm() afin de permettre à l'utilisateur de valider l'action de suppression
            }
            ?>
            <tbody>
        </table>
        </div>
        </body>
        </html>
        
