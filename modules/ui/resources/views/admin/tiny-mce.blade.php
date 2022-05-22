@php
	/**
     * @var $assetManager \WezomCms\Core\Contracts\Assets\AssetManagerInterface
     */

	$contentCssFiles = collect([
		'build/tinymce.css',
		'fonts/fonts.css'
	])->filter(function ($path) {
		return is_file(public_path($path));
	})->map(function ($path) use ($assetManager) {
		return $assetManager->addVersion(asset($path));
	});
@endphp

<script>
	window.tinyConfig = {
		branding: false,
		body_class: 'wysiwyg',
		content_css: '{{ $contentCssFiles->implode(',') }}',
		content_css_cors: true,
		convert_urls: false,
        fontsize_formats: '13px=0.8125em 14px=0.875em 15px=0.9375em 16px=1em 17px=1.0625em 18px=1.125em 19px=1.1875em 20px=1.25em 24px=1.5em',
		fix_list_elements: true,
		image_advtab: true,
		image_caption: true,
		mobile: {
			theme: 'mobile',
			height: '200',
			plugins: ['autosave', 'lists', 'autolink'],
			toolbar: ['undo', 'bold', 'italic', 'styleselect']
		},
		plugins: [
			'advlist autolink lists link image charmap preview print hr',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons paste textcolor colorpicker textpattern'
		],
		relative_urls: false,
		theme: 'wezom',
		toolbar1: 'undo redo pastetext | bold italic forecolor backcolor fontsizeselect styleselect | alignleft aligncenter alignright alignjustify',
		toolbar2: 'bullist numlist outdent indent | link unlink image media fullscreen currentdate PreviewButton',
		toolbar: 'preview',
		visualblocks_default_state: true,
		setup: function (editor) {
			function toTimeHtml (date) {
				return '<time datetime="' + date.toString() + '">' + date + '</time>';
			}

            function insertDate() {
                var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                var selectorLang = $(editor.targetElm).data('lang');

                if (selectorLang === 'ua') {
                    selectorLang = 'uk';
                }

                selectorLang = selectorLang || language;
                editor.insertContent(toTimeHtml(new Date().toLocaleDateString(selectorLang, options)));
            }

            editor.addButton('currentdate', {
                icon: 'insertdatetime',
                tooltip: 'Insert date\/time',
                onclick: insertDate
            });

            editor.addButton('PreviewButton', {
                icon: 'preview',
                tooltip: 'Preview',
                onclick: function () {
                    editor.execCommand('mcePreview');
                    $('html').addClass('mce-open');
                    return false;
                }
            });

            editor.on('CloseWindow', function () {
                $('html').removeClass('mce-open');
                return false;
            });
        },
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = '/filemanager?field_name=' + field_name;
            if (type === 'image') {
                cmsURL = cmsURL + '&type=Images';
            } else {
                cmsURL = cmsURL + '&type=Files';
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: 'yes',
                close_previous: 'no'
            });
        }
    };
</script>
