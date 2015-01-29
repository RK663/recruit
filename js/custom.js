(function() {
	tinymce.PluginManager.add('recruit_button', function( editor, url ) {
		editor.addButton('recruit_button', {
			text: 'Select Button',
			icon: false,
			type: 'menubutton',
			menu: [
				{
					text: 'Large Button',
					onclick: function() {
						editor.insertContent('<h1>Large Button</h1>');
					}
				},
				{
					text: 'Button Medium',
					onclick: function() {
						editor.insertContent('<h3>Medium Button</h3>');
					}
				},
				{
					text: 'Custom Button',
					onclick: function() {
						editor.windowManager.open({
							title: 'Customize your button',
							body: [
								{
									type: 'textbox',
									name: 'textboxname',
									label: 'Text Box',
									value: '30'
								}
							],
							onsubmit: function(e) {
								editor.insertContent('Its your value' + e.data.textboxname);
							}
						});
					}
				}
			]
		});
	});
})();