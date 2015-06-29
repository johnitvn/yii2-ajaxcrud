/*!
 * Ajax Crud 
 * =================================
 * jQuery plugin for yii2-ajaxcrud extension
 */

(function( $ ) {

    $.fn.hasAttr = function(name) {  
        return this.attr(name) !== undefined;
    };


    $.fn.ajaxCrudDatatable = function(){

        var modalId = "#ajaxCrubModal";
        var createActionButtonCls = ".create-action-button";
        var deleteActionButtonCls='.delete-action-button';
        var updateActionButtonCls='.update-action-button';
        var viewActionButtonCls='.view-action-button';
        var bulkDeleteActionButtonCls ='.btn-bulk-delete';

        function closeModal(){
            $(modalId).modal('toggle');           
        }


        function openModal( options ) {  
            var settings = $.extend({  
                type: 'default', 
                title: '',
                closeButton:true,
                loading:true,
                url:"create",
                method:'GET',
                positiveButton:null,
                negativeButton:null,
                onPositiveClick:null,
                onNegativeClick:null,
            }, options );


            // set theme of
            $(modalId).find('.modal-dialog').addClass('modal-'+settings.type);


            if(settings.loading){
                $(modalId).find('.modal-header .modal-title').remove();
                $(modalId).find('.modal-header').append('<div class="modal-title"><h4 class="modal-title">Loading</h4></div>');
                $(modalId).find('.modal-body').html('<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>'); 
            }          


            if(!settings.closeButton){
                //disable close button
                $(modalId).find('.modal-title button.close').remove();
            }
          

            $(modalId).modal();    

            $.ajax({
                url:settings.url,
                method:settings.method,
                success:function(response){
                    $(modalId).find('.modal-header .modal-title').remove();
                    $(modalId).find('.modal-header').append('<div class="modal-title"><h4 class="modal-title">'+settings.title+'</h4></div>');
                    $(modalId).find('.modal-body').html(response.data); 


                      if(settings.positiveButton!=null||settings.negativeButton!=null){  
                        //add footer
                        modalFooter = document.createElement('div');
                        modalFooter.setAttribute('class', 'modal-footer');
                        $(modalId).find('.modal-content').append(modalFooter);  

                        if(settings.positiveButton!=null){
                            //add possitive button
                            positiveButtonElm = document.createElement('button');
                            positiveButtonElm.setAttribute('class', 'btn btn-primary');
                            positiveButtonElm.innerHTML = settings.positiveButton;
                            $(modalFooter).append(positiveButtonElm);

                            if(settings.onPositiveClick!=null){
                                $(positiveButtonElm).click(function(e){
                                    settings.onPositiveClick(e);
                                });
                            }
                        }   

                        if(settings.negativeButton!=null){
                            //add possitive button
                            negativeButtonElm = document.createElement('button');
                            negativeButtonElm.setAttribute('class', 'btn btn-default pull-left');
                            negativeButtonElm.innerHTML = settings.negativeButton;
                            $(modalFooter).append(negativeButtonElm);

                            $(negativeButtonElm).click(function(e){
                                closeModal();
                                if(settings.onNegativeClick!=null){
                                    settings.onNegativeClick(e);
                                }
                            });

                        }  
                    }

                    // prevent all submit form
                    $(this).find('form').submit(function(e){
                         e.preventDefault();
                    })
                }
            });
        };

        /**
        * reset modal data
        */
        function clearModalData(){
            $modalDialog = $(modalId).find('.modal-dialog');
            $modalDialog.attr('class','');            
            $modalDialog.addClass('modal-dialog');

            $(modalId).find('.modal-footer').remove();
            $(modalId).find('.modal-body').html('');
            $(modalId).find('.modal-title').html('');
        }

        function reloadGridView(){
            // reload gridview
            $.pjax.reload({container:"#crud-datatable-pjax"});
        }

        function onCreateAction(e){
            e.preventDefault();
            openModal({
                url: $(createActionButtonCls).attr("href"),
                title: $(createActionButtonCls).hasAttr("data-modal-title")?$(createActionButtonCls).attr("data-modal-title"):'Create new',
                positiveButton:$(createActionButtonCls).hasAttr("data-modal-positive")?$(createActionButtonCls).attr("data-modal-positive"):'Save',
                negativeButton:$(createActionButtonCls).hasAttr("data-modal-negative")?$(createActionButtonCls).attr("data-modal-negative"):'Cancel',
                onPositiveClick:onCreatePositiveClick,
            });
        }

        function onDeleteAction(e){
            e.preventDefault();
            if(confirm($(deleteActionButtonCls).attr("data-confirm-message"))){
                $(modalId).find('.modal-header .modal-title').remove();
                $(modalId).find('.modal-header').append('<div class="modal-title"><h4 class="modal-title">Loading</h4></div>');
                $(modalId).find('.modal-body').html('<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>');             
                $(modalId).modal();    

                $.ajax({
                    url: $(deleteActionButtonCls).attr("href"),
                    method:$(deleteActionButtonCls).attr("data-method"),
                    success:function(){
                        reloadGridView();
                        closeModal();
                    }
                });
            }
            return false;
        }

        function onViewAction(e){
            e.preventDefault();
            openModal({
                url: $(viewActionButtonCls).attr("href"),
                title: $(viewActionButtonCls).hasAttr("data-modal-title")?$(viewActionButtonCls).attr("data-modal-title"):'View',
                negativeButton:$(viewActionButtonCls).hasAttr("data-modal-negative")?$(viewActionButtonCls).attr("data-modal-negative"):'Close',
            });
        }

        function onUpdateAction(e){
            e.preventDefault();
            openModal({
                url: $(updateActionButtonCls).attr("href"),
                title: $(updateActionButtonCls).hasAttr("data-modal-title")?$(updateActionButtonCls).attr("data-modal-title"):'Update',
                positiveButton:$(updateActionButtonCls).hasAttr("data-modal-positive")?$(updateActionButtonCls).attr("data-modal-positive"):'Save',
                negativeButton:$(updateActionButtonCls).hasAttr("data-modal-negative")?$(updateActionButtonCls).attr("data-modal-negative"):'Cancel',
                onPositiveClick:onUpdatePositiveClick,
            });
        }

        function onBulkDeletAction(e){
            e.preventDefault();
            var selectedIds = [];
            $('input:checkbox[name="selection[]"]').each(function () {
                if(this.checked)
                    selectedIds.push($(this).val());
            });
            if(selectedIds.length==0){
                return false;
            }
            if(confirm($(bulkDeleteActionButtonCls).attr("data-confirm-message"))){    

                $(modalId).find('.modal-header .modal-title').remove();
                $(modalId).find('.modal-header').append('<div class="modal-title"><h4 class="modal-title">Loading</h4></div>');
                $(modalId).find('.modal-body').html('<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>');             
                $(modalId).modal();    

                $.ajax({
                    url: $(bulkDeleteActionButtonCls).attr("href"),
                    method:$(bulkDeleteActionButtonCls).attr("data-method"),
                    data:{pks:JSON.stringify(selectedIds)},
                    success:function(){
                        reloadGridView();
                        closeModal();
                    }
                });
            }
            return false;
        }
        

        function onUpdatePositiveClick(e){
            var form = $(modalId).find('form');
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response){
                        if(response.code==200){
                            reloadGridView();

                            // Show modal content for created messsage
                            $(modalId).find('.modal-dialog').addClass('modal-success');
                            $(modalId).find('.modal-body').html(response.message);
                            $successNegativeButton = $(updateActionButtonCls).hasAttr("data-modal-negative-success")?$(this).attr("data-modal-negative-success"):'Close'; 
                            $(modalId).find('.modal-footer .btn-default').html($successNegativeButton);
                            $(modalId).find('.modal-footer .btn-primary').remove();
                           
                          


                        }else if(response.code==400){
                            $(modalId).find('.modal-body').html(response.data); 
                        }else{

                        }                            
                    }
            }); 
        }
      

        function onCreatePositiveClick(e){
            var form = $(modalId).find('form');
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response){
                        if(response.code==200){
                            reloadGridView();

                            // Show modal content for created messsage
                            $(modalId).find('.modal-dialog').addClass('modal-success');
                            $(modalId).find('.modal-body').html(response.message);
                            $successNegativeButton = $(createActionButtonCls).hasAttr("data-modal-negative-success")?$(this).attr("data-modal-negative-success"):'Close'; 
                            $(modalId).find('.modal-footer .btn-default').html($successNegativeButton);
                            $successPositiveButton = $(createActionButtonCls).hasAttr("data-modal-positive-success")?$(this).attr("data-modal-positive-success"):'Create other'; 
                            $(modalId).find('.modal-footer .btn-primary').html($successPositiveButton);
                           
                            $(modalId).find('.modal-footer .btn-primary').click(function(e){
                                clearModalData();
                                onCreateAction(e);
                            });


                        }else if(response.code==400){
                            $(modalId).find('.modal-body').html(response.data); 
                        }else{

                        }                            
                    }
            }); 
        }

       
        // Listen create button click
        $(this).on("click",createActionButtonCls,onCreateAction);

        // Listen delete button click
        $(this).on("click",deleteActionButtonCls,onDeleteAction);

        // Listen view button click
        $(this).on("click",viewActionButtonCls,onViewAction);

        // Listen update button click
        $(this).on("click",updateActionButtonCls,onUpdateAction);

        // Listen bulk delete button click
        $(this).on("click",bulkDeleteActionButtonCls,onBulkDeletAction);

        // clear all data when close modal
        $(modalId).on('hidden.bs.modal',clearModalData);

    }


$('#ajaxCrudDatatable').ajaxCrudDatatable();
}( jQuery ));



