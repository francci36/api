<?php
// on vérifie si on a bien un début d'adresse
if(!empty($_GET['adresse']))
{
    $adresse = urlencode($_GET['adresse']);
    // url où on doit faire notre requete CURL
    $url =  "https://api-adresse.data.gouv.fr/search/?q=".$adresse;
    // on va initialiser curl
    $ch = curl_init();
    // on va mettre une option pour nous retourner un resultat
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    // on fait passer l'url en option
    curl_setopt($ch,CURLOPT_URL,$url);
    // on valide l'utilisation du sll (https)
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    //on va executer la requette
    $resultat = curl_exec($ch);
    //on décode le resultat json
    $resultat = json_decode($resultat);
    // on va boucler sur les resultats
    $str = [];
    $i=0;
    foreach($resultat->features as $res)
    {
        
        // on va stocker les informations
        $str[] = array(
            'label' => $res->properties->label,
            'cp' => $res->properties->postcode,
            'adresse' => $res->properties->name,
            'ville' => $res->properties->city
        );
       
        
        $i++;
    }
    
    //echo '<pre>';
    //print_r(json_decode($resultat));
    //echo '</pre>';
    //on forme notre session curl
    curl_close($ch);
    // on retour au format json notre tableau
    echo json_encode($str);

}
?>