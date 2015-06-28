function reloadDatatable(){
	$.get($('#dataTableWrapper').attr('data-url'),function(data){
		$('#dataTableWrapper').html(data);
		var bulkButtons = '<div class="btn-bulk">';
		bulkButtons += '<button id="deleteAll" class="btn btn-sm btn-danger">';
		bulkButtons += '<span class="glyphicon glyphicon-trash"></span>';
		bulkButtons += '&nbsp;&nbsp;&nbsp;Delete all selected</button>';
		bulkButtons += '</div>';
		$("#dataTableWrapper .grid-view").append(bulkButtons);
	});
}

function openAjaxModal(event){	
	
	var url = $(this).attr("data-url");
	var title = $(this).attr("data-title");

	$("#viewModal").find(".modal-title").html(title);
	$("#viewModal").modal();

	html =  '<p>Loading data</p>';
    html += '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';   
	$("#viewModal").find(".modal-body").html(html);	
	
	$.ajax({		
		url:url,
		method:'GET',
		dataType:'json',
		error:function(jqXHR,textStatus,errorThrown){
			console.log(jqXHR.responseText);
       		console.log(textStatus);
       		console.log(errorThrown);
			$("#viewModal").modal('toggle');
		},	
		success:function(data){
			$("#viewModal").find(".modal-body").html(data);				
		}
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

	$("#viewModal").find(".modal-title").html(title);
	$("#viewModal").modal();

	html =  '<p>Đang tải dữ liệu</p>';
    html += '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';   
	$("#viewModal").find(".modal-body").html(html);	
	$.ajax({
		url:url,
		method:'GET',
		dataType:'json',
		error:function(){

		},
		success:function(data){
			$("#viewModal").find(".modal-body").html(data);	
		}
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
			if(data.code==100){
				reloadDatatable();
				$('#viewModal').modal('toggle');
			}else if(data.code==200){
				$("#viewModal").find(".modal-title").html("An error occurred");
				$("#viewModal").find(".modal-body").html('<span class="text-danger">'+data.message+'</span>');	
					}else if(data.code==300){
				$("#viewModal").find(".modal-title").html("An error occurred");
				var html = '<span class="text-danger">'+data.message+'</span>';
				for(var i=0;i<data.errors.length;i++){
					html += '<span class="text-danger">'+data.errors[i]+'</span>';
				}
				$("#viewModal").find(".modal-body").html('<span class"text-danger">'+data.message+'</span>');	
				$("#viewModal").find(".modal-body").html();	
			} else {
				$("#viewModal").find(".modal-title").html("An error occurred");
				$("#viewModal").find(".modal-body").html('<span class="text-danger">Unknow error</span>');	
			}

        	
        	
        }
    });
});




$("#dataTableWrapper").on("click",'#select-all',function(){
	if( $(this).is(':checked') ){
		$(".bulk-selectable").prop('checked', true);
		$(".btn-bulk").click(function(){
			var map = [];
			$(".bulk-selectable").each(function() {
			    map.push($(this).attr("value"));
			});
			console.log(map.join(","));
		});
	}else{
		$(".bulk-selectable").prop('checked', false);
	} 	
});


reloadDatatable();