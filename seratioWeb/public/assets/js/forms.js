$(document).ready(function() {
	$('[data-method]').click(function(e) {
		e.preventDefault();

		var method = $(this).attr('data-method'),
			$form = $('<form>').attr('action', $(this).attr('href'));
		if ($(this).attr('data-confirm')) {
			var confirmed = confirm($(this).attr('data-confirm'));
			if (!confirmed) {
				return false;
			}
		}
		if (/GET|POST/.exec(method)) {
			$form.attr('method', method);
		} else {
			$form.attr('method', 'POST');
			$form.append(
				$('<input name="_method">')
					.attr('type', 'hidden')
					.val(method));
		}
		$form.submit();
	});
});