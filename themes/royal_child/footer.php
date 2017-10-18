<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package GeneratePress
 */
 
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
?>

	</div><!-- #content -->
</div><!-- #page -->
<?php do_action('generate_before_footer'); ?>

<div class="subscribe">
    <div class="subscribe-page">
        <?php if (ICL_LANGUAGE_CODE == 'nl'): ?>
        <div id="mlb2-5186615" class="ml-subscribe-form ml-subscribe-form-5186615">
            <div class="ml-vertical-align-center">
                <div class="subscribe-form ml-block-success" style="display:none">
                    <div class="form-section">
                        <h3>Bedankt!</h3>
                        <p>Je ontvangt zodadelijk een bevestigingsmail.</p>
                    </div>
                </div>
                <form class="ml-block-form" action="//app.mailerlite.com/webforms/submit/l8g9v8" data-id="431671" data-code="l8g9v8" method="POST" target="_blank">
                    <div class="subscribe-form">
                        <div class="form-section mb10">
                            <h3>Schrijf je in op onze nieuwsbrief</h3>
                        </div>
                        <div class="form-section">
                            <div class="form-group ml-field-email ml-validate-required ml-validate-email">
                                <input type="email" name="fields[email]" class="form-control" placeholder="Vul je emailadres in" value="" autocomplete="email" x-autocompletetype="email" spellcheck="false" autocapitalize="off" autocorrect="off">
                            </div>
                        </div>
                        <input type="hidden" name="ml-submit" value="1" />
                        <button type="submit" class="primary">
                            Aanmelden
                        </button>
                        <button disabled="disabled" style="display: none;" type="button" class="loading">
                            <img src="//static.mailerlite.com/images/rolling.gif" width="20" height="20" style="width: 20px; height: 20px;">
                        </button>
                    </div>
                </form>
                <script>
                    function ml_webform_success_5186615() {
                        var $ = ml_jQuery || jQuery;

                        $('.ml-subscribe-form-5186615 .ml-block-success').show();
                        $('.ml-subscribe-form-5186615 .ml-block-form').hide();
                    };
                </script>
            </div>
        </div>
        <script type="text/javascript" src="//static.mailerlite.com/js/w/webforms.min.js?v3772b61f1ec61c541c401d4eadfdd02f"></script>
        <?php else : ?>
        <div id="mlb2-5186615" class="ml-subscribe-form ml-subscribe-form-5186615">
            <div class="ml-vertical-align-center">
                <div class="subscribe-form ml-block-success" style="display:none">
                    <div class="form-section">
                        <h3>Thank you!</h3>
                        <p>You will receive a confirmation email.</p>
                    </div>
                </div>
                <form class="ml-block-form" action="//app.mailerlite.com/webforms/submit/l8g9v8" data-id="431671" data-code="l8g9v8" method="POST" target="_blank">
                    <div class="subscribe-form">
                        <div class="form-section mb10">
                            <h3>Sign up to our newsletter</h3>
                        </div>
                        <div class="form-section">
                            <div class="form-group ml-field-email ml-validate-required ml-validate-email">
                                <input type="email" name="fields[email]" class="form-control" placeholder="Your Email" value="" autocomplete="email" x-autocompletetype="email" spellcheck="false" autocapitalize="off" autocorrect="off">
                            </div>
                        </div>
                        <input type="hidden" name="ml-submit" value="1" />
                        <button type="submit" class="primary">
                            Submit
                        </button>
                        <button disabled="disabled" style="display: none;" type="button" class="loading">
                            <img src="//static.mailerlite.com/images/rolling.gif" width="20" height="20" style="width: 20px; height: 20px;">
                        </button>
                    </div>
                </form>
                <script>
                    function ml_webform_success_5186615() {
                        var $ = ml_jQuery || jQuery;

                        $('.ml-subscribe-form-5186615 .ml-block-success').show();
                        $('.ml-subscribe-form-5186615 .ml-block-form').hide();
                    };
                </script>
            </div>
        </div>
        <script type="text/javascript" src="//static.mailerlite.com/js/w/webforms.min.js?v3772b61f1ec61c541c401d4eadfdd02f"></script>
        <?php endif; ?>
    </div>
</div>

<div <?php generate_footer_class(); ?>>
	<?php 
	do_action( 'generate_before_footer_content' );
	do_action( 'generate_footer' );
	do_action( 'generate_after_footer_content' ); 
	?>
</div><!-- .site-footer -->

<?php wp_footer(); ?>

</body>
</html>