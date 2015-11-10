(function($, site, document, undefined) {
	site.init = function() {
		// search for plugin calls in the form of data-int14ger-plugin="pluginname"
		$('[data-int14ger-plugin]').each(function() {
			var $that = $(this),
				pluginName = $that.data('int14ger-plugin'),
				options = $that.data('int14ger-plugin-options');

			$that[pluginName](options);
		});
	};

	site.neosWorkspaceName = (function() {
		if ($('meta[name="neos-workspace"]').attr('content') !== undefined) {
			return $('meta[name="neos-workspace"]').attr('content');
		} else {
			return 'live';
		}
	})();
})(jQuery, window.site = window.site || {}, document);

jQuery(function() {
	site.init();

	if (typeof document.addEventListener === 'function') {
		document.addEventListener('Neos.PageLoaded', function(event) {
			site.init();
		}, false);
	}
});