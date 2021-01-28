<?php
 require_once("../BD/connexion.php");
 $tab=array();

 function lister(){
    global $tab,$connexion;
    $chemin ='C:\\xampp\\htdocs\\EquipeProjetGL2\\assets\\images\\photoCircuit\\';

    $requete="SELECT * FROM circuit";
  
    try{
        $listeCircuits=mysqli_query($connexion,$requete);
        $tab[0]="OK";
        $i=1;
        while($ligne=mysqli_fetch_object($listeCircuits)){

               $requete1 = "SELECT  photo.fichierPhoto 
               FROM photocircuit 
               LEFT JOIN photo 
               ON photocircuit.idPhoto = photo.idPhoto 
               WHERE actif = 1 
               AND cardPhoto = 1 
               AND idCircuit = $ligne->idCircuit";
               $listePhoto=mysqli_query($connexion, $requete1);

               $tab[$i]=array();
               $tab[$i]['nomCircuit']=$ligne->nomCircuit;
               $tab[$i]['descriptionCourteCircuit']=$ligne->descriptionCourteCircuit;
               $tab[$i]['descriptionLongueCircuit']=$ligne->descriptionLongueCircuit;
               $tab[$i]['infoGeneraleCircuit']=$ligne->infoGeneraleCircuit;
               $tab[$i]['datePremierJourCircuit']=$ligne->datePremierJourCircuit;
               $tab[$i]['prixRegulierCircuit']=$ligne->prixRegulierCircuit;
               $tab[$i]['detailVersement']=$ligne->detailVersement;
               


               while($ligne2=mysqli_fetch_object($listePhoto)){

                    $er = $ligne2->fichierPhoto;
                    $path = $chemin.$er;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = base64_encode($data);


                   $tab[$i]['fichierPhoto']=  $base64;


               }

            
            $i++;
        }

    }catch (Exception $e){
        $tab[0]="NOK";
    }finally {
       echo json_encode($tab);
       
    }
}

$action=$_POST['action'];
switch ($action) {
    case 'lister':
        lister();
        break;
    
}

// if (isset($_POST['lister'])) {
//     lister();
// }

 mysqli_close($connexion);