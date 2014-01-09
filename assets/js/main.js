ko.bindingHandlers.ckeditor = {
	init: function (element, valueAccessor, allBindingsAccessor, context) {
		var options = allBindingsAccessor().ckeditorOptions || {};
		var modelValue = valueAccessor();
		var value = ko.utils.unwrapObservable(valueAccessor());

		var editor = CKEDITOR.replace(element);

		editor.on('blur', function (e) {
			var self = this;
			context.message(editor.getData());
		}, modelValue, element);
	}
};

var EditorModel = function() {
	var main = this;

	main.timer_id;

	main.url = ko.observable();
	main.subject = ko.observable();
	main.message = ko.observable();
	main.volume = ko.observable();
	main.issue = ko.observable();

	main.drafts = ko.observableArray();
	main.sent = ko.observableArray();

	main.getMessages = function() {
		main.timer_id = setTimeout(main.getMessages, 30000);

		jQuery.ajax({
			url: "getmessages.php",
			dataType: "json",
			type: "post",
			data: {
				type: "sent"
			},
		}).done(function(data) {main.sent(data);});

		jQuery.ajax({
			url: "getmessages.php",
			dataType: "json",
			type: "post",
			data: {
				type: "draft"
			},
		}).done(function(data) {main.drafts(data);});
	};

	main.preview = function() {
		jQuery.ajax({
			url: "preview.php",
			dataType: "json",
			type: "post",
			data: {
				message: main.message(),
				volume: main.volume(),
				issue: main.issue()
			}
		})
		.done(main.previewSuccess)
		.fail(main.previewFailure);
	};

	main.loadMessage = function( url, type ) {
		switch(type) {
			case 'draft':
				break;
			case 'sent':
				break;
		}
		console.log(url);
	};

	main.send = function() {

	};

	main.previewSuccess = function(data) {
		main.url(data.url);

		window.open(main.url(), '_blank');
	};

	main.previewFailure = function(jqXHR, textStatus, errorThrown) {
		alert('Preview Failed: ' + errorThrown);
	};

	main.sendSuccess = function() {

	};

	main.sendFailure = function() {

	};

	main.getMessages();
}

ko.applyBindings(new EditorModel());