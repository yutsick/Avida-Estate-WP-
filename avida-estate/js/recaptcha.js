var contactPageRecaptcha;
var pageHeroRecaptcha;
var agentModalRecaptcha;
var agentHeroRecaptcha;
var contactWidgetRecaptcha;
var contactShortcodeRecaptcha;
var workWithAgentRecaptcha;

var onloadCallback = function() {
    if (jQuery('#pxp-contact-page-recaptcha').length > 0) {
        contactPageRecaptcha = grecaptcha.render('pxp-contact-page-recaptcha', {
            'sitekey' : captcha_vars.site_key
        });
    }

    if (jQuery('#pxp-page-hero-recaptcha').length > 0) {
        pageHeroRecaptcha = grecaptcha.render('pxp-page-hero-recaptcha', {
            'sitekey': captcha_vars.site_key,
            'theme': captcha_vars.theme_mode == 'dark' ? 'dark' : 'light'
        });
    }

    if (jQuery('#pxp-agent-modal-recaptcha').length > 0) {
        agentModalRecaptcha = grecaptcha.render('pxp-agent-modal-recaptcha', {
            'sitekey': captcha_vars.site_key
        });
    }

    if (jQuery('#pxp-agent-hero-recaptcha').length > 0) {
        agentHeroRecaptcha = grecaptcha.render('pxp-agent-hero-recaptcha', {
            'sitekey': captcha_vars.site_key,
            'theme': captcha_vars.theme_mode == 'dark' ? 'dark' : 'light'
        });
    }

    if (jQuery('#pxp-contact-widget-recaptcha').length > 0) {
        contactWidgetRecaptcha = grecaptcha.render('pxp-contact-widget-recaptcha', {
            'sitekey': captcha_vars.site_key,
            'size': 'compact'
        });
    }

    if (jQuery('#pxp-contact-shortcode-recaptcha').length > 0) {
        contactShortcodeRecaptcha = grecaptcha.render('pxp-contact-shortcode-recaptcha', {
            'sitekey': captcha_vars.site_key,
            'theme': captcha_vars.theme_mode == 'dark' ? 'dark' : 'light'
        });
    }

    if (jQuery('#pxp-work-with-agent-recaptcha').length > 0) {
        workWithAgentRecaptcha = grecaptcha.render('pxp-work-with-agent-recaptcha', {
            'sitekey': captcha_vars.site_key
        });
    }
};