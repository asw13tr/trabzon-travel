/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
url_for_config = document.getElementById('URL_SITE').value;
CKEDITOR.editorConfig = function( config ) {

	// Define changes to default configuration here. For example:
	 config.language = 'tr';
	// config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl = 		url_for_config+'assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
   	config.filebrowserImageBrowseUrl = 	url_for_config+'assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
   	config.filebrowserFlashBrowseUrl = 	url_for_config+'assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
   	config.filebrowserUploadUrl = 		url_for_config+'assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
   	config.filebrowserImageUploadUrl = 	url_for_config+'assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
   	config.filebrowserFlashUploadUrl = 	url_for_config+'assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
};
