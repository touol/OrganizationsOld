///assets/components/organizations/js/export_ca.js
getTables.Callbacks.add('Table.sets.before', 'sets_before', function() {
	console.log("getTables.sendData.data",getTables.sendData.data);
	if(getTables.sendData.data.button_data.action == "organizations/export_ca"){
		$table = getTables.sendData.$GtsApp;
		filters = getTables.Table.getFilters($table);
		table_data = $table.data();

		filters['hash'] = table_data.hash;
		filters['table_name'] = table_data.name;
		query = $.param(filters);
		window.open(getTablesConfig.actionUrl + '?' + query + '&gts_action=organizations/export_ca&load_model=1&ctx=' + getTablesConfig.ctx, '_blank');
	}
});