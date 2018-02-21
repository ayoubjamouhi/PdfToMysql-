<?php 

namespace App\Controllers;

use App\Core\App;
use App\Core\Db\Connection;

class TicketsController

{
    public $donnees;
    /**
     * Undocumented function
     *
     * @return int
     * 
     */

    /** Start GET */
    public function pointeurbsp()
    {
        $tickets = App::get('Ticket')->selectAll('LIMIT 45');
        return view("pointeurbsp",compact('tickets'));

    }
    public function pointeurvente()
    {
        $tickets = App::get('Ticket')->selectAll('LIMIT 5');
        return view("pointeurvente",compact('tickets'));        
    }
    public function test()
    {
        return $this->FromPdfToMysql('bsp');
    }
    /** End GET */

    /** Start POST */
    public function checkpointeurbsp()
    {

        if(empty($_POST['dateinit']) && empty($_POST['datefinal']))
            echo "<div class='alert alert-danger' role='alert'>Entrer la date initial et la date final</div>"."<br>";

        if($_POST['dateinit'] > $_POST['datefinal'])
            {echo "<div class='alert alert-danger' role='alert'>Entrer une date valid</div>"."<br>";
            //return $this->pointeurbsp();                
            }

        // $ticketsFromDeuxiemeDb = App::get('Ticket')->selectFromDeuxiemeDbByDateInitAndFinal($_POST['dateinit'],$_POST['datefinal']);
        $ticketsFromDeuxiemeDb = App::get('Ticket')->selectAll('LIMIT 10');
        if($ticketsFromDeuxiemeDb == null)
            echo "<div class='alert alert-danger' role='alert'>Pas de données dans la table vente</div>"."<br>";


        if($_FILES['filepdf']['tmp_name'] == null || $_FILES['filepdf']['type'] != 'application/pdf')
                echo "<div class='alert alert-danger' role='alert'>Entrer un fichier pdf</div>"."<br>";

        $tickets = App::get('Ticket')->selectAll('LIMIT 40');
        //var_dump($this->FromPdfToMysql($this->uploadPdf($_FILES['filepdf'])));

        $filepath = $this->uploadPdf($_FILES['filepdf']);
        
        if( $filepath != '' && $_FILES['filepdf']['type'] == 'application/pdf' && $_POST['dateinit'] < $_POST['datefinal'])
        {
            if($this->FromPdfToMysql($filepath))
            {
                return $this->pointeurbsp();
            }
            else
                echo "Vous n'avez pas insérer les donneés";
        }


        // var_dump($_FILES['filepdf']);
        $tickets = App::get('Ticket')->selectAll('LIMIT 45');
        // return view("pointeurvente",compact('tickets','date_correct','ya_de_donnees','filepdf','addpdftodb'));
    }


    public function checkpointeurvente()
    {
        if(empty($_POST['dateinit']) && empty($_POST['datefinal']))
            echo "<div class='alert alert-danger' role='alert'>Entrer la date initial et la date final</div>"."<br>";

        if($_POST['dateinit'] > $_POST['datefinal'])
            {echo "<div class='alert alert-danger' role='alert'>Entrer date valid</div>"."<br>";                
                return $this->pointeurbsp();}

        $ticketsFromDeuxiemeDb = App::get('Ticket')->selectAll('LIMIT 5');
        
        if($ticketsFromDeuxiemeDb == null)
            echo "<div class='alert alert-danger' role='alert'>Pas de données dans la table vente</div>"."<br>"; 

        if($_FILES['filepdf']['tmp_name'] == null || $_FILES['filepdf']['type'] != 'application/pdf')
            echo "<div class='alert alert-danger' role='alert'>Entrer un fichier pdf</div>"."<br>"; 

        $tickets = App::get('Ticket')->selectAll('LIMIT 10');
        //var_dump($this->FromPdfToMysql($this->uploadPdf($_FILES['filepdf'])));

        $filepath = $this->uploadPdf($_FILES['filepdf']);
        
        if( $filepath != '' && $_FILES['filepdf']['type'] == 'application/pdf' && $_POST['dateinit'] < $_POST['datefinal'])
        {
            if($this->FromPdfToMysql($filepath))
            {
                echo "Vous avez insérer les donneés avec succées";
                return $this->pointeurvente();
            }
            else
                echo "<div class='alert alert-danger' role='alert'>Entrer un fichier pdf</div>"."<br>"; 
        }


        // var_dump($_FILES['filepdf']);
        $tickets = App::get('Ticket')->selectAll('LIMIT 5');        
    }    
    public function regenerervente()
    {
        
        //var_dump($_POST);
        /// select from table2 where date appartient à date init et date final
        $date_correct = true;
        $ya_de_donnees = true;

        if(empty($_POST['dateinit']) && empty($_POST['datefinal']))
            $date_correct = false;

        if($_POST['dateinit'] > $_POST['datefinal'])
            $date_correct = false;

        $tickets = App::get('Ticket')->selectAll('LIMIT 5');

        if($tickets == null)
            $ya_de_donnees = false;

        return view("generervente",compact('tickets','date_correct','ya_de_donnees'));        
    }
    /** End POST */


    /** Start Functions For PDF To Db */
    private function FromPdfToMysql($filepdf)
    {

        $pdf = App::get('Parser')->parseFile($filepdf);
 
        // Retrieve all pages from the pdf file.
        $pages  = $pdf->getPages();

        // Loop over each page to extract text.
        $t=0;
        $donnees2 = [];
        $v =0;
        foreach ($pages as $page) 

        {
        
            if(strpos($page->getText(),"ELETRONIC TICKET"))
            {
        
                $text = trim($page->getText());
        
        
                $parsed = substr($text, strpos($text,'ELETRONIC TICKET') + 16,strlen($text));
        
                // echo (trim($parsed) . "<br>");
        
                $donnees = [];
        
                $i=0;
                $j=0;
        
                $parsed3 = explode('MAD',trim($parsed));
        
                foreach($parsed3 as $par)
                {
                    $parsed4 = explode(' ',$par);
                    foreach($parsed4 as $par1)
                    {
                        if($par1 != ''  && $par1 != '|')
                            $donnees[$j][$i++] = $par1;
        
                    }
                    $i=0;
                    $j++;
                }
        
                $k = 0;
                $donnees1 = [];
                $f=0;
                $j=0;
                $i=0;
                foreach($donnees as $d)
                {
                    // var_dump($d);
                    $y = 0;
                    if($k == 0)
                    {
                        // premier if
                        if(!isset($d[1]))
                        {
                            
                            $donnees1[$j][$i++] = $d[$f];
                           
                        }
                        else
                        {
                            
                            $b = false;
                            foreach($d as $dd)
                            {
                                if(strpos($dd,'CNJ') !== FALSE)
                                {
                                    $b = true;
                                    break;
                                }
                            }
                            if(!$b)
                            {
                                // ajouter ce donnees au page précedente
                                $tax_cash = 0;
                                end($d);
                                for($i=0;$i<key($d);$i++)
                                {
                                    if(is_int((int)$d[$i]))
                                    {
                                        /**
                                         * les tax cash qui reste dans le nouveau page
                                         */
                                        $tax_cash = (double)$d[$i] + $tax_cash;
                                        
                                    }
                                    // modifier tax cash précedent dans la database on ajoute ce $tax_cash  
                                } 
                                $i=0;
                                $donnees1[$j][$i++] = $d[key($d)];
        
                                $deuxarg = count($donnees2[($v-1)])-1;
                                $troisiemearg  = count($donnees2[($v-1)][$deuxarg]) -1;
                                
                                $donnees2[($v-1)][$deuxarg][7] +=  (double)$tax_cash;
                            }
                            else
                            {
                                // ajouter ce donnees au page précedente
                                $tax_cash = 0;
                                end($d);
                                for($i=0;$i<key($d)-4;$i++)
                                {
                                    if(is_int((int)$d[$i]))
                                    {
                                        /**
                                         * les tax cash qui reste dans le nouveau page
                                         */
                                        $tax_cash = (double)$d[$i] + $tax_cash;
                                        
                                    }
                                    // modifier tax cash précedent dans la database on ajoute ce $tax_cash  
                                }
                                echo $tax_cash; 
                                $i=0;
                                $donnees1[$j][$i++] = $d[key($d)];
        
                                $deuxarg = count($donnees2[($v-1)])-1;
                                $troisiemearg  = count($donnees2[($v-1)][$deuxarg]) -1;
                                
                                @$donnees2[($v-1)][$deuxarg][7] +=  (double)$tax_cash;
                                @$donnees2[($v-1)][$deuxarg][17]  = TRUE;
                                @$donnees2[($v-1)][$deuxarg][18]  = $d[key($d)-4];
                                @$donnees2[($v-1)][$deuxarg][19]  = $d[key($d)-3];
                                @$donnees2[($v-1)][$deuxarg][20]  = $d[key($d)-2];
                            }
                        }
                        $k=1;
                    }
                    
                    else
                    {
        
                        foreach($d as $dd)
                        {
        
                            if(strpos($dd,'EX') !== false && $this->checkIfStringContainsNumber($dd))
                            {
                                $y = 1;
                                break;
                            }
                            if(strpos($dd,'CANX') !== false)
                            {
                                $y = 2;
                                break;
                            }                   
                            if(strpos($dd,'CANN') !== false)
                            {
                                $y = 3;
                                break;
                            }  
                            if(strpos($dd,'TICKET') !== false)
                            {
                                $y = 4;
                                break;
                            }   
                         
                        }
                        // le billet ne contient pas "EX" (billets normales)
                        if($y == 0)
                        {
                            
                            end($d);
                            $tax_cash = (double)$d[5];
                            for($m=10;$m<key($d);$m++)
                            {
                                    
                                if(strlen($d[$m]) > 8)
                                    break;
                                if(is_double((double)$d[$m]))
                                $tax_cash = $tax_cash + (double)$d[$m];                          
                            }
        
                            $st_comm_amount = (float)str_replace('-',' ',$d[8]) * (-1);
        
                            $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],$d[4],$tax_cash,$d[7],$st_comm_amount,$d[9],false,null,null,null,null,false,false,null,null,null,false,null,null,false,false,false);
                            $j++;
                                    
                            $i=1;
                            $f=0;
                            if(is_numeric($d[key($d)]))
                                $donnees1[$j][0] = $d[key($d)];
        
        
                            // echo "normale";    
                        }                
                        // le billet est contient "EX"
                        if($y == 1)
                        {
                            // 4 cas pour billets echange 
        
                            $u=false;
                            foreach($d as $ddd)
                            {
                                if(strpos($ddd,'-') !== false)
                                {
                                    
                                    $u = true;
                                    break;
                                }
                            }
        
                            // Si les billets contient  ( - )
                            if($u)
                            {
                                $o=false;
                                foreach($d as $error)
                                {
                                    if(strpos($error,'ERROR') !== false)
                                    {
                                        
                                        $o = true;
                                        break;
                                    }
                                }
                                // Si les billets ne contient pas NR ERROR et contient(-)
                                if(!$o)
        
                                {
        
                                    end($d);                            
                                    // $donnees1[$j][$i++] = $d[$f++];
                    
                                    // for($m=1;$m<=4;$m++)
                                    //     $donnees1[$j][$i++] = $d[$f++];
                                    
                                    // if(count($d) > 6)
                                    // {
                    
                                    //     $f=7;
                                    //     for($m=1;$m<=5;$m++)
                                    //         $donnees1[$j][$i++] = $d[$f++];
                                        
                                    //     $donnees1[$j][$i] = (float)$d[5];
        
                                    //     for($m=$f;$m<key($d);$m++)
                                    //     {
                                            
                                    //         if(strlen($d[$m]) > 8)
                                    //             break;
        
                                    //         if(is_float((float)$d[$m]))
                                    //             $donnees1[$j][$i] = $donnees1[$j][$i] + (int)$d[$m];                       
                                    //     }
                    
                                    // }
        
                                    $tax_cash = (double)$d[5];    
                                    for($m=11;$m<key($d);$m++)
                                    {
                                        
                                        if(strlen($d[$m]) > 8)
                                            break;
        
                                        if(is_float((double)$d[$m]))
                                            $tax_cash = $tax_cash + (double)$d[$m];                       
                                    }
        
                                    $st_comm_amount = (double)str_replace('-',' ',$d[8]) * (-1);
                                    $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],$d[4],$tax_cash,$d[7],$st_comm_amount,$d[9],true,$d[10],$d[11],null,null,false,false,null,null,null,false,null,null,false,false,false);
                                    $j++;
                                    
                                    $i=1;
                                    $f=0;
                                    
                                    if(is_numeric($d[key($d)]))
                                        $donnees1[$j][0] = $d[key($d)];
                                    
                                       

                                    // echo "les billets ne contient pas NR ERROR et contient (-)";
                                }
                                // Si les billets contient NR ERROR et (-)
                                else
                                {
                                    // continue ici NR ERROR n'affiche jamais dans index10 
                                    // il ya de redondonces cad les traitements se fait dans deux boucle
        
                                    end($d);
                                                
                                    for($m=1;$m<=5;$m++)
                                        $donnees1[$j][$i++] = $d[$f++];
                                    
                                    if(count($d) == 17)
                                    {
                    
                                        // $f=7;
        
                                        // for($m=0;$m<3;$m++)
                                        //   $donnees1[$j][$i++] = $d[$f++];
        
                                        // for($m=0;$m<2;$m++)
                                        //    @$donnees1[$j][$i] .= $d[$f++] ." ";
                                        
                                        // $donnees1[$j][$i] = trim($donnees1[$j][$i]);
                                        // $i++;
                                        // $donnees1[$j][$i++] = $d[14];
                                        // $donnees1[$j][$i++] = $d[15];
        
                                        // $donnees1[$j][$i] = (float)$d[5]+(float)$d[12];
        
                                        $st_comm_amount = (double)str_replace('-',' ',$d[8]) * (-1);
                                        $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],$d[4],$d[5]+$d[12],$d[7],$st_comm_amount,$d[9],true,$d[14],$d[15],null,null,false,false,null,null,null,true,null,null,false,false,false);
        
                                        // echo "les billets contient NR ERROR et (-) avec taille 17";  
                                    }
                                    if(count($d) == 15)
                                    {
                    
                                        // $f=7;
        
                                        // for($m=1;$m<=3;$m++)
                                        //   $donnees1[$j][$i++] = $d[$f++];
        
                                        // for($m=1;$m<=2;$m++)
                                        //   @$donnees1[$j][$i] .= $d[$f++]." ";
                                        
                                        //   $donnees1[$j][$i] = trim($donnees1[$j][$i]);
                                        // $i++;
                                        // $donnees1[$j][$i++] = $d[12];
                                        // $donnees1[$j][$i++] = $d[13];
        
                                        // $donnees1[$j][$i] = (float)$d[5];
        
                                        $st_comm_amount = (double)str_replace('-',' ',$d[8]) * (-1);
                                        $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],$d[4],$d[5],$d[7],$st_comm_amount,$d[9],true,$d[12],$d[13],null,null,false,false,null,null,null,true,null,null,false,false,false);
        
                                        // echo "les billets contient NR ERROR et (-) avec taille 15";  
                                    }                            
                                    $j++;
                                    
                                    $i=1;
                                    $f=0;
                                    
                                    $donnees1[$j][0] = $d[key($d)];
                                                            
                                }
                            }
                            // Si les billets ne contient pas  ( - ) 
                            else
                            {
        
                                /**
                                 * les billets Sans trois éléments
                                 */
                                if(!is_numeric($d[5]))
                                {
                                    /**
                                     * $o = false : pas de NR ERROR
                                     */
                                    $o=false;
                                    foreach($d as $error)
                                    {
                                        if(strpos($error,'ERROR') !== false)
                                        {
                                            
                                            $o = true;
                                            break;
                                        }
                                    }
                                    // pas de NR ERROR et Sans trois éléments
                                    if(!$o)
        
                                    {
        
                                        end($d);
                                        // $donnees1[$j][1]
                                        
                                        // for($m=0;$m<4;$m++)
                                        //     $donnees1[$j][$i++] = $d[$f++];
                                        
                                        if(count($d) > 6)
                                        {
                        
        
                                            $p=0;
                                            $pos = 0;
                                            $ch = false;
                                            
                                            foreach($d as  $key=>$value)
                                            {
                                                if(strpos($value,'EX') !== false && $this->checkIfStringContainsNumber($value))
                                                {
                                                    if(!$ch)
                                                    {
                                                        $pos = $key;
                                                        $ch = true;
                                                    }
        
                                                    $p++;
                                                    
                                                }                                    
                                            }
                                            
                                            if($p == 1)
                                            {
                                                if(!isset($d[$pos + 3]))
                                                {
                                                    if(isset($d[$pos+2]))
                                                    {
                                                        // $f=6;
        
                                                        // for($m=1;$m<=3;$m++)
                                                        //     $donnees1[$j][$i++] = $d[$f++];
        
                                                        // $donnees1[$j][$i++] = (float)$d[4];
                                                        $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],null,$d[4],null,null,$d[6],true,$d[7],$d[8],null,null,false,false,null,null,null,false,null,null,false,false,false);
                                                        $j++;
                                                        $i=1;
                                                        $f=0;
                                                        end($d);
                                                        $donnees1[$j][0] = $d[key($d)];
                                                        // echo "2 valeur apres EX";
                                                    }
                                                    else
                                                    {
        
                                                        // $f=6;
                                                        // for($m=1;$m<=3;$m++)
                                                        //     $donnees1[$j][$i++] = $d[$f++];
        
                                                        $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],null,$d[4],null,null,$d[6],true,$d[7],$d[8],null,null,false,false,null,null,null,false,null,null,false,false,false);
        
                                                        
                                                        $j++;
                                                        $i=1;
                                                        $f=0;
        
                                                        // echo "1 valeur apres EX";
                                                    }
                                                }
                                            }
                                            else if ($p == 2)
                                            {
        
                                                $cnj = false;
                                                foreach($d as $value1)
                                                {
                                                    if(strpos($value1,'CNJ') !== false)
                                                    {
                                                        
                                                        $cnj = true;
                                                        break;
                                                    }
                                                }
                                                if($cnj)
                                                {
        
                                                    // $f=6;
        
                                                    // for($m=0;$m<3;$m++)
                                                    //     $donnees1[$j][$i++] = $d[$f++];
        
                                                    
                                                    // $f = 11;
                                                    // for($m=0;$m<6;$m++)
                                                    // {
                                                    //     $donnees1[$j][$i++] = $d[$f++];
                                                    // }
                                                    // $donnees1[$j][$i++] = (float)$d[4]+(float)$d[9];
                                                    $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],null,$d[4]+$d[9],null,null,$d[6],true,$d[7],$d[8],$d[11],$d[12],true,false,$d[13],$d[14],$d[15],false,null,null,false,false,false);
                                                    $j++;
                                                    $i=1;
                                                    $f=0;
        
                                                    end($d);
                                                    $donnees1[$j][0] = $d[key($d)];
        
                                                    // echo "avec CNJ : is_ex_with_ex_with_cnj";
                                                }
                                                else
                                                {
                                                    // $f=6;
        
                                                    // for($m=0;$m<3;$m++)
                                                    //     $donnees1[$j][$i++] = $d[$f++];
        
                                                    
                                                    // $f = 11;
                                                    // for($m=0;$m<2;$m++)
                                                    // {
                                                    //     $donnees1[$j][$i++] = $d[$f++];
                                                    // }
                                                    // $donnees1[$j][$i++] = (float)$d[4]+(float)$d[9];
                                                    $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],null,$d[4]+$d[9],null,null,$d[6],true,$d[7],$d[8],$d[11],$d[12],false,false,null,null,null,false,null,null,false,false,false);
                                                    $j++;
                                                    $i=1;
                                                    $f=0;
                                                    
                                                    end($d);
                                                    $donnees1[$j][0] = $d[key($d)];
                                                    // echo "sans CNJ";
                                                }
                                            }
                                            
                                         
                                        }
                                        // echo "pas de NR ERROR et Sans trois elements";
                                    }
                                    // traitemnt de deux cas de billets NR ERROR qui sont pas GROSS FARE CASH
                                    else
                                    {
                                        
                                        end($d);
                        
                                        // for($m=1;$m<=4;$m++)
                                        //     $donnees1[$j][$i++] = $d[$f++];
                                      
                                        // if(count($d) > 6)
                                        // {
                      
                                        //     $f=6;
                                        //     for($m=1;$m<=2;$m++)
                                        //       $donnees1[$j][$i++] = $d[$f++];
        
                                        //     for($m=1;$m<=2;$m++)
                                        //       @$donnees1[$j][$i] .= $d[$f++]." ";
                                            
                                        //       $donnees1[$j][$i] = trim($donnees1[$j][$i]);
                                        //     $i++;
                                        //     $donnees1[$j][$i++] = $d[12];
                                        //     $donnees1[$j][$i++] = $d[13];
        
                                        //     $donnees1[$j][$i] = (float)$d[4]+(float)$d[10];
                      
                                            
                                        // }
        
                                        $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],null,$d[4]+$d[10],$d[6],null,$d[7],true,$d[12],$d[13],null,null,false,false,null,null,null,true,null,null,false,false,false);
        
                                        $j++;
                                        $i=1;
                                        $f=0;                                
                                        $donnees1[$j][0] = $d[key($d)]; 
        
                                        // echo "traitemnt de deux cas de billets NR ERROR qui sont pas GROSS FARE CASH";                     
                                    }
                                }
                            }
        
                        }
                        // le billet contient CANX
                        if($y == 2)
                        {
                            
                            end($d);
                            // $f=0;    
                            // for($m=0;$m<5;$m++)
                            //     $donnees1[$j][$i++] = $d[$f++];
        
                            $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],$d[2],$d[3],null,null,null,null,null,true,null,null,null,null,false,false,null,null,null,true,null,null,true,false,false);
        
                            $j++;
                            $i=1;
                            $f=0;
                            if(is_numeric($d[key($d)]))
                                $donnees1[$j][0] = $d[key($d)];
        
                            // echo "le billet contient CANX";    
                        }
                        // le billet contient CANN
                        if($y == 3)
                        {
                            
                            end($d);
                            // $f=0;    
                            // for($m=0;$m<4;$m++)
                            //     $donnees1[$j][$i++] = $d[$f++]; 
                            $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,$d[0],$d[1],null,$d[3],null,null,null,null,null,true,null,null,null,null,false,false,null,null,null,true,null,null,false,true,false);                  
                            $j++;                    
                            $i=1;
                            $f=0;
        
                            if(is_numeric($d[key($d)]))
                                $donnees1[$j][0] = $d[key($d)];
                            // echo "le billet contient CANN";    
                        }
                        if($y == 4)
                        {
                            
                            // $f=2;    
                            // for($m=0;$m<4;$m++)
                            //     $donnees1[$j][$i++] = $d[$f++]; 
                            $donnees1[$j][0] = null;
                            $st_comm_amount = (double)str_replace('-',' ',$d[4]) * (-1);
                            $payable_balance = (double)str_replace('|',' ',$d[5]);
                            $donnees1[$j] = $this->remplirDonnees1($donnees1[$j],NULL,NULL,NULL,NULL,NULL,$d[2],$d[3],null,$st_comm_amount,$payable_balance,false,null,null,null,null,false,false,null,null,null,false,null,null,false,false,true);    
                            
                            // echo "le billet total";    
                            break;
                        }
                        
                    }
                }
        
                // var_dump($donnees1);
                // ECHO "--";
                $donnees2[$v++] = $donnees1;
        
                $i=0;
                $k=0;
                $j=0;
                $text1 = '';
                $t++;
                // if($t==4)
                //     break;
            }
            
           
        }                                               
        if(App::get('Ticket')->insertDonneesPdfToDb($donnees2) == $this->numberOfDonnees($donnees2))
            return true;
        else
            return false;
        
    }
    private function remplirDonnees1($donnees,$curr,$document_number,$d_i,$cpns,$issue_date,$gross_fare_cash,$tax_cash,$st_comm_rate,$st_comm_amount,$payable_balance,$is_ex,$ex_nom,$ex_numero,$deuxieme_ex_nom,$deuxieme_ex_numero,$is_ex_and_ex_and_cnj,$is_normale_with_cnj,$cnj_doc_id,$cnj_c_i,$cnj_cpns,$is_hrerror,$deuxieme_nrerror_er_nom,$deuxieme_nrerror_er_numero,$is_canx,$is_cann,$is_tot)
    {

        $i=1;
        $donnees[$i++] = $curr; // $i = 1
        $donnees[$i++] = $document_number;// $i = 2
        $donnees[$i++] = $d_i;// $i = 3
        $donnees[$i++] = $cpns;// $i = 4
        $donnees[$i++] = $issue_date;// $i = 5
        $donnees[$i++] = (double)$gross_fare_cash;// $i = 6
        $donnees[$i++] = (double)$tax_cash;// $i = 7
        $donnees[$i++] = (double)$st_comm_rate;// $i = 8
        $donnees[$i++] = (double)$st_comm_amount;// $i = 9
        $donnees[$i++] = (double)$payable_balance;// $i = 10
        $donnees[$i++] = (boolean)$is_ex;// $i = 11
        $donnees[$i++] = $ex_nom;// $i = 12
        $donnees[$i++] = (double)$ex_numero;// $i = 13
        $donnees[$i++] = $deuxieme_ex_nom;// $i = 14
        $donnees[$i++] = (double)$deuxieme_ex_numero;// $i = 15
        $donnees[$i++] = (boolean)$is_ex_and_ex_and_cnj;// $i = 16
        $donnees[$i++] = (boolean)$is_normale_with_cnj;// $i = 17
        $donnees[$i++] = $cnj_doc_id;// $i = 18
        $donnees[$i++] = $cnj_c_i;// $i = 19
        $donnees[$i++] = $cnj_cpns;// $i = 20
        $donnees[$i++] = (boolean)$is_hrerror;// $i = 21
        $donnees[$i++] = $deuxieme_nrerror_er_nom;// $i = 22
        $donnees[$i++] = (double)$deuxieme_nrerror_er_numero;// $i = 23
        $donnees[$i++] = (boolean)$is_canx;// $i = 24
        $donnees[$i++] = (boolean)$is_cann;// $i = 25
        $donnees[$i++] = (boolean)$is_tot;// $i = 26

        return $donnees;
    }
    private function checkIfStringContainsNumber($text)
    {
        $i=0;
        $j=0;
        while(isset($text[$i]))
        {
        
            if((int)$text[$i] != 0)
                $j++;
            $i++;
        }
        if($j != 0)
            return true;
        else
            return false;   
    }

    public function numberOfDonnees($donnees2)
    {
        $i=0;
        foreach($donnees2 as $donnees1)
        {
            foreach($donnees1 as $donnees)
                  $i++;
        }
        return $i;
    }
    public function uploadPdf($name)
	{
		
		$ret        = false;
        $img_blob   = '';
        $img_taille = 0;
        $img_type   = '';
        $img_nom    = '';
        $taille_max = 250000;
        $ret        = is_uploaded_file($name['tmp_name']);
        
        if (!$ret) 
            return false;
            
        else 
        
        {

            // Le fichier a bien été reçu
            $img_taille = $name['size'];
            $img_type   = $name['type'];
            $img_nom    = $name['name']; 

            if ($img_taille > $taille_max) 
                return false;

            if($img_type != 'application/pdf')  
                return false;

            $img_type = $name['type'];
            $img_nom  = $name['name'];


            $oldpath = $name['tmp_name'];
            $newpath ="public/pdf/".$name['name'];
            move_uploaded_file($oldpath, $newpath);
            
            return $newpath;
        }	
    }
    /** End Functions For PDF To Db */
}