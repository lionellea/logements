<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace StatBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use src\AppBundle\Entity;
use DateTime;
use src\StatBundle\Service;

/**
 * Description of StatUserController
 *
 * @author georges
 */
class StatUserController extends Controller{
    
    public function statAction(Request $request){
        
                  
// récupération des données de la vue
    $request = Request::createFromGlobals();
    $type=$request->query->get("type");
    $categorie=$request->query->get("categorie");
    $debut=$request->query->get("debut");
    $fin=$request->query->get("fin");
    $identifiant=$request->query->get("identifiant");
//    echo $type;            
//transformer la date
    $dateDebut = new DateTime();
    $dateFin = new DateTime();

    if ($debut != "") {
        $dateDebut->setDate(substr($debut, strrpos($debut, "-") + 1), substr($debut, strpos($debut, "-") + 1, (strrpos($debut, "-") - strpos($debut, "-") - 1)), substr($debut, 0, strpos($debut, "-")));

    } else {
        $dateDebut = NULL;
    }

    if ($fin != "") {
        $dateFin->setDate(substr($fin, strrpos($fin, "-") + 1), substr($fin, strpos($fin, "-") + 1, (strrpos($fin, "-") - strpos($fin, "-") - 1)), substr($fin, 0, strpos($fin, "-")));
    } else {
        $dateFin = NULL;
    }
//    var_dump($dateFin);
    $agregation= array(array('COUNT','o'));
//charger les tableaux avec les données de la vue
    $distinct= array();
    $attribut= array('t.nom_fr');
    $egalite=array();
    for($i=0; $i< (count($categorie)); $i++){
    $egal=array();
    $egal =array('t.nom_fr', $categorie[$i]);
    array_push($egalite, $egal);
    }
    $counDistinct= array();
    $difference=array();
    $contraire= array();
    $inferieur=array();
    $superieur=array();
    $superieurEgale=array();
    $inferieurEgale=array();
    $in= array();
    if($dateDebut != null AND $dateFin != null){

        $between=array('o.date',$dateDebut,$dateFin); 

    }elseif($dateDebut != null AND $dateFin == null){
     $dateFin = date("Y-m-d H:i:s");
        $between=array('o.date',$dateDebut,$dateFin);
     }elseif ($dateDebut == null AND $dateFin != null) {
        $dateDebut = date("Y-m-d H:i:s");    
         $between=array('o.date',$dateDebut,$dateFin);
    }else{
     $between= array();
    }
    $notBetween= array();
    $like=array();
    $isNull=array();
    $isNotNull=array();
    if(count($categorie) == 1 ){
    $groupBy= array();
    } else{
     $groupBy= array('t.nom_fr');
    }
    $orderBy= array();
    if($type=="tout"){
     $from = array(array('AppBundle:Observations', 'o'),array('typeObservations', 't'));
            $req= $this->container->get('Stat.select');
            $SELECT=$req->partieSelect($distinct,$agregation,$attribut,$counDistinct);
            $FROM =$req->partieFrom($from);
            $JOIN=$req->partieJoin($from);
            $WHERE=$req->partieWhere($egalite,$difference,$contraire,$inferieur,$superieur,$superieurEgale,$inferieurEgale,$in,$between,$notBetween
         ,$like,$isNull,$isNotNull);
            $GROUPBY=$req->partieGroupBy($groupBy);
            $ORDERBY=$req->partieOrderBy($orderBy); 
            
// mettre le tout dans une variable représentant notre requete
                    $resultat = $SELECT.$FROM.$JOIN.$WHERE.$GROUPBY.$ORDERBY;
//                    echo $resultat;
//                    echo $date = date('Y-m-d H:i:s');
//                    echo $date->format('Y-m-d H:i:s');
// faire appel au service de la couche metier de symfony                    
                    $query = $this->getDoctrine()
                                  ->getManager()
                                  ->createQuery($resultat);
                    
                    
                    
//charger les paramètres nécessaires à l'execution de la requete
                    if(isset($egalite) AND !empty($egalite)){
                        if(count($egalite)>1){

                            $param= array();
                        for($i=0; $i< count($egalite); $i++){
                            $param['egalite'.$i] = $egalite[$i][1];  
                        }
                            $query->setParameters($param);
                        }  else {
                            $param= array();
                            $param['egalite'] = $egalite[count($egalite)-1][1];
                            $query->setParameters(array($param));

                        }

                    }
                    if(isset($difference) AND !empty($difference)){
                        if(count($difference)>1){

                            $param= array();
                        for($i=0; $i< count($difference); $i++){
                            $param['difference'.$i] = $difference[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['difference'] = $difference[count($difference)-1][1];
                        $query->setParameters(array($param));

                        }

                    }
                    if(isset($contraire) AND !empty($contraire)){
                        if(count($contraire)>1){

                            $param= array();
                        for($i=0; $i< count($contraire); $i++){
                            $param['contraire'.$i] = $contraire[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['contraire'] = $contraire[count($contraire)-1][1];
                        $query->setParameters(array($param));

                        }
                     }
                    if(isset($inferieur) AND !empty($inferieur)){
                        if(count($inferieur)>1){

                            $param= array();
                        for($i=0; $i< count($inferieur); $i++){
                            $param['inferieur'.$i] = $inferieur[$i][1];  
                         }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['inferieur'] = $inferieur[count($inferieur)-1][1];
                        $query->setParameters(array($param));

                        }
                     }
                    if(isset($superieur) AND !empty($superieur)){
                        if(count($superieur)>1){

                            $param= array();
                        for($i=0; $i< count($superieur); $i++){
                            $param['superieur'.$i] = $superieur[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['superieur'] = $superieur[count($superieur)-1][1];
                        $query->setParameters(array($param));

                     }
                    }
                     if(isset($superieurEgale) AND !empty($superieurEgale)){
                        if(count($superieurEgale)>1){

                            $param= array();
                        for($i=0; $i< count($superieurEgale); $i++){
                            $param['superieurEgale'.$i] = $superieurEgale[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['superieurEgale'] = $superieurEgale[count($superieurEgale)-1][1];
                        $query->setParameters(array($param));

                     }
                   }
                     if(isset($inferieurEgale) AND !empty($inferieurEgale)){
                        if(count($inferieurEgale)>1){

                            $param= array();
                        for($i=0; $i< count($inferieurEgale); $i++){
                            $param['inferieurEgale'.$i] = $inferieurEgale[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['inferieurEgale'] = $inferieurEgale[count($inferieurEgale)-1][1];
                        $query->setParameters(array($param));

                     }
                    }
                     
                     if (isset($between) AND !empty($between)){
                        $query->setParameter('between1', $between[1]);
                        $query->setParameter('between2', $between[2]);
                     }

                     if (isset($notBetween) AND !empty($notBetween)){
                        $query->setParameter('notbetween1', $notBetween[1]);
                        $query->setParameter('notbetween2', $notBetween[2]);
                     }
                     
                    // ajout des couleur au tableau retourné par doctrine 
                    $resultats = $query->getArrayResult();     
                    
                    if (count($resultats)== 0){
                        $template= $this->render('StatBundle:StatUser:messageError.html.twig')->getContent();
                        $response = array();
                        $response['message']=$template;
                        return new Response(json_encode($response)); 
                    }else{
                    $template= $this->render('StatBundle:StatUser:affichage.html.twig', array( 'resultats' => $resultats))->getContent();
                    $response = array();
                    $response['message']=$template;
                   return new Response(json_encode($response));
                    }
    }elseif ($type=="mes") {
     $from = array(array('AppBundle:Observations', 'o'),array('utilisateurs', 'u'),array('typeObservations', 't'));
        
        $id= 'u.id';
        $req= $this->container->get('StatUser.select');
        $SELECT=$req->partieSelect($distinct,$agregation,$attribut,$counDistinct);
        $FROM =$req->partieFrom($from);
        $JOIN=$req->partieJoin($from);
        $WHERE=$req->partieWhere($egalite,$difference,$contraire,$inferieur,$superieur,$superieurEgale,$inferieurEgale,$in,$between,$notBetween
     ,$like,$isNull,$isNotNull,$id);
        $GROUPBY=$req->partieGroupBy($groupBy);
        $ORDERBY=$req->partieOrderBy($orderBy);
                     
//charger le service de construction des statistiques
                        
                       
// mettre le tout dans une variable représentant notre requete
                    $resultat = $SELECT.$FROM.$JOIN.$WHERE.$GROUPBY.$ORDERBY;
//                    echo $resultat;
//                    echo $date = date('Y-m-d H:i:s');
//                    echo $date->format('Y-m-d H:i:s');
// faire appel au service de la couche metier de symfony                    
                    $query = $this->getDoctrine()
                                  ->getManager()
                                  ->createQuery($resultat);
                    
                    
                    
//charger les paramètres nécessaires à l'execution de la requete
                    if(isset($egalite) AND !empty($egalite)){
                        if(count($egalite)>1){

                            $param= array();
                        for($i=0; $i< count($egalite); $i++){
                            $param['egalite'.$i] = $egalite[$i][1];  
                        }
                            $param['id'] = $identifiant;
                            $query->setParameters($param);
                        }  else {
                            $param= array();
                            $param['egalite'] = $egalite[count($egalite)-1][1];
                            $param['id'] = $identifiant;
                            $query->setParameters(array($param));

                        }

                    }else{
                        $query->setParameter('id', $identifiant);
                    }
                    if(isset($difference) AND !empty($difference)){
                        if(count($difference)>1){

                            $param= array();
                        for($i=0; $i< count($difference); $i++){
                            $param['difference'.$i] = $difference[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['difference'] = $difference[count($difference)-1][1];
                        $query->setParameters(array($param));

                        }

                    }
                    if(isset($contraire) AND !empty($contraire)){
                        if(count($contraire)>1){

                            $param= array();
                        for($i=0; $i< count($contraire); $i++){
                            $param['contraire'.$i] = $contraire[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['contraire'] = $contraire[count($contraire)-1][1];
                        $query->setParameters(array($param));

                        }
                     }
                    if(isset($inferieur) AND !empty($inferieur)){
                        if(count($inferieur)>1){

                            $param= array();
                        for($i=0; $i< count($inferieur); $i++){
                            $param['inferieur'.$i] = $inferieur[$i][1];  
                         }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['inferieur'] = $inferieur[count($inferieur)-1][1];
                        $query->setParameters(array($param));

                        }
                     }
                    if(isset($superieur) AND !empty($superieur)){
                        if(count($superieur)>1){

                            $param= array();
                        for($i=0; $i< count($superieur); $i++){
                            $param['superieur'.$i] = $superieur[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['superieur'] = $superieur[count($superieur)-1][1];
                        $query->setParameters(array($param));

                     }
                    }
                     if(isset($superieurEgale) AND !empty($superieurEgale)){
                        if(count($superieurEgale)>1){

                            $param= array();
                        for($i=0; $i< count($superieurEgale); $i++){
                            $param['superieurEgale'.$i] = $superieurEgale[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['superieurEgale'] = $superieurEgale[count($superieurEgale)-1][1];
                        $query->setParameters(array($param));

                     }
                   }
                     if(isset($inferieurEgale) AND !empty($inferieurEgale)){
                        if(count($inferieurEgale)>1){

                            $param= array();
                        for($i=0; $i< count($inferieurEgale); $i++){
                            $param['inferieurEgale'.$i] = $inferieurEgale[$i][1];  
                        }
                        $query->setParameters($param);
                        }  else {
                        $param= array();
                        $param['inferieurEgale'] = $inferieurEgale[count($inferieurEgale)-1][1];
                        $query->setParameters(array($param));

                     }
                    }
                     
                     if (isset($between) AND !empty($between)){
                        $query->setParameter('between1', $between[1]);
                        $query->setParameter('between2', $between[2]);
                     }

                     if (isset($notBetween) AND !empty($notBetween)){
                        $query->setParameter('notbetween1', $notBetween[1]);
                        $query->setParameter('notbetween2', $notBetween[2]);
                     }
                     $couleur = array(
                         array("color"=>"#f56954"),
                         array("color"=>"#00a65a"),
                         array("color"=>"#f39c12"),
                         array("color"=>"#00c0ef"),
                         array("color"=>"#d2d6de")
                     );
                    
                    // ajout des couleur au tableau retourné par doctrine 
                    $resultats = $query->getArrayResult();
                    
//                    print_r($resultats);
//                    echo count($resultats);
//                    $somme =0;
//                    //fait la somme pour pourcentage
//                    for($i=0; $i< count($resultats); $i++){
//                        $somme += $resultats[$i]['nombre'];
//                    }
//                    for($i=0; $i< count($resultats); $i++){
//                        $pourcentage[$i]= ($resultats[$i]['nombre']/$somme)*100;
//                    }
//                    
//                     for($i=0;$i< count($resultats); $i++){
//                        $resultats[$i]["color"]= $couleur[$i]["color"];
//                        $resultats[$i]['pourcentage']= $pourcentage[$i];
//              
                    if (count($resultats)== 0){
                        $template= $this->render('StatBundle:StatUser:messageError.html.twig')->getContent();
                        $response = array();
                        $response['message']=$template;
                        return new Response(json_encode($response)); 
                    }else{
                    $template= $this->render('StatBundle:StatUser:affichage1.html.twig', array( 'resultats' => $resultats))->getContent();
                    $response = array();
                    $response['message']=$template;
                   return new Response(json_encode($response));
                    }
                }
                 
                }

}
