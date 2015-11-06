/*!
 * Ajax Crud 
 * =================================
 * Use for johnitvn/yii2-ajaxcrud extension
 * @author John Martin john.itvn@gmail.com
 */
$(document).ready(function(){

	// Create instance of Modal Remote
	// This instance will be controller all business logic of modal
	// Backwards compatible lookup of ajaxCrubModal
	if ($('#ajaxCrubModal').length>0 && $('#ajaxCrudModal').length == 0) {
		modal = new ModalRemote('#ajaxCrubModal');
	} else {
		modal = new ModalRemote('#ajaxCrudModal');
	}

	// Catch click event of all button want to open modal
	$(document).on('click','[role="modal-remote"]',function(event){
	    event.preventDefault(); 
		modal.remote(this,null);
	});

	// Catch click event of all button want to open modal
	// with bulk action
	$(document).on('click','[role="modal-remote-bulk"]',function(event){
	    event.preventDefault(); 
	    
	    var selectedIds = [];
        $('input:checkbox[name="selection[]"]').each(function () {
            if(this.checked)
                selectedIds.push($(this).val());
        });

        if(selectedIds.length==0){
	        modal.show();
            modal.setTitle('No selection');
            modal.setContent('You must select item(s) to use this action');
            modal.addButton("Close",'btn btn-default',function(button,event){
            	this.hide();
            });            
        }else{
        	modal.remote(this,{pks:JSON.stringify(selectedIds)});
        }
	});

});