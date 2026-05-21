<?php

$host="localhost";
$psw="";
$user="root";
$dbname="gesroad";

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",$user,$psw);
    
    
}catch(PDOException $e){
    die("erreur de connexion : " .$e->getMessage());
}



/*Pour voyage.statut :
0 = planifie
1 = en_cours
2 = termine
3 = annule
Pour reservation.statut :
0 = en_attente
1 = active
2 = annulee
Pour siege.statut :
0 = disponible
1 = reserve*
pour user
0=suspenndue
1=actif
*/
?>