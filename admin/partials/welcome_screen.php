<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<?php
define( 'TCRM_WELCOME_SRC_FILE_URL', plugin_dir_url( dirname( __FILE__ ) ) );
?>
<div id="tcrm-loader" class="tcrm-d-flex tcrm-w100p" style="justify-content:center">
	<img src="<?php echo esc_attr( TCRM_WELCOME_SRC_FILE_URL . 'assets/loader.gif' ); ?>" alt="TeleCRM"
		style="width: 250px;">
</div>
<div id="tcrm-welcome-screen-1" class="tcrm-d-none">
	<div class="tcrm-img-container">
		<img src="<?php echo esc_attr( TCRM_WELCOME_SRC_FILE_URL . 'assets/telecrm-black-logo.png' ); ?>" alt="TeleCRM"
			style="width: 125px;">
	</div>
	<div class="tcrm-telecrm-info-container">
		<div class="tcrm-heading-container">
			<h1 class="tcrm-main-heading">Simplify Lead Management with <span class="tcrm-telecrm-color">TeleCRM </span>
			</h1>
			<span class="tcrm-info-part">
				<ul>
					<li> Capture WordPress form fills</li>
					<li> Auto-distribute leads based on conditions</li>
					<li> Instantly engage leads using chatbot on WhatsApp</li>
					<li> Run calling campaigns and drip marketing campaigns</li>
					<li> Track team members' work in real time</li>
					<li> Automate the repetitive work with workflows</li>
				</ul>
			</span>
		</div>
		<div class="tcrm-carousel">
			<span id="tcrm-left-chevron" style="display:none;" onclick="slideCarousel(true)"> <img
					src="<?php echo esc_attr( TCRM_WELCOME_SRC_FILE_URL . 'assets/dropdown-chevron.png' ); ?>"
					style="height:10px;"></span>
			<span class="tcrm-pr10 tcrm-carousel-img-cover"><img class="tcrm-carousel-img"
					src="<?php echo esc_attr( TCRM_WELCOME_SRC_FILE_URL . 'assets/1.png' ); ?>"></span>
			<span class="tcrm-pr10 tcrm-carousel-img-cover"><img class="tcrm-carousel-img"
					src="<?php echo esc_attr( TCRM_WELCOME_SRC_FILE_URL . 'assets/2.png' ); ?>"></span>
			<span class="tcrm-pr10 tcrm-carousel-img-cover"><img class="tcrm-carousel-img"
					src="<?php echo esc_attr( TCRM_WELCOME_SRC_FILE_URL . 'assets/3.png' ); ?>"></span>
			<span id="tcrm-right-chevron" onclick="slideCarousel(false)"> <img
					src="<?php echo esc_attr( TCRM_WELCOME_SRC_FILE_URL . 'assets/dropdown-chevron.png' ); ?>"
					style="height:10px;"></span>
		</div>
	</div>
	<div class="tcrm-get-start-container">
		<button class="tcrm-btn tcrm-btn-primary tcrm-get-start-btn" onclick="switchToPluginDetails()">Get
			Started</button>
		<a href="https://telecrm.in" target="_blank" class="tcrm-telecrm-color"> Learn more</a>
	</div>
</div>