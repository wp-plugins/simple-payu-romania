<?php
/*
Copyright 2015  Softpill.eu  (email : mail@softpill.eu)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function sp_spr_admin_icon()
{
	echo '
		<style> 
      #toplevel_page_sp_spr_payment_forms div.wp-menu-image:before { content: "\f174"; }
		</style>
	';
  //get other icons from http://melchoyce.github.io/dashicons/
}
add_action( 'admin_head', 'sp_spr_admin_icon' );
add_action('admin_menu', 'sp_spr_menus');

function sp_spr_menus() {
    add_menu_page('Simple PayU Romania', 'Simple PayU Romania', 'administrator', 'sp_spr_payment_forms', 'sp_spr_payment_forms',"","26.1345622");
    add_submenu_page('sp_spr_payment_forms', 'Payment Forms', 'Payment Forms', 'administrator', 'sp_spr_payment_forms', 'sp_spr_payment_forms');
    add_submenu_page('sp_spr_payment_forms', 'Records', 'Records', 'administrator', 'sp_spr_records', 'sp_spr_records');
    add_submenu_page('sp_spr_payment_forms', 'Settings', 'Settings', 'administrator', 'sp_spr_settings', 'sp_spr_settings');
    add_submenu_page('sp_spr_payment_forms', 'About', 'About', 'administrator', 'sp_spr_about', 'sp_spr_about');
    
    add_action( 'admin_init', 'sp_spr_register_settings' );
}

function sp_spr_register_settings() {
	register_setting( 'sp_spr_settings_group', 'sp_spr_payuromania_user' );
  register_setting( 'sp_spr_settings_group', 'sp_spr_payuromania_password' );
}

function sp_spr_admin_notice() {
  global $pagenow;
  if ($pagenow == 'admin.php' && $_GET['page'] == 'sp_spr_settings') {
    $errors = get_settings_errors();
    if(isset($errors[0]['message']))
    {
      ?>
      <div class="<?php echo $errors[0]['type'];?>">
          <p><?php echo $errors[0]['message'];?></p>
      </div>
      <?php
    }
  }
}
add_action( 'admin_notices', 'sp_spr_admin_notice' );
function sp_spr_settings() {
    $sp_spr_payuromania_user = (get_option('sp_spr_payuromania_user') != '') ? get_option('sp_spr_payuromania_user') : '';
    $sp_spr_payuromania_password = (get_option('sp_spr_payuromania_password') != '') ? get_option('sp_spr_payuromania_password') : '';
    
    ?>
            <form method="post" action="options.php">
            
            <?php settings_fields( 'sp_spr_settings_group' ); ?>
            <?php do_settings_sections( 'sp_spr_settings_group' ); ?>
            
            <h2>PayU Romania Configuration</h2>

            <table class="form-table">
                <tr>
                      <th scope="row"><label for="sp_spr_payuromania_user">PayU Merchant ID</label></th>
                      <td><input type="text" name="sp_spr_payuromania_user" id="sp_spr_payuromania_user" value="<?php echo $sp_spr_payuromania_user;?>" /></td>
                </tr>
                <tr>
                      <th scope="row"><label for="sp_spr_payuromania_password">PayU Secret Key</label></th>
                      <td><input type="text" name="sp_spr_payuromania_password" id="sp_spr_payuromania_password" value="<?php echo $sp_spr_payuromania_password;?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
            </form>
    <?php
}
?>