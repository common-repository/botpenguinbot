<?php
/**
 * Plugin Name: Botpenguin
 * Plugin URI: https://botpenguin.com
 * Description: BotPenguin is an AI powered chatbot platform that enables you to quickly and easily build incredible chatbots to communicate and engage your customers on website, Facebook messenger and other platforms.
 * Version: 1.5.1
 * Author: BotPenguin
 * Author URI: https://botpenguin.com
 * License: GPL2
 * Text Domain: botpenguinbot
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
add_action('wp_head', 'BOTPENGUIN_function');

function BOTPENGUIN_function()
{
  $textvar = get_option('test_plugin_variable', 'botpenguin bot script');

  $custom_js = "<script id='BotPenguin-messenger-widget' src='https://cdn.botpenguin.com/botpenguin.js' defer>${textvar}</script>";
  // Output the JavaScript code to the head
  echo $custom_js;
}

/**
 * Activate the plugin.
*/ 
register_activation_hook(__FILE__, 'BOTPENGUIN_activate');
add_action('admin_init', 'BOTPENGUIN_redirect');

function BOTPENGUIN_activate() {
    add_option('BOTPENGUIN_do_activation_redirect', true);
}

function BOTPENGUIN_redirect() {
    if (get_option('BOTPENGUIN_do_activation_redirect', false)) {
        delete_option('BOTPENGUIN_do_activation_redirect');
        wp_redirect('admin.php?page=botpenguinbot%2Fbotpenguinbot.php');
    }
}

add_action('admin_menu', 'BOTPENGUIN_admin_menu');

function BOTPENGUIN_admin_menu()
{
	 add_menu_page('BotPenguin', 'BotPenguin', 'manage_options', __FILE__, 'BOTPENGUIN_footer_text_admin_page','dashicons-format-chat');
  //add_management_page('BotPenguin', 'BotPenguin', 'manage_options', __FILE__, 'BOTPENGUIN_footer_text_admin_page');
}

function BOTPENGUIN_footer_text_admin_page()
{

  $textvar = get_option('test_plugin_variable', 'botpenguin bot script');
  if (isset($_POST['change-clicked'])) {
 
    if ( ! isset( $_POST['my_botpenguin_update_setting'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['my_botpenguin_update_setting'] ) ), 'botpenguin-update-setting' ) ) {
      die( "<br><br>Hmm .. looks like you didn't send any credentials.. No CSRF for you! " );
    }
    $footertext = esc_url_raw($_POST['footertext']);
    $footerval = explode('//',$footertext);
    update_option('test_plugin_variable', end($footerval));
    $textvar = get_option('test_plugin_variable', 'botpenguin bot script');
  }

  ?>
<div class="wrap">
  <div id="poststuff">
    <div id="post-body" class="metabox-holder columns-2">
      <div id="post-body-content">
        <div class="postbox">
          <div class="inside">
          <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/logo.png'; ?>" alt="BotPenguin">
            <h1>
              BotPenguin - Settings
              </h1>
            <h3 class="cc-labels"><?php esc_html_e('Instructions: ', 'botpenguinbot'); ?></h3>

            <p>1.
              <?php esc_html_e('If you do not have a BotPenguin account, please log on to <a href="https://app.botpenguin.com" target="_blank">BotPenguin</a>, and sign up', 'botpenguinbot'); ?>
            </p>
			<p>2.
              <?php esc_html_e('Create your website chatbot, choosing a template or from scratch. Check out this video if you need help in building the chatflow.', 'botpenguinbot'); ?>
            </p>
			<p>
			<a href="https://www.youtube.com/watch?v=r_djmDuX988" target="_blank">How to create an effective chatflow using BotPenguin</a>
			</p>
            <p>3.
              <?php esc_html_e('Once you are ready, you can click on install, then choose WordPress, and obtain the key snippet.', 'botpenguinbot'); ?>
            </p>
			<p>4.
              <?php esc_html_e('Paste it below and you are done.', 'botpenguinbot'); ?>
            </p>
			<p>
				<a class="add-new-h2" target="_blank" href="<?php echo esc_url("https://help.botpenguin.com/botpenguin-resource-center/how-botpenguin-works/install-your-website-chatbot/install-website-bot-on-wordpress"); ?>">
                <?php esc_html_e('Read Tutorial', 'botpenguinbot'); ?>
              </a> <a class="add-new-h2" target="_blank" href="<?php echo esc_url("https://youtu.be/ZRtAz78LSOI"); ?>">
                <?php esc_html_e('Watch Tutorial', 'botpenguinbot'); ?></a>
			</p>
            <h3 class="cc-labels" for="script"><?php esc_html_e('BotPenguin Key Snippet:', 'botpenguinbot'); ?></h3>
            <?php $PHP_SELF = sanitize_url($_SERVER['REQUEST_URI']); ?>
            <form action="<?php echo esc_url($PHP_SELF); ?>" method="post">
              <input style="width:100%" type="text" class="regular-text" value="<?php echo esc_html($textvar); ?>" placeholder="Paste your BotPenguin Key here, it resembles e056149d872d8429c7hduofhuhu8e56fb193dcc6c933f5" name="footertext">
              <input name="change-clicked" type="hidden" value="1" />
              <input name="my_botpenguin_update_setting" type="hidden" value="<?php echo wp_create_nonce('botpenguin-update-setting'); ?>" />
              <br />
              <br />
              <input class="button button-primary" type="submit" value="<?php esc_html_e('Save settings', 'botpenguinbot'); ?>" />
            </form>
          </div>
        </div>
      </div>
      <?php require_once('sidebar.php'); ?>
    </div>
  </div>
</div>

<?php
}
?>