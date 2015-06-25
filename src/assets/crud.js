var ajaxModal = $("#viewModal");


function reloadDatatable(){
	$.get($('#dataTableWrapper').attr('data-url'),function(data){
		$('#dataTableWrapper').html(data);
	});
}

function openAjaxModal(event){	
	
	var url = $(this).attr("data-url");
	var title = $(this).attr("data-title");

	ajaxModal.find(".modal-title").html(title);
	ajaxModal.modal();

	html =  '<p>Đang tải dữ liệu</p>';
    html += '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';   
	ajaxModal.find(".modal-body").html(html);	
	
	$.get(url,function(data){
		ajaxModal.find(".modal-body").html(data);	
	});

}

function getParameterByName(url,name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(url);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function openAjaxDeleteModal(event){	
	var ajaxDeleteModal = $('#deleteModal');

	var url = $(this).attr("data-url");
	var title = $(this).attr("data-title");

	ajaxDeleteModal.find(".modal-title").html(title);
	ajaxDeleteModal.modal();	
	
	$('#comfirm-delete').click(function(){
		$.post(url,function(data){
			reloadDatatable();
		});
	});
}


$("#dataTableWrapper").on("click",'[data-toogle="view-model"]',openAjaxModal);
$("#dataTableWrapper").on("click",'[data-toogle="update-model"]',openAjaxModal);
$("#dataTableWrapper").on("click",'[data-toogle="delete-model"]',openAjaxDeleteModal);
$("#createNewModel").click(function(){
	var url = $(this).attr("data-url");
	var title = $(this).html();
	console.log(url);

	ajaxModal.find(".modal-title").html(title);
	ajaxModal.modal();

	html =  '<p>Đang tải dữ liệu</p>';
    html += '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';   
	ajaxModal.find(".modal-body").html(html);	
	
	$.get(url,function(data){
		ajaxModal.find(".modal-body").html(data);	
	});
});

$("#viewModal").on("submit","form",function(e){
	e.preventDefault();
	var url = $(this).attr("action");
	var modelId = getParameterByName(url,'id')
	jQuery.ajax({
        type:$(this).attr("method"),
        url: url, // URL to admin-ajax.php
        data: $(this).serialize(),
        success:function(data){
        	reloadDatatable();
        	$('#viewModal').modal('toggle');
        }
    });
});

reloadDatatable();