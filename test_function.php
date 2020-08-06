<?php

use PHPMailer\PHPMailer\Exception;

function sdMail($expediteur, $destinataire, $subject, $mailbody){
    


require_once 'inc/config-mail.php';

try{
    // On définit l'expéditeur du mail
    $expediteur(expMail, expNom) = $sendmail->setFrom('no-reply@domaine.fr', 'nomExpediteur');

    // On définit le/les destinataire(s)
    $sendmail->addAddress('destinataire@sondomaine.fr', 'nomDestinataire');

    // On définit le sujet du mail
    $sendmail->Subject = 'Ceci est le sujet du message';

    // On active le HTML
    $sendmail->isHTML();

    // On écrit le contenu du mail
    // En HTML
    $sendmail->Body = "<h1>Message de Blog</h1>
                       <p>Ceci est un message très important</p>";
    
    // En texte brut
    $sendmail->AltBody = "Texte du message en mode 'Texte brut'";

    // On envoie le mail
    $sendmail->send();
    echo "Mail envoyé";


}catch(Exception $e){
    // Ici le mail n'est pas parti
    echo 'Erreur : ' . $e->errorMessage();


}

}

require_once '../inc/config-mail.php';
        
// Ce fichier enverra un mail dès son chargement
try{
    // On définit l'expéditeur du mail
    $sendmail->setFrom('no-reply@mondommaine.fr', 'Blog');

    // On définit le/les destinataire(s)
    $sendmail->addAddress($mailusers, $nomusers);

    // On définit le sujet du mail
    $sendmail->Subject = 'Confirmation d\'inscription';

    // On active le HTML
    $sendmail->isHTML();

    // On écrit le contenu du mail
    // En HTML
    $sendmail->Body = "<h1>Message de Blog</h1>
                       <p>Félicitation $nomusers, vous êtes désormais inscrit.</p>";

    // En texte brut
    $sendmail->AltBody = "L'user \"$nomusers\" viens d'être inscrit";

    // On envoie le mail
    $sendmail->send();
    // echo "Mail envoyé";

    

}catch(Exception $e){
    // Ici le mail n'est pas parti
    echo 'Erreur : ' . $e->errorMessage();
}