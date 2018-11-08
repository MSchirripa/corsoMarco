<?php
/*
Questa pagina mostra il singolo articolo, l'id del post da aprire viene passata tramite
 * il parametro id= , quest'ultimo potrà essere recuperato tramite l'array $_GET
*/
require_once('functions.php');// la conoscete
?>
<?php
// stabilisco una connessione con il DB
$link = mysqli_connect($arrayConnect["server"],$arrayConnect["name"],$arrayConnect["pw"],$arrayConnect["database"]);
// gestisco gli errori
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

/* 
scrivo una query per recuperare il post con un particolare id
quello passato dal link more in blog.php
*/

$id=$_GET['postid'];/*$_GET è una array di tipo associativo che appartiene alle
varibili di tipo SUPERGLOBALS (varibili sempre disponibili nello *script corrente*, anche all'interno di 
funzioni e oggetti senza che vengano esplicitamente dichiarate tali)
http://php.net/manual/en/language.variables.superglobals.php

qui troverete la spiegazionie specifica della variabile $_GET (http://php.net/manual/en/reserved.variables.get.php)

Ogni volta che un parametro viene aggiunto ad un url ed inviato ad una pagina php
il server salva il suo nome ed il suo valore nell'array $_GET, il valore del parametro sarà sempre
disponibile (nello script corrente) e recuperabile tramite il nome.
*/

$query="SELECT id, postType, datecreation, title, content, image FROM posts
        WHERE id='$id'";

// eseguo la query e salvo il risultato in una variabile 

$result=mysqli_query($link,$query);
 
mysqli_close($link);

// a scopi didattici stampo l'array $_GET per vederne il contenuto

echo'<pre>';
print_r($_GET);
echo'</pre>';

?>


<html>
    <?php
    require_once './headFile.php';
    ?>
    
    <body>
        
        <?php
        if(isset($_COOKIE['LOGIN'])){
                    // stampo il bottone bottone di logout
                    echo"<p>Benvenuto ".$_COOKIE['LOGIN']."</p>";
                    echo'<a href="login.php?logout=yes">Logout</a>';
        }
        ?>
        
            <?php
            // il menu
            echo buildmenu('ilMiomenu',$array);
            ?>
        <div class="content">
            <?php
            
            echo'<article>';
               
            while($row = mysqli_fetch_assoc($result)){
                
//                echo '<h2>'.$row['title'].'</h2>';
//                echo '<div class="postContent">'.$row['content'].'</div>';
//                    
//            }
//            
//            echo'</article>';
            if (!empty($row['image'])){
                    
                    echo'<article><div style="float:left;"><img src=img/'.$row['image'].' class="avatarSingle"></div>';
                }
                else {
                    echo'<article><div style="float:left;"><img src="https://docs.appthemes.com/files/2011/08/gravatar-grey.jpg" class="avatarSingle"></div>';
                }

                echo '<div><h2>'.$row['id'].' '.$row['title'].'</h2>';
                /*['title'] corrisponde al valore della colonna title in questa riga della risorsa*/
                echo '<span class="postContent">'.($row['content']).'</span>';
                echo '</div>';
                //['id']corrisponde al valore della colonna id in questa riga della risorsa 
                /*
                mi serve per costruire un link alla pagina dettaglio, nell'url passeremo
                il parametro postid che verrà usato dalla pagina single.php
                il parametro verrà usato in una query per individuare un record preciso
                nella tabella posts
                */
               echo'</article>';     
            }
            
            ?>
        </div>
    
    </body>
    
</html>