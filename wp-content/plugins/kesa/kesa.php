<?php
/**
 * Plugin Name: Kesa
 * Description: Cet outil permet de définir la taille des pièces d'un kesa en fonction sa hauteur et longueur totale. *
 * Author: Tenryû
 * Version: 1.0
 * Author URI: unpointapreslautre.fr *
 * Text Domain: kesa
*/

/**
 * Include CSS file.
 */
function kesa_scripts() {
  wp_register_style( 'kesa-styles',  plugin_dir_url( __FILE__ ) . 'kesa.css' );
  wp_enqueue_style( 'kesa-styles' );
}
add_action( 'wp_enqueue_scripts', 'kesa_scripts' );

function kesa_js_scripts() {
  wp_register_script( 'kesa-js-script',  plugin_dir_url( __FILE__ ) . 'kesa.js',array('jquery') );
  wp_enqueue_script( 'kesa-js-script' );
}
add_action( 'wp_enqueue_scripts', 'kesa_js_scripts' );

/**
 * We really need that super cool custom round function...
 */
function kesa_round( $length ){
  $whole    = floor( $length );
  $fraction = $length - $whole;

  if( $fraction < .25 ){
    $new_fraction = 0;
  } else if ( $fraction >=  0.25  && $fraction <= 0.75 ){
    $new_fraction = 0.5;
  } else {
    $new_fraction = 1;
  }

  $new_length = $whole + $new_fraction;

  return $new_length;
}

/**
 * Creates the shortcode and everything that follows
 */
add_shortcode('kesa', 'kesa_link_shortcode');
function kesa_link_shortcode() {

  if(isset($_SERVER['REQUEST_METHOD']) &&  $_SERVER['REQUEST_METHOD' ]== 'POST' && isset($_POST['submit'])){


    /*************************************
    *
    * Traitement des données du formulaire
    *
    **************************************/

    /**
    * Récupération des données du formulaire
    **/
    $longueur = isset( $_POST['longueur'] ) ? $_POST['longueur'] : false;
    $hauteur = isset( $_POST['hauteur'] ) ? $_POST['hauteur'] : false;
    $ndb = isset( $_POST['ndb'] ) ? $_POST['ndb'] : false;
    $ourlet = isset( $_POST['ourlet']) ? $_POST['ourlet'] : false;

    $message = "Il y a une erreur dans les données. Veuillez remplir à nouveau le formulaire";

    if ($longueur == false || $hauteur == false || $ndb == false || $ourlet == false){
      echo $message;
    } else {
      $longueur_totale_cadre = $longueur + 4;
      $hauteur_totale_cadre = $hauteur + 4;
      $tableau_haut = "
        <tr>
          <th>Pièces</th>
          <th>Hauteur (cm)</th>
          <th>Largeur (cm)</th>
          <th>Total (avec ourlet)</th>
          <th>Quantité</th>
        </tr>";

      $tableau_bas = "
        <tr>
          <td>Cadres longueurs</td>
          <td>2 + $longueur + 2</td>
          <td>4</td>
          <td class='kesa-results'>$longueur_totale_cadre cm x 6 cm</td>
          <td>x2</td>
        </tr>
        <tr>
          <td>Cadres hauteurs</td>
          <td>2 + $hauteur + 2</td>
          <td>4</td>
          <td class='kesa-results'>$hauteur_totale_cadre cm x 6 cm</td>
          <td>x2</td>
        </tr>
        <tr>
          <td>Carrés</td>
          <td>4</td>
          <td>4</td>
          <td class='kesa-results'>6 cm x 6 cm</td>
          <td>x4</td>
        </tr>
        <tr>
          <td>Pieds</td>
          <td>8</td>
          <td>8</td>
          <td class='kesa-results'>10 cm x 10 cm</td>
          <td>x2</td>
        </tr>
        <tr>
          <td>Liens courts</td>
          <td>40</td>
          <td>2</td>
          <td class='kesa-results'>42 cm x 6 cm</td>
          <td>x2</td>
        </tr>
        <tr>
          <td>Lien long</td>
          <td>70</td>
          <td>2</td>
          <td class='kesa-results'>72 cm x 6 cm</td>
          <td>x1</td>
        </tr>
        <tr>
          <td>Pochette</td>
          <td>48</td>
          <td>48</td>
          <td class='kesa-results'>50 cm x 50 cm</td>
          <td>x1</td>
        </tr>
        ";

      switch($ndb){
        // calculer les valeurs
        case('5'):

          $longueur_base  = kesa_round(round(($longueur-32)/5, 1));
          $hauteur_a      = kesa_round(round(((($hauteur-14)/3)+2), 1));
          $hauteur_b      = kesa_round(round((((($hauteur-14)/3)*2)-2),1));

          // afficher le tableau
          ?>
          <h2>Tableau pour un kesa à 5 bandes</h2>
          <table id="kesa-table"  border="1" cellpadding="6" cellspacing ="3">
            <tbody>
              <?php echo $tableau_haut; ?>
              <tr>
                <td>A</td>
                <td><?php echo( "4+" . $hauteur_a ."+6" ); ?></td>
                <td><?php echo( "6+" . $longueur_base ."+6" ); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_a + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 12 + (2 * $ourlet ))) . " cm"; ?></td>
                <td>x3</td>
              </tr>
              <tr>
                <td>B</td>
                <td><?php echo( "4+" . $hauteur_b . "+6" ); ?></td>
                <td><?php echo( "6+" . $longueur_base ."+6" ); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_b + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 12 + (2 * $ourlet ))) . " cm";?></td>
                <td>x3</td>
              </tr>
              <tr>
                <td>D</td>
                <td><?php echo( "4+" . $hauteur_a . "+6" ); ?></td>
                <td><?php echo ("4+" . $longueur_base ."+6"); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_a + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 10 + (2 * $ourlet ))) . " cm"; ?></td>
                <td>x2</td>
              </tr>
              <tr>
                <td>C</td>
                <td><?php echo( "4+" . $hauteur_b . "+6" ); ?></td>
                <td><?php echo ("4+" . $longueur_base ."+6"); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_b + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 10 + (2 * $ourlet ))) . " cm";?></td>
                <td>x2</td>
              </tr>
              <?php echo $tableau_bas; ?>
            <tbody>
          </table>
          <br/>
          <button id="kesaprint">Print</button>
          <?php
          break;

        case('7'):
          // calculer les valeurs
          $longueur_base = kesa_round(($longueur-44)/7);
          $hauteur_a     = kesa_round(round(((($hauteur-20)/5)+2), 3));
          $hauteur_b     = kesa_round(round((((($hauteur-20)/5)*2)-1),3));
          $hauteur_c     = $hauteur_b;

          // afficher le tableau
          ?>
          <h2>Tableau pour un kesa à 7 bandes</h2>
          <table id="kesa-table"  border="1" cellpadding="6" cellspacing ="3">
            <tbody>
              <?php echo $tableau_haut; ?>
              <tr>
                <td>A</td>
                <td><?php echo( "4+" . $hauteur_a ."+6" ); ?></td>
                <td><?php echo( "6+" . $longueur_base ."+6" ); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_a + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 12 + (2 * $ourlet ))) . " cm"; ?></td>
                <td>x5</td>
              </tr>
              <tr>
                <td>B</td>
                <td><?php echo( "6+" . $hauteur_b ."+6" ); ?></td>
                <td><?php echo( "6+" . $longueur_base ."+6" ); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_b + 12 + (2 * $ourlet )) . " cm x " . ($longueur_base + 12 + (2 * $ourlet ))) . " cm"; ?></td>
                <td>x5</td>
              </tr>
              <tr>
                <td>C</td>
                <td><?php echo( "6+" . $hauteur_c ."+4" ); ?></td>
                <td><?php echo( "6+" . $longueur_base ."+6" ); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_c + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 12 + (2 * $ourlet ))) . " cm"; ?></td>
                <td>x5</td>
              </tr>
              <tr>
                <td>F</td>
                <td><?php echo( "4+" . $hauteur_b ."+6" ); ?></td>
                <td><?php echo( "4+" . $longueur_base ."+6" ); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_b + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 10 + (2 * $ourlet ))) . " cm"; ?></td>
                <td>x2</td>
              </tr>
              <tr>
                <td>E</td>
                <td><?php echo( "6+" . $hauteur_b ."+6" ); ?></td>
                <td><?php echo( "4+" . $longueur_base ."+6" ); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_b + 12 + (2 * $ourlet )) . " cm x " . ($longueur_base + 10 + (2 * $ourlet ))) . " cm"; ?></td>
                <td>x2</td>
              </tr>
              <tr>
                <td>D</td>
                <td><?php echo( "6+" . $hauteur_a ."+4" ); ?></td>
                <td><?php echo( "4+" . $longueur_base ."+6" ); ?></td>
                <td class="kesa-results"><?php echo( ($hauteur_a + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 10 + (2 * $ourlet ))) . " cm"; ?></td>
                <td>x2</td>
              </tr>
              <?php echo $tableau_bas; ?>
            <tbody>
          </table>
          <br/>
          <button id="kesaprint">Print</button>
          <?php
          break;

        case('9'):
          $longueur_base = kesa_round(round(($longueur - 56)/9, 1));
          $hauteur_a     = kesa_round(round(((($hauteur - 20)/5)+2), 1));
          $hauteur_b     = kesa_round(round((((($hauteur - 20)/5)*2)-1),1));
          $hauteur_c     = $hauteur_b;

        ?>
        <h2>Tableau pour un kesa à 9 bandes</h2>
        <table id="kesa-table" border="1" cellpadding="6" cellspacing ="3">
          <tbody>
          <?php echo $tableau_haut; ?>
          <tr>
            <td>A</td>
            <td><?php echo( "4+" . $hauteur_a ."+6" ); ?></td>
            <td><?php echo( "6+" . $longueur_base ."+6" ); ?></td>
            <td class="kesa-results"><?php echo( ($hauteur_a + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 12 + (2 * $ourlet ))) . " cm"; ?></td>
            <td>x7</td>
          </tr>
          <tr>
            <td>B</td>
            <td><?php echo( "6+" . $hauteur_b ."+6" ); ?></td>
            <td><?php echo( "6+" . $longueur_base ."+6" ); ?></td>
            <td class="kesa-results"><?php echo( ($hauteur_b + 12 + (2 * $ourlet )) . " cm x " . ($longueur_base + 12 + (2 * $ourlet ))) . " cm"; ?></td>
            <td>x7</td>
          </tr>
          <tr>
            <td>C</td>
            <td><?php echo( "6+" . $hauteur_c ."+4" ); ?></td>
            <td><?php echo( "6+" . $longueur_base ."+6" ); ?></td>
            <td class="kesa-results"><?php echo( ($hauteur_c + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 12 + (2 * $ourlet ))) . " cm"; ?></td>
            <td>x7</td>
          </tr>
          <tr>
            <td>F</td>
            <td><?php echo( "4+" . $hauteur_b ."+6" ); ?></td>
            <td><?php echo( "4+" . $longueur_base ."+6" ); ?></td>
            <td class="kesa-results"><?php echo( ($hauteur_b + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 10 + (2 * $ourlet ))) . " cm"; ?></td>
            <td>x2</td>
          </tr>
          <tr>
            <td>E</td>
            <td><?php echo( "6+" . $hauteur_b ."+6" ); ?></td>
            <td><?php echo( "4+" . $longueur_base ."+6" ); ?></td>
            <td class="kesa-results"><?php echo( ($hauteur_b + 12 + (2 * $ourlet )) . " cm x " . ($longueur_base + 10 + (2 * $ourlet ))) . " cm"; ?></td>
            <td>x2</td>

          </tr>
          <tr>
            <td>D</td>
            <td><?php echo( "6+" . $hauteur_a ."+4" ); ?></td>
            <td><?php echo( "4+" . $longueur_base ."+6" ); ?></td>
            <td class="kesa-results"><?php echo( ($hauteur_a + 10 + (2 * $ourlet )) . " cm x " . ($longueur_base + 10 + (2 * $ourlet ))) . " cm"; ?></td>
            <td>x2</td>
          </tr>
          <?php echo $tableau_bas; ?>
          <tbody>
        </table>
        <br/>
        <button id="kesaprint">Print</button>        
        <?php
          break;

        default:
          echo $message;
      }

    }

  } else {

    /**
    * Affichage du formulaire
    */
    ?>
    <form method="POST" id="kesa-form" class="kesa-form">
      <fieldset style="border:1px solid brown;padding:0 0 16px 16px;">
        <legend style="padding: 0 6px;">Nombre de bandes du kesa</legend>
          <input type="radio" name="ndb" value="5"> 5 bandes</br>
          <input type="radio" name="ndb" value="7" checked> 7 bandes</br>
          <input type="radio" name="ndb" value="9"> 9 bandes</br>
      </fieldset>
    </br>
      <fieldset style="border:1px solid brown;padding:0 0 16px 16px;" >
        <legend style="padding: 0 6px;">Taille de l'ourlet en cm</legend>
        <input type="radio" name="ourlet"  value="1"> 1cm</br>
        <input type="radio" name="ourlet"  value="1.5" checked> 1.5cm</br>
      </fieldset>
    </br>
      <fieldset style="border:1px solid brown;padding:0 0 16px 16px;">
        <legend style="padding: 0 6px;">Mesures du kesa en cm</legend>
          <label for="kesaLength">
            <input id="kesaLength" name="longueur" type="number" placeholder="Longueur" min="0" required>
          </label>
          </br>
          </br>
          <label for="kesaHeight">
            <input id="kesaHeight" name="hauteur" type="number" placeholder="Hauteur" min="0" required>
          </label>
          </br>
      </fieldset>
    </br>
    <input type="submit" name="submit">
    </form>
    <?php
  }
}
