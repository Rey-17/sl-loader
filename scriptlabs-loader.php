<?php
/*
  Plugin Name: Loader image
  Plugin URI: none
  Description: Este plugin muestra un loader al cargar las páginas seleccionadas
  Version: 1
  Author: Reynaldo Villarreal
  Author URI: none
  License: GPLv2 or any later version
  Text Domain: script-labs-loader
*/
/*  Copyright 2015.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2 or later, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software.
*/
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
define( 'SL_LOADER_PATH', plugin_dir_path( __FILE__ ) );
define( 'SL_LOADER_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );

//$curLang = substr(get_bloginfo( 'language' ), 0, 2);

/**
 * Función que agrega al menú del adminditrador, nuestro acceso al plugin
 */
function slloader_admin(){
  add_options_page( "Loader SL", "Loader SL", "manage_options", "sl-loader-options", "slloader_show_admin" );
}

add_action( 'admin_menu', 'slloader_admin' );

/**
 * Función que muestra el contenido HTML de la sección del admin.
 */
function slloader_show_admin(){
  $id_image =  get_option( 'media_selector_attachment_id', 0 );
  $url = '';

  if($id_image != 0)
  {
    $url =   wp_get_attachment_url($id_image);
  }
  //$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

  if (  isset( $_POST['image_attachment_id'] )  &&  absint( $_POST['image_attachment_id'] ) != $id_image ) :
    update_option( 'media_selector_attachment_id', absint( $_POST['image_attachment_id'] ) );
    $url = wp_get_attachment_url( $_POST['image_attachment_id'] );
  endif;

  wp_enqueue_media();
  
  ?>

    <div class="wrap">

    <h1>Scriptlabs Loader Image</h1>

      <div class="card">

        <form action="<?php echo get_site_url()?>/wp-admin/options-general.php?page=sl-loader-options" method="post">
          
          <h3>Imagen</h3>
          <p>Imagen a mostrar al guardar un formulario</p>
          <table class="form-table">
              <tbody>
                  <tr>
                    <th scope="row">
                      <img id='image-preview' src='<?php echo $url;?>' width='100' height='100' style='max-height: 200px; width: 200px;'>
                    </th>
                    <td>
                      <input id="upload_image_button" type="button" class="button" value="<?php _e( 'Selecionar imagen' ); ?>" />
                      <input type='hidden' name='image_attachment_id' id='image_attachment_id' value='<?php echo $id_image; ?>'>
                    </td>
                  </tr>
              </tbody>
          </table>
          <p class="submit"><input type="submit" value="Guardar" class="button-primary" name="Submit"></p>
        </form>

      </div>

    </div>

  <?php

}


add_action( 'admin_footer', 'media_selector_print_scripts' );

function add_scripts() {
  wp_enqueue_script( 'sl-loader-script', SL_LOADER_URL . 'js/init.js' , array('jquery'),'1.0.0',true  );
}

if(is_admin()){
  wp_enqueue_script( 'sl-loader-script', SL_LOADER_URL . 'js/init.js' , array('jquery'),'1.0.0',true  );
}

