Ext.onReady(function() {
	Organizations.config.connector_url = OfficeConfig.actionUrl;

	var grid = new Organizations.panel.Home();
	grid.render('office-organizations-wrapper');

	var preloader = document.getElementById('office-preloader');
	if (preloader) {
		preloader.parentNode.removeChild(preloader);
	}
});