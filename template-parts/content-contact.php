<?php 
if( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' ) ){
    $to = "Aaron Salley Design <hello@aaronsalleydesign.com>"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $name = $_POST['_name'];
    $subject = "Form submission";
    $subject2 = "Copy of your form submission";
    $message = $name . " wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "Here is a copy of your message " . $name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    wp_mail($to,$subject,$message,$headers);
    wp_mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    // You can also use header('Location: thank_you.php'); to redirect to another page.
}

function gaEvent() {
	echo "
	<script type='text/javascript'>
	$('#contactForm').on('submit', function(event) {
		ga('send', 'event', 'Contact Us', 'Email sent');
	});
	</script>
	";
}
add_action( 'wp_footer', 'gaEvent' );
?>
<section id="<?php echo $post->post_name; ?>" <?php post_class(); ?>>
	<form role="form" id="contactForm" class="contact-form" action="" method="post">
		<address>
			Aaron Salley Design, LLC</br>
			35-37 36th St., 2nd Fl.</br>
			New York, NY 11106, USA
		</address>
		<?php if( !isset( $_POST['submitted'] ) ) : ?>
		<input name="_name" class="field" type="text" aria-required="true" placeholder="<?php _e( 'Name' ); ?>"></input>
		<input name="email" class="field" type="email" aria-required="true" placeholder="<?php _e( 'Email' ); ?>"></input>
		<textarea name="message" class="field" rows="6" aria-required="true" placeholder="<?php _e( 'Message' ); ?>"></textarea>
        <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
        <input type="hidden" name="submitted" value="true">
		<button type="submit" id="submit" class="submit"><?php _e( 'Submit' ); ?></button>
		<?php else: ?>
		<p><?php _e( 'Message sent. Thank you ' . $name . ', we will contact you shortly.'); ?></p>
		<?php endif; ?>
	</form>
	<div class="map"><a href="<?php echo esc_url('https://www.google.com/maps/place/Aaron+Salley+Design/@40.7552508,-73.9272387,17z/data=!3m1!4b1!4m5!3m4!1s0x89c2f67446270df1:0x1214e460a8b15973!8m2!3d40.7552508!4d-73.9250447'); ?>>" target="_blank"></a></div>
</section>