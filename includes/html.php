<?php
/**
 * Base HTML.
 *
 * @package Unless
 * @author  Unless
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function unless_get_html() {
	if ( isset($_GET['settings-updated']) ) {
		$snackbar = '<div id="unless-toast" class="mdl-js-snackbar mdl-snackbar">
			  <div class="mdl-snackbar__text"></div>
			  <button class="mdl-snackbar__action" type="button"></button>
		</div>';
	} else { $snackbar =''; }
		
	if ( !get_option('unless_data') ) {
		$submitButton = '<button type="submit" id="unless-get-started" class="mdl-button mdl-js-button mdl-button--raised mdl-button--primary">' . __( 'Install', 'unless' ) . '
			<i class="material-icons" style="margin-left: 5px; margin-top: -4px;">save</i></button>
			<span data-mdl-for="unless-get-started" class="mdl-tooltip mdl-tooltip--large mdl-tooltip--right">This will install Unless on your website.</span>';
		$getStartedButton = '<a id="unless-trial" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" href="https://unless.com/" target="_blank" >Get started</a>
		<span data-mdl-for="unless-trial" class="mdl-tooltip mdl-tooltip--large mdl-tooltip--left">Click to sign up at the Unless website.</span>';
		$accountMessage = '&nbsp;<small>Don&apos;t have an account yet? 
			<a href="https://unless.com/?utm_source=unless+wp+plugin&amp;utm_medium=link&amp;unless_page=wordpress" target="_blank">' . __( "Get started now", 'unless' ) . ' &raquo;</a>
		  </small>';
		  $dialog= '<dialog style="z-index:1000;" id="unless-dialog" class="mdl-dialog">
			<h4 class="mdl-dialog__title">Signed up?</h4>
			<div class="mdl-dialog__content">
			  <p>
				To use this plugin, you need an Unless account ID. Sign up <a href="https://unless.com/" target="_blank" title="Unless">at Unless.com</a>.
			  </p>
			</div>
			<div class="mdl-dialog__actions">
			  <button type="button" class="mdl-button close">Continue</button>
			</div>
	  </dialog>';
	} else {
		$submitButton = '<button type="submit" id="unless-update-settings" class="mdl-button mdl-js-button mdl-button--raised">' . __( 'Update settings', 'unless' ) . '
			<i class="material-icons" style="margin-left: 5px; margin-top: -4px;">autorenew</i></button>
			<span data-mdl-for="unless-update-settings" class="mdl-tooltip mdl-tooltip--large mdl-tooltip--right">Click here to install Unless using a different account ID.</span>';
		$getStartedButton = '<a id="unless-edit" class="mdl-button mdl-button--primary mdl-js-button mdl-button--raised mdl-js-ripple-effect" href="https://unless.com/en/dashboard" target="_blank">' . __( "Go to your dashboard", 'unless' ) . '
		<i class="material-icons" style="margin-left: 5px; margin-top: -4px;">computer</i></a>
		<span data-mdl-for="unless-edit" class="mdl-tooltip mdl-tooltip--large mdl-tooltip--left">Click to start creating variations on your own website.</span>';
		$accountMessage = '&nbsp;<small>Find your account ID in your  
				<a href="https://unless.com/en/dashboard/account/settings" target="_blank">Unless dashboard.</a>
				</small>';
		$dialog = '';
	}


	$output = $snackbar . $dialog . '<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
		  <header class="mdl-layout__header">
			<div class="mdl-layout__header-row">
			  <!-- Title -->
			  <span class="unless-logo-wrapper mdl-layout-title">
				<a href="https://unless.com/" title="Unless" target="_blank">
					<img id="unless-logo" src="' . UNLESS_PLUGIN_URL . 'svg/unless.svg" onerror="this.onerror=null; this.src=\'' . UNLESS_PLUGIN_URL . 'images/unless.png\'" alt="Unless" />
				</a>
			  </span>
			  <!-- Add spacer, to align navigation to the right -->
			  <div class="mdl-layout-spacer"></div>
			  <!-- Navigation. We hide it in small screens. -->
			  <nav class="mdl-navigation mdl-layout--large-screen-only">
				<a class="mdl-navigation__link mdl-typography--text-uppercase" target="_blank" href="https://unless.com/en/pricing">Pricing</a>
				<a class="mdl-navigation__link mdl-typography--text-uppercase" target="_blank" href="https://unless.com/en/help">Help</a>
				<a class="mdl-navigation__link mdl-typography--text-uppercase" target="_blank" href="https://unless.com/en/dashboard">Dashboard</a>
			  </nav>
			</div>
		  </header>
		  <div class="mdl-layout__drawer">
			<span class="unless-logo-wrapper mdl-layout-title">
				<a href="https://unless.com/" title="Unless" target="_blank">
					<img id="unless-drawer-logo" src="' . UNLESS_PLUGIN_URL . 'svg/unless.svg" onerror="this.onerror=null; this.src=\'' . UNLESS_PLUGIN_URL . 'images/unless.png\'" alt="Unless" />
				</a>
			</span>
			<nav class="mdl-navigation">
			  <a class="mdl-navigation__link mdl-typography--text-uppercase" target="_blank" href="https://unless.com/en/pricing">Pricing</a>
				<a class="mdl-navigation__link mdl-typography--text-uppercase" target="_blank" href="https://unless.com/en/help">Help</a>
				<a class="mdl-navigation__link mdl-typography--text-uppercase" target="_blank" href="https://unless.com/en/dashboard">Dashboard</a>

			</nav>
		  </div>
		  <main class="mdl-layout__content">
			<div class="page-content">
				<div style="float:right;">
					<div style="display: inline-block;">'
						. $getStartedButton . 
					'</div>
				</div>
				<br />
				<h2>Install Unless <small>&nbsp;' . __( 'optimize', 'unless' ) . ' conversion rates on Wordpress</small></h2>
				<div class="mdl-card mdl-shadow--2dp">
					<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
					  <div class="mdl-tabs__tab-bar">
						  <a href="#unless-settings-tab" class="mdl-tabs__tab is-active">Settings</a>
						  <a href="#unless-faq-tab" class="mdl-tabs__tab">FAQ</a>
					  </div>
						<section class="mdl-tabs__panel is-active" id="unless-settings-tab">
							<form method="post" class="unless-form" action="options.php">' 
								. wp_nonce_field('update-options') . 
								'<input type="hidden" name="action" value="update" />
								<input type="hidden" name="page_options" value="unless_data" />
								<div class="mdl-grid">
								  <div class="mdl-cell mdl-cell--3-col" style="padding-top: 25px;">
									 Your account ID
								  </div>
								  <div class="mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet">
									 <div class="mdl-textfield mdl-js-textfield">
										<input type="text" id="unless_data" name="unless_data" value="' . get_option('unless_data') . '" pattern="[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"  class="mdl-textfield__input">
										<label class="mdl-textfield__label" for="unless_data">xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx</label>
										<span class="mdl-textfield__error">This doesn&apos;t look like it is an account ID..</span>
									 </div>
								  </div>
								  <div class="mdl-cell mdl-cell--3-offset-desktop mdl-cell--9-col-desktop mdl-cell--12-col-tablet">
									 <div style="display: inline-block; margin-right:10px; ">
										' . $submitButton . '
									 </div>'
									 . $accountMessage . 
								  '</div>
							   </div>
							</form>
						</section>
						<section class="mdl-tabs__panel" id="unless-faq-tab">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--7-col mdl-cell--10-col-tablet mdl-cell--12-col-phone">
									<h4>What is this plugin for?</h4>
									<p>
										<em>Unless for Wordpress</em> ' . __( 'is a free plugin to install ', 'unless' ) .' <a href="https://unless.com/" target=_blank">Unless</a> on your Wordpress website.
									</p>
									<h4>What does Unless do?</h4>
									<p>
										Unless is a personalization engine. It makes your web pages change content depending on who looks at them. 
									</p>
									<h4>Why would I want to do that?</h4>
									<p>
										If you show tailored versions of your web pages to your diverse audiences, it increases conversion rates and ad revenue. 
									</p>
									<h4>How does that work?</h4>
									<p>
									 Please go to the renewed <a target="_blank" href="https://unless.com/en/help">Help Center</a> to find out.	
									</p>
							
									<h4>How do I get started?</h4>
									<p>
									 Please go to the renewed <a target="_blank" href="https://unless.com/en/help">Help Center</a> to find out.	
									</p>
									
									<h4>How can I upgrade to version 5?</h4>
									<p>
										Please go to your 
										<a href="https://unless.com/en/dashboard/" target="_blank">Unless dashboard.</a> to upgrade.
									</p>
									<h4>Why is version 5 so much better?</h4>
									<p>
										It is faster and has more features enabled.
									</p>
									<h4>Where can I find my account ID?</h4>
									<p>
										You can find your account ID in your  
										<a href="https://unless.com/en/dashboard/account/settings" target="_blank">Unless dashboard.</a>
									</p>
									<h4>But... I don&apos;t have an account yet!?</h4>
									<p>
										No problem! Just go to our website to <a href="https://unless.com/?utm_source=unless+wp+plugin&amp;utm_medium=link&amp;unless_page=wordpress" target="_blank">' . __( "get started", 'unless' ) . '</a>.
									</p> 	
								</div>
							</div>
						</section>
					</div>
				</div>
				<br />
				<span class="mdl-chip">
					<span class="mdl-chip__text">CRO</span>
				</span>
				<span class="mdl-chip">
					<span class="mdl-chip__text">Message matching</span>
				</span>
				<span class="mdl-chip">
					<span class="mdl-chip__text">Conversion Rate Optimization</span>
				</span>
				<span class="mdl-chip">
					<span class="mdl-chip__text">Increase ad revenue</span>
				</span>
				<span class="mdl-chip">
					<span class="mdl-chip__text">Personalization</span>
				</span>
			</div>
		</div>
	</main>';
	return $output;
}