/*Clipboard Init*/
/*****Ready function start*****/
$(function() {
    /*Clipboard Init*/
    var clipboard = new ClipboardJS('.copy-to-clipboard');

    clipboard.on('success', function(a) {
        var b = bootstrap.Tooltip.getInstance(a.trigger);
        a.trigger.setAttribute('data-bs-original-title', 'Copied!'), b.show(), a.trigger.setAttribute('data-bs-original-title', 'Copy to clipboard'), a.clearSelection()
    });

    clipboard.on('error', function(a) {
        var b = /mac/i.test(navigator.userAgent) ? '\u2318' : 'Ctrl-',
            c = 'Press ' + b + 'C to copy',
            d = bootstrap.Tooltip.getInstance(a.trigger);
        a.trigger.setAttribute('data-bs-original-title', c), d.show(), a.trigger.setAttribute('data-bs-original-title', 'Copy to clipboard')
    });
    
	/*Clipboard for Codeblock Init*/
	var clipboardSnippets = new ClipboardJS('[data-clipboard-snippet]', {
		target: function(trigger) {
			return trigger.nextElementSibling;
		}
	});
	document.querySelectorAll('.copy-to-clipboard,[data-clipboard-snippet]').forEach(function(a) {
        var b = new bootstrap.Tooltip(a,{
			title: 'Copy to clipboard',
			placement: 'top'
		});
        a.addEventListener('mouseleave', function() {
            b.hide();
        })
    });
	clipboardSnippets.on('success', function(a) {
        var b = bootstrap.Tooltip.getInstance(a.trigger);
        a.trigger.setAttribute('data-bs-original-title', 'Copied!'), b.show(), a.trigger.setAttribute('data-bs-original-title', 'Copy to clipboard'), a.clearSelection()
    });
	clipboardSnippets.on('error', function(a) {
        var b = /mac/i.test(navigator.userAgent) ? '\u2318' : 'Ctrl-',
            c = 'Press ' + b + 'C to copy',
            d = bootstrap.Tooltip.getInstance(a.trigger);
        a.trigger.setAttribute('data-bs-original-title', c), d.show(), a.trigger.setAttribute('data-bs-original-title', 'Copy to clipboard')
    });

});