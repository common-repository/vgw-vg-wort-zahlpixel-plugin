<?php
/*
Plugin Name: VG-Wort Krimskram
Plugin URI: http://maheo.eu/vgw 
Description:  A simple plugin to add a VG-Wort Zaehlpixel to posts/pages.
Version: 1.0.4
Author: Heiner Otterstedt
Author URI: http://www.hobby-garten-blog.de/heiner-otterstedt
License: GPL2
*/

// --- Config ---
$vgw_min_characters = 1800;
$vgw_pixel_field = "vgwpixel";
$vgw_show_before_content = false;
$vgw_want_custommetabox = true;

add_filter('the_content', 'vgw_add_pixel');

function vgw_add_pixel($content)
{ global $post;
  global $more;
  global $vgw_pixel_field;
  global $vgw_show_before_content;

  $pixel = get_post_meta($post->ID, $vgw_pixel_field, false);
  $pixel = $pixel[0];

  /*
   * Variable $more: http://ifacethoughts.net/2006/07/23/more/
   */
  if($more && $pixel && $pixel != '')
  { if($vgw_show_before_content) { $out  = '<div id="vgwpixel">' . $pixel . '</div>' . $content; }
    else                         { $out  = $content . '<div id="vgwpixel">' . $pixel . '</div>'; }
    return $out;
  }
  else
  { return $content; 
  }
}

// --- Zusätzliche Spalte mit VGW-Pixel-Infos bei "Manage Posts" einfügen ---
add_filter('manage_posts_columns', 'vgw_count_chars');
add_filter('manage_pages_columns', 'vgw_count_chars');

function vgw_count_chars($defaults)
{ $defaults['count'] = 'Anzahl Zeichen';
  return $defaults;
}

add_action('manage_posts_custom_column', 'vgw_custom_column', 10, 2);
add_action('manage_pages_custom_column', 'vgw_custom_column', 10, 2);

function vgw_custom_column($column, $post_id)
{ global $post;
  global $vgw_min_characters;
  global $vgw_pixel_field;

  if($column == 'count')
  { $vgw_char_count = strip_tags($post->post_content);
    echo strlen(utf8_decode($vgw_char_count)).' '.' Zeichen';

    // Hat der betreffende Beitrag schon einen VG-Wort Pixel?
    $vgw_pixel = get_post_meta($post->ID, $vgw_pixel_field, false);
    $vgw_pixel = $vgw_pixel[0];

    if($vgw_pixel)
    { echo '<br/><span style="color:green">VGW-Pixel vorhanden</span>';
    }
    else
    { // wenn der Count größer ist als 1800, dann soll das hervorgehoben werden
      if(strlen(utf8_decode($vgw_char_count)) < $vgw_min_characters) echo '<br/>Artikel zu kurz';
      else                                                           echo '<br/><span style="color:red">VGW-Pixel möglich</span>';
    }
    // Kommt im Artikel die Zeichenfolge "met.vgwort.de/na" vor?
    // Falls ja rote Warnung, um die Konsistenz im Blog zu wahren.
    if(stristr($post->post_content, 'met.vgwort.de/na'))
    { echo '<br/><span style="color:red">VGW-Pixel bereits im Artikel vorhanden</span>';
    }
  }
}

// --- Zusätzliche Information unter den "Edit Post" Eingabefeld

class CharactersCountVgw
{ var $text;
  var $characters;

  function set_text($text)
  { $this->text = strip_tags($text);
    $this->characters = -1;
  }

  function count_characters()
  { if ($this->text == '') { return(0); }		
    if ($this->characters != -1) { return($this->characters); }
    $count = strlen(utf8_decode($this->text));
    $this->characters = $count;
    return($count);
  }
}

function vgw_admin_footer()
{ global $wpdb;
  global $post;

  if($post->post_content != '')
  { $counter = new CharactersCountVgw;
    $counter->set_text($post->post_content);
    $thehtml = sprintf('<span class="inside">Anzahl Zeichen:'.' %d '.'</span> ', $counter->count_characters() );
    printf('<script language="javascript" type="text/javascript"> var div = document.getElementById("post-status-info"); if (div != undefined) { div.innerHTML = div.innerHTML + \'%s\'; } </script>', str_replace("'", "\'", $thehtml));
  }
}

add_action('admin_footer', 'vgw_admin_footer');


// --- Custom Meta Box ---
// siehe: http://codex.wordpress.org/Function_Reference/add_meta_box

if($vgw_want_custommetabox)
{ add_action('add_meta_boxes', 'vgw_add_custom_box');
  add_action('save_post', 'vgw_save_postdata');
}

function vgw_add_custom_box()
{ add_meta_box('vgw_sectionid', __( 'VG-Wort', 'vgw_textdomain' ), 'vgw_inner_custom_box', 'page', 'side', 'core');
  add_meta_box('vgw_sectionid', __( 'VG-Wort', 'vgw_textdomain' ), 'vgw_inner_custom_box', 'post', 'side', 'core');
}

function vgw_inner_custom_box( $post )
{ global $post;

  wp_nonce_field( plugin_basename( __FILE__ ), 'vgw_noncename' );
  echo '<label for="vgwpixel">';
  _e("VG-Wort Pixel", 'vgw_textdomain' );
  echo '</label> ';


  // *** funktioniert hier leider noch nicht
  $mydata = get_post_meta($post->ID, 'vgwpixel', true);

  echo '<input id="vgwpixel" type="text" name="vgwpixel" value="';
  echo htmlspecialchars($mydata);
  echo '" size="26" />';
}

function vgw_save_postdata($post_id)
{

  if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  if(!wp_verify_nonce( $_POST['vgw_noncename'], plugin_basename( __FILE__))) return;

  if( 'page' == $_POST['post_type'] )
  {  if(!current_user_can( 'edit_page', $post_id)) return;
  }
  else
  { if(!current_user_can( 'edit_post', $post_id)) return;
  }


  $mydata = $_POST['vgwpixel'];

  // Notabene: update ist nicht möglich, wenn der 4. Parameter true ist!
  delete_post_meta($post_id, 'vgwpixel');

  if($mydata && $mydata != '')
  { add_post_meta($post_id, 'vgwpixel', $mydata, true);
  }
}


?>
