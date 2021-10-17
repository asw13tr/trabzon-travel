var URL_SITE = $('input#URL_SITE').val();
var URL_ASSETS = $('input#URL_ASSETS').val();
var URL_UPLOADS = $('input#URL_UPLOADS').val();
var URL_UPLOAD_IMAGES = $('input#URL_UPLOAD_IMAGES').val();
var URL_CURRENT = $('input#URL_CURRENT').val();


$(document).foundation();


function go_back_url(){
    history.back();
	return false;
}





$(function(){
	$('.ckeditor').each(function(e){
        CKEDITOR.replace( $(this).attr('id') );﻿
    });
});

$(window).on('load', function(){

	$('.aswdd a').on("mousedown", function(event){
		$('.aswdd').removeClass('aktif');
		$(this).parent().addClass('aktif');
		event.preventDefault();
		event.stopPropagation();
		return false;
	});


	//RESİM UPLOAD İŞLEMİ KOD BAŞLANGICI
	$('.doUploadButton').on('mousedown', function(event){

		current_item_id = $(this).attr('id');
		upload_item = $('input#upload_file_'+current_item_id);
		upload_item_val = upload_item.val();

		if(upload_item_val!=null && upload_item_val.trim!=''){
			console.log('Upload için change edildi.');

			var id = current_item_id;
			$('img#'+id+"_img").attr('src', URL_ASSETS+'/imgs/loading-100-100.gif');
			$('div#'+id+'_div').attr('style', 'display:block;');

			var formDataList = new FormData(upload_item);
			formDataList.append("image", $(upload_item)[0].files[0]);
				var	postUrl = URL_SITE+"uploadfile/image_ajax";
			console.log('Upload için post url: '+postUrl);
			//console.log(formDataList);

			var formVeri = {
				'image': $(upload_item).val()
			}
			console.log(formVeri);

			$.ajax({
				method: "POST",
				url: postUrl,
				data: formDataList,
				cache:false,
				processData: false,
			    contentType: false,
			    dataType: 'json',
		     	success: function(result){
		       			if(result.status==true){
									console.log(result);
		       				$('img#'+id+"_img").attr('src', URL_UPLOAD_IMAGES+'/'+result.name_xs);
		       				$('input#'+id+"_hide").attr('value', result.name);
		       				$('input#'+id+"_hide_xs").attr('value', result.name_xs);
		       				$('input#'+id+"_hide_md").attr('value', result.name_md);
		       				$('input#'+id+"_hide_lg").attr('value', result.name_lg);
		       				$('input#'+id+"_hide_json").attr('value', result);
		       				$('a[name='+id+"]").show(0);
		       			}else{
							console.log("hata var");
						}
		      }
			});
		}
	});
	//RESİM UPLOAD İŞLEMİ KODU SONU


	//RESİM KALDIRMA İŞLEMLERİ
	$('a.removeImageLink').on('mousedown', function(event){
		var id = $(this).attr('name');

		//**********************************************************************
		swal({
				title: "Resim Silinecek.",
				text: "Bu resmi silmek istediğinizden emin misiniz? Onay verdikten sonra işlem bir daha geri alınamaz.",
				icon: "warning",
				dangerMode: true,
				buttons: {
					cancel: "Vazgeç",
					delete: "Sil"
				},
			}).then((value) => {
					if(value=="delete"){
						var val_img = $('input#'+id+"_hide").attr('value');
						var val_xs = $('input#'+id+"_hide_xs").attr('value');
						var val_md = $('input#'+id+"_hide_md").attr('value');
						var val_lg = $('input#'+id+"_hide_lg").attr('value');
						var datas = {img:val_img, xs:val_xs, md:val_md, lg:val_lg };
						$.ajax({
							method: "POST",
							url: URL_SITE + "uploadfile/delete_ajax",
							data: datas,
							success: function( delete_return ){
								if(delete_return=="true"){

										$('img#'+id+"_img").attr('src', '');
					       				$('input#'+id+"_hide").attr('value', '');
					       				$('input#'+id+"_hide_xs").attr('value', '');
					       				$('input#'+id+"_hide_md").attr('value', '');
					       				$('input#'+id+"_hide_lg").attr('value', '');
					       				$('input#'+id+"_hide_json").attr('value', '');
					       				$('a[name='+id+"]").hide(0);
										$('div#'+id+'_div').attr('style', 'display:none;');
										swal("Görsel Silindi.", "Görsel başarılı bir şekilde silindi.", "success");

								}else{
									swal("Hata Oluştu.", "Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra yeniden dene.", "danger");
								}
							}
						});//$.ajax

					}//if(value=="delete")
			});//.then((value) =>
		//**********************************************************************

	});//$('a.removeImageLink').on('mousedown', function(event)






	/* #############################################################
		KATEGORİ SİLME İŞLEMLERİ SWEETALERT
		############################################################# */


/*
		var dz = $(".dropzone").dropzone()[0];
		dz.dropzone.on("success", function (file, response) {
		   if(response!="false"){
			   $('#galeri_resimleri').prepend('<img src="'+URL_UPLOADS+'/gallery-photos/'+response+'" class="img-response" />');
		   }
		});
*/
});



function delete_category(par_id, par_title=''){
	swal({
			title: "Kategori Silinecek.",
			text: "\""+par_title+"\" kategorisini silmek istediğinizden emin misiniz? Bu işlem sonrasında bu kategoriye ait içerikler artık görüntülenmeyebilirler.",
			icon: "warning",
			dangerMode: true,
			buttons: {
				cancel: "Vazgeç",
				delete: "Sil"
			},
		}).then((value) => {
				if(value=="delete"){
					$.ajax({
						method: "POST",
						url: URL_SITE + "category/delete",
						data:{id: par_id},
						success: function( delete_return ){
							if(delete_return=="true"){
								$("tr#category-"+par_id).remove();
								swal("Başarılı.", "Kategori silindi.", "success");
							}else{
								swal("Hata Oluştu.", "Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra yeniden dene.", "danger");
							}
						}
					});//$.ajax
				}//if(value=="delete")
		});//.then((value) =>

	}


//delwajax(2, 'tr#item-id', 'category/title', 'Kategori')
function delwajax(id, title='', url='', item=''){
	swal({
		title: title+' Silinecek ',
		text: 'Bu işlemi yapmak istediğinizden emin misiniz? Silme işlemi bir daha geri alınamaz',
		icon: 'warning',
		dangerMode: true,
		buttons: {
			cancel: "Vazgeç",
			delete: "Eminim Sil"
		},
	}).then((value) => {
			if(value=="delete"){
				$.ajax({
					method: "POST",
					url: url,
					data:{id: id},
					success: function( delete_return ){
						if(delete_return=="true"){
							$(item).remove();
							swal("Başarılı", 'İşleminiz başarılı bir şekilde gerçekleşti.', "success");
						}else{
							swal("Hata Oluştu.", "Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra yeniden dene.", "danger");
						}
					}
				});//$.ajax
			}//if(value=="delete")
	});//.then((value) =>

}
