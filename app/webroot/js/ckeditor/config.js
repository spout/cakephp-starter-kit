/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

var kcfinderPath = '/cakephp/kcfinder/';

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.toolbar = 'Basic';
	config.forcePasteAsPlainText = true;
	config.format_tags = 'p;h2;h3;h4;h5;h6;pre;address;div';//default: 'p;h1;h2;h3;h4;h5;h6;pre;address;div' 
	//config.enterMode = CKEDITOR.ENTER_DIV;
	config.entities = false;
	//config.contentsCss = ['/js/ckeditor/contents.css', '/css/ckeditor.css'];
	
	config.toolbar_Full =
	[
	    ['Source','-','Save','NewPage','Preview','-','Templates'],
	    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
	    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
	    ['BidiLtr', 'BidiRtl'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['Link','Unlink','Anchor'],
	    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
	    '/',
	    ['Styles','Format','Font','FontSize'],
	    ['TextColor','BGColor'],
	    ['Maximize', 'ShowBlocks','-','About']
	];	
	
	config.toolbar_Custom =
	[
	    ['Source','-','Templates'],
	    ['Cut','Copy','Paste','PasteText','PasteFromWord'],
	    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	    ['Maximize', 'ShowBlocks'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink','Anchor'],
	    '/',
	    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
	    ['Styles','Format','Font','FontSize'],
	    ['TextColor','BGColor']
	];
	
    config.toolbar_Basic =
    [
        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'NumberedList', 'BulletedList', '-', 'Image', 'Link', 'Unlink']
    ];
    
	config.filebrowserBrowseUrl = kcfinderPath + 'browse.php?type=files';
	config.filebrowserImageBrowseUrl = kcfinderPath + 'browse.php?type=images';
	config.filebrowserFlashBrowseUrl = kcfinderPath + 'browse.php?type=flash';
	config.filebrowserUploadUrl = kcfinderPath + 'upload.php?type=files';
	config.filebrowserImageUploadUrl = kcfinderPath + 'upload.php?type=images';
	config.filebrowserFlashUploadUrl = kcfinderPath + 'upload.php?type=flash';

};
