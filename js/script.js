$ = jQuery;

/* Social icons tooltips */
$(".social-icons [class^='icon-'], .social-icons [class*=' icon-']").qtip({
	content: {
  	attr: 'title'
  },
  position: {
		my: 'top center',
		at: 'bottom center',
		viewport: $(window)
  },
  style: {
		classes: 'ui-tooltip-tipsy',
		tip: {
  		width: 10
		}
	}
});