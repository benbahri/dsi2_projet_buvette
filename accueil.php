<!doctype html>
<?php require_once("connect.php"); ?>
<html>
<head>
  <meta charset="UTF­8">
  <title>EUROBuvettes</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <section name="header" class="header">
    <div id="banner" class="banner">
      <img class="logo" href="img/logo.jpg"  />
      <div>
        <span class="title">EUROBuvettes</span>
        <span class="subtitle">Le site de gestion des buvettes de l'EURO 2018</span>
      </div>
    </div>
    <div id="menu" class="menu">
      <ul>
        <li><a href="accueil.php">Nouveauté</a></li>
        <li><a href="statistiques.php">Statistiques</a></li>
        <li><a href="recherchemembres.php">Recherche Membres</a></li>
        <li><a href="affectations.php">Affectations</a></li>
        <li><a href="prive.php">Administrateur</a></li>
      </ul>
    </div>

  </section>
  <section name="container" class="container">
    <?php
      $requete = "SELECT  m.idM, m.date, a.pays as paysA, b.pays as paysB, a.drapeau as drapeauA, b.drapeau as drapeauB, scoreA, scoreB, COUNT(eo.idB) as nb_bo
                  from `Match` m, `Equipe` a, `Equipe` b, `Est_ouverte` eo
                  where a.idE=m.eqA
                  and b.idE=m.eqB
                  and eo.idM = m.idM
                  GROUP BY eo.idM
                  ";

      $result = mysqli_query($idConnexion , $requete) or die("Error") ;
      $num_rows = mysqli_num_rows($result);
      if($num_rows == 0)
        echo 'Aucun enregistrement trouvé';
      else {

    ?>

    <table border="1" width="80%" align = "center ">
      <tbody>
        <th>Date du Match</th>
        <th>Equipe A</th>
        <th>Equipe B</th>
        <th>Score</th>
        <th>Buvettes Ouvertes</th>
        <th>Volontaires</th>
      </tbody>

    <?php
      while ($row = $result->fetch_array()){
        $requete_nbV = "SELECT count(*) from `Est_present` ep WHERE ep.idM = ".$row['idM']." GROUP BY ep.idM" ;
        $row_nbV = mysqli_query($idConnexion , $requete_nbV) or die("Error") ;
        $nbV = $row_nbV->fetch_array();
        echo "
          <tr>
            <td>".
              $row['date'].
            "</td>

            <td><img src=\"".$row['drapeauA']."\" alt=\"".$row['paysA']."\"/></td>
            <td><img src=\"".$row['drapeauB']."\" alt=\"".$row['paysB']."\"/></td>
            <td>".$row['scoreA']." - " .$row['scoreB']."</td>
            <td>".$row['nb_bo']."</td>
            <td>".$nbV[0]."</td>

          </tr>
        ";
      }

    ?>
    </table>

  <?php } ?>
  </section>
  <section name="footer" class="footer">
    <div>
      Pied de page
    </div>
  </section>
