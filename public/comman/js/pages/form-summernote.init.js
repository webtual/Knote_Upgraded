jQuery(document).ready(function(){
	$(".summernote-editor").summernote({height:250,minHeight:null,maxHeight:null,focus:!1, 
		toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["fontname", ["fontname"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                //["table", ["table"]],
                //["insert", ["link", "picture", "video"]],
                ["view", ["fullscreen", "codeview", "help"]]
        ],

        callbacks: {
            // callback for pasting text only (no formatting)
            onPaste: function (e) {
              var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
              e.preventDefault();
              bufferText = bufferText.replace(/\r?\n/g, '<br>');
              document.execCommand('insertHtml', false, bufferText);
            }
        }

    }),
	$("#summernote-inline").summernote({airMode:!0})});