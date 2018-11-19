<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace StatBundle\Service;

/**
 * Description of StatSelectUser
 *
 * @author georges
 */
class StatSelectUser {
    
        public function partieSelect($distinct,$agregation,$attribut,$counDistinct){
            $SELECT='SELECT ';
             if(strlen($SELECT)== 7){
                if (isset($distinct) AND !empty($distinct)){
                        $SELECT .= 'DISTINCT '.$distinct.'';

                 }
             }  else {
                  if (isset($distinct) AND !empty($distinct)){
                        $SELECT .= ', DISTINCT '.$distinct.'';
                    } 
             }
             if(strlen($SELECT)== 7){
                if(isset($agregation) AND !empty($agregation)){
                     for($i=0; $i< count($agregation); $i++ ){

                        $SELECT .= $agregation[$i][0].'('. $agregation[$i][1].') AS nombre';

                     }
                    }
             }  else {
                 if(isset($agregation) AND !empty($agregation)){
                     for($i=0; $i< count($agregation); $i++ ){

                        $SELECT .= ', '.$agregation[$i][0].'('. $agregation[$i][1].') AS nombre';

                     }
                    }
             }
             if(strlen($SELECT)== 7){
                if (isset($attribut) AND !empty($attribut)){
                    for($i=0; $i< count($attribut)-1; $i++ ){
                        $SELECT .= $attribut[$i].' AS attribut,';
                    }
                    $SELECT .= $attribut[count($attribut)-1].' AS attribut';
                }
             }else{
                if (isset($attribut) AND !empty($attribut)){
                    for($i=0; $i< count($attribut)-1; $i++ ){
                        $SELECT .= ','.$attribut[$i].' AS attribut';
                    }
                    $SELECT .= ','.$attribut[count($attribut)-1].' AS attribut';
                } 
             } 

             if(strlen($SELECT)== 7){
                if (isset($counDistinct) AND !empty($counDistinct)){
                        $SELECT .= 'COUNT(DISTINCT '.$counDistinct.' ) AS nombre';

                 }
             }  else {
                  if (isset($counDistinct) AND !empty($counDistinct)){
                        $SELECT .= ', COUNT( DISTINCT '.$counDistinct.' ) AS nombre';
                    } 
             }

             return $SELECT;
     }
     public function partieFrom($from){
         $FROM='';
         if(isset($from) AND !empty($from)){
                 $FROM .= ' FROM '.$from[0][0].' '.$from[0][1];

         }
         return $FROM;

     }

     public function partieJoin($from){
         $JOIN='';
         if(isset($from) AND !empty($from)){

             if (count($from)> 1){
                 for($i=1; $i<count($from); $i++){
                     $JOIN .= ' JOIN '.$from[0][1].'.'.$from[$i][0].' '.$from[$i][1];
                 }
             } 
         }
         return $JOIN;
     }

      public function partieWhere($egalite,$difference,$contraire,$inferieur,$superieur,$superieurEgale,$inferieurEgale,$in,$between,$notBetween
             ,$like,$isNull,$isNotNull,$id){
         $WHERE= ' WHERE ';

        if(count($egalite)>1){
         if (strlen($WHERE)== 7){
             if (isset($egalite) AND !empty($egalite)){
             $WHERE.= '(';
             for($i=0; $i< (count($egalite)-1); $i++){

                 $WHERE .= $egalite[$i][0].' = :egalite'.$i.' OR ';
             }
             $j=count($egalite)-1;
             $WHERE.= $egalite[$j][0].' = :egalite'.$j.')';
            }
         }  else {
              if (isset($egalite) AND !empty($egalite)){
                 $WHERE.=' AND (';
                for($i=0; $i< (count($egalite)-1); $i++){
                 $WHERE .= $egalite[$i][0].'= :egalite'.$i.' OR ';
                }
                $j=count($egalite)-1;
             $WHERE.= $egalite[$j][0].' = :egalite'.$j.')';
            }
         }
        }  else {
            if (strlen($WHERE)== 7){
             if (isset($egalite) AND !empty($egalite)){

             $WHERE.= $egalite[count($egalite)-1][0].' = :egalite ';
            }
         }  else {
              if (isset($egalite) AND !empty($egalite)){
             $WHERE.= ' AND '.$egalite[count($egalite)-1][0].' = :egalite ';

            }
        }
        }
        
        if(count($difference)>1){
         if (strlen($WHERE)== 7){
             if (isset($difference) AND !empty($difference)){
             $WHERE.= '(';
             for($i=0; $i< (count($difference)-1); $i++){

                 $WHERE .= $difference[$i][0].' <> :difference'.$i.' OR ';
             }
             $j=count($difference)-1;
             $WHERE.= $difference[$j][0].' <> :difference'.$j.')';
            }
         }  else {
              if (isset($difference) AND !empty($difference)){
                 $WHERE.=' AND (';
                for($i=0; $i< (count($difference)-1); $i++){
                 $WHERE .= $difference[$i][0].' <> :difference'.$i.' OR ';
                }
                $j=count($difference)-1;
             $WHERE.= $difference[$j][0].' <> :difference'.$j.')';
            }
         }
        }  else{
            if (strlen($WHERE)== 7){
             if (isset($difference) AND !empty($difference)){

             $WHERE.= $difference[count($difference)-1][0].' <> :difference ';
            }
         }  else {
              if (isset($difference) AND !empty($difference)){
             $WHERE.= ' AND '.$difference[count($difference)-1][0].' <> :difference ';

            }
        }
        }
        if(count($contraire)>1){
         if (strlen($WHERE)== 7){
             if (isset($contraire) AND !empty($contraire)){
             $WHERE.= '(';
             for($i=0; $i< (count($contraire)-1); $i++){

                 $WHERE .= $contraire[$i][0].' != :contraire'.$i.' OR ';
             }
             $j=count($contraire)-1;
             $WHERE.= $contraire[$j][0].' != :contraire'.$j.')';
            }
         }  else {
              if (isset($contraire) AND !empty($contraire)){
                 $WHERE.=' AND (';
                for($i=0; $i< (count($contraire)-1); $i++){
                 $WHERE .= $contraire[$i][0].' != :contraire'.$i.' OR ';
                }
                $j=count($contraire)-1;
             $WHERE.= $contraire[$j][0].' != :contraire'.$j.')';
            }
         }
        }  else {
            if (strlen($WHERE)== 7){
             if (isset($contraire) AND !empty($contraire)){

             $WHERE.= $contraire[count($contraire)-1][0].' != :contraire ';
            }
         }  else {
              if (isset($contraire) AND !empty($contraire)){
             $WHERE.= ' AND '.$contraire[count($contraire)-1][0].' != :contraire ';

            }
        }
        }
        
        if(count($inferieur)>1){
         if (strlen($WHERE)== 7){
             if (isset($inferieur) AND !empty($inferieur)){
             $WHERE.= '(';
             for($i=0; $i< (count($inferieur)-1); $i++){

                 $WHERE .= $inferieur[$i][0].' < :inferieur'.$i.' OR ';
             }
             $j=count($inferieur)-1;
             $WHERE.= $inferieur[$j][0].' < :inferieur'.$j.')';
            }
         }  else {
              if (isset($inferieur) AND !empty($inferieur)){
                 $WHERE.=' AND (';
                for($i=0; $i< (count($inferieur)-1); $i++){
                 $WHERE .= $inferieur[$i][0].' < :inferieur'.$i.' OR ';
                }
                $j=count($inferieur)-1;
             $WHERE.= $inferieur[$j][0].' < :inferieur'.$j.')';
            }
         }
        }  else {
            if (strlen($WHERE)== 7){
             if (isset($inferieur) AND !empty($inferieur)){

             $WHERE.= $inferieur[count($inferieur)-1][0].' < :inferieur ';
            }
         }  else {
              if (isset($inferieur) AND !empty($inferieur)){
             $WHERE.= ' AND '.$inferieur[count($inferieur)-1][0].' < :inferieur ';

            }
        }
        }
        
        if(count($superieur)>1){
         if (strlen($WHERE)== 7){
             if (isset($superieur) AND !empty($superieur)){
             $WHERE.= '(';
             for($i=0; $i< (count($superieur)-1); $i++){

                 $WHERE .= $superieur[$i][0].' > :superieur'.$i.' OR ';
             }
             $j=count($superieur)-1;
             $WHERE.= $superieur[$j][0].' > :superieur'.$j.')';
            }
         }  else {
              if (isset($superieur) AND !empty($superieur)){
                 $WHERE.=' AND (';
                for($i=0; $i< (count($superieur)-1); $i++){
                 $WHERE .= $superieur[$i][0].' > :superieur'.$i.' OR ';
                }
                $j=count($superieur)-1;
             $WHERE.= $superieur[$j][0].' > :superieur'.$j.')';
            }
         }
        }  else {
            if (strlen($WHERE)== 7){
             if (isset($superieur) AND !empty($superieur)){

             $WHERE.= $superieur[count($superieur)-1][0].' > :superieur ';
            }
         }  else {
              if (isset($superieur) AND !empty($superieur)){
             $WHERE.= ' AND '.$superieur[count($superieur)-1][0].' > :superieur ';

            }
        }
        }
        
        if(count($superieurEgale)>1){
         if (strlen($WHERE)== 7){
             if (isset($superieurEgale) AND !empty($superieurEgale)){
             $WHERE.= '(';
             for($i=0; $i< (count($superieurEgale)-1); $i++){

                 $WHERE .= $superieurEgale[$i][0].' > :superieurEgale'.$i.' OR ';
             }
             $j=count($superieurEgale)-1;
             $WHERE.= $superieurEgale[$j][0].' > :superieurEgale'.$j.')';
            }
         }  else {
              if (isset($superieurEgale) AND !empty($superieurEgale)){
                 $WHERE.=' AND (';
                for($i=0; $i< (count($superieurEgale)-1); $i++){
                 $WHERE .= $superieurEgale[$i][0].' > :superieurEgale'.$i.' OR ';
                }
                $j=count($superieurEgale)-1;
             $WHERE.= $superieurEgale[$j][0].' > :superieurEgale'.$j.')';
            }
         }
        }  else {
            if (strlen($WHERE)== 7){
             if (isset($superieurEgale) AND !empty($superieurEgale)){

             $WHERE.= $superieurEgale[count($superieurEgale)-1][0].' > :superieurEgale ';
            }
         }  else {
              if (isset($superieurEgale) AND !empty($superieurEgale)){
             $WHERE.= ' AND '.$superieurEgale[count($superieurEgale)-1][0].' > :superieurEgale ';

            }
        }
        }
        
        if(count($inferieurEgale)>1){
         if (strlen($WHERE)== 7){
             if (isset($inferieurEgale) AND !empty($inferieurEgale)){
             $WHERE.= '(';
             for($i=0; $i< (count($inferieurEgale)-1); $i++){

                 $WHERE .= $inferieurEgale[$i][0].' < :inferieurEgale'.$i.' OR ';
             }
             $j=count($inferieurEgale)-1;
             $WHERE.= $inferieurEgale[$j][0].' < :inferieurEgale'.$j.')';
            }
         }  else {
              if (isset($inferieurEgale) AND !empty($inferieurEgale)){
                 $WHERE.=' AND (';
                for($i=0; $i< (count($inferieurEgale)-1); $i++){
                 $WHERE .= $inferieurEgale[$i][0].' < :inferieurEgale'.$i.' OR ';
                }
                $j=count($inferieurEgale)-1;
             $WHERE.= $inferieurEgale[$j][0].' < :inferieurEgale'.$j.')';
            }
         }
        }  else {
            if (strlen($WHERE)== 7){
             if (isset($inferieurEgale) AND !empty($inferieurEgale)){

             $WHERE.= $inferieurEgale[count($inferieurEgale)-1][0].' < :inferieurEgale ';
            }
         }  else {
              if (isset($inferieurEgale) AND !empty($inferieurEgale)){
             $WHERE.= ' AND '.$inferieurEgale[count($inferieurEgale)-1][0].' < :inferieurEgale ';

            }
        }
        }
        


       //pas formaliser
        if (strlen($WHERE)== 7){
            if (isset($in) AND !empty($in)){
                $WHERE .= $in[0].' IN (';
             for($i=1; $i< count($in)-1; $i++){
                 $WHERE .= '\''.$in[$i].'\',';
             }
             $WHERE.= '\''.$in[count($in)-1].'\')';
          }
        } else {
           if (isset($in) AND !empty($in)){
                $WHERE .= ' AND '.$in[0].' IN (';
             for($i=1; $i< count($in)-1; $i++){
                 $WHERE .= '\''.$in[$i].'\',';
             }
             $WHERE.= '\''.$in[count($in)-1].'\')';
          } 
        }
        //end

        if (strlen($WHERE)== 7 ){
            if (isset($between) AND !empty($between)){
                $WHERE .= $between[0].' BETWEEN :between1 AND :between2 ';
            }
        }  else {
            if (isset($between) AND !empty($between)){
               $WHERE .= ' AND '.$between[0].' BETWEEN :between1 AND :between2 ';
          } 
        }

         if (strlen($WHERE)== 7){
            if (isset($notBetween) AND !empty($notBetween)){
             $WHERE .= $notBetween[0].' NOT BETWEEN :notbetween1 AND notbetween2 ';
          }
        }  else {
            if (isset($notBetween) AND !empty($notBetween)){
              $WHERE .= ' AND '.$notBetween[0].' NOT BETWEEN notbetween1 AND notbetween2 ';
          } 
        }

         if (strlen($WHERE)== 7){
            if (isset($like) AND !empty($like)){
                $j=0; 
             for($i=0; $i< count($like)-1; $i++){
                 $WHERE .= $like[$i][$j].' LIKE \''.$like[$i][$j+1].'\',';
             }
             $WHERE .= $like[count($like)-1][$j].' LIKE \''.$like[count($like)-1][$j+1].'\'';
          }
        }  else {
            if (isset($like) AND !empty($like)){
                $j=0;
             for($i=0; $i< count($like)-1; $i++){
                 $WHERE .= ' AND '.$like[$i][$j].' LIKE \''.$like[$i][$j+1].'\',';
             }
             $WHERE .= ' AND '.$like[count($like)-1][$j].' LIKE \''.$like[count($like)-1][$j+1].'\'';
          } 
        }

        if (strlen($WHERE)== 7){
            if (isset($isNull) AND !empty($isNull)){

                 $WHERE .= $isNull.' IS NULL ';
             }


        }  else {
            if (isset($isNull) AND !empty($isNull)){
                $WHERE .= ' AND '.$isNull.' IS NULL ';
             }

        }
         if (strlen($WHERE)== 7){
            if (isset($isNotNull) AND !empty($isNotNull)){

                 $WHERE .= $isNotNull.' IS NULL ';
             }


        }  else {
            if (isset($isNotNull) AND !empty($isNotNull)){
                $WHERE .= ' AND '.$isNotNull.' IS NOT NULL ';
             }

        }
        
        if (strlen($WHERE) != 7){
            $WHERE .= ' AND '.$id.'=:id';
            return $WHERE;
        } else{
            $WHERE .= ' '.$id.'=:id';
            return $WHERE;
        }
     }

     public function partieGroupBy($groupBy){
            $GROUPBY = '';
            if (isset($groupBy) AND !empty($groupBy)){

                 $GROUPBY = ' GROUP BY '.$groupBy[0];
            }

            return $GROUPBY;
        }

    public function partieOrderBy($orderBy){
            $ORDERBY ='';
         if(isset($orderBy) AND !empty($orderBy)){
                    $ORDERBY = ' ORDER BY '.$orderBy[0].' '. $orderBy[1];
                   } 
                return $ORDERBY;
        }
  
}
