var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {

            Dropzone.options.myDropzone = {
                init: function() {
                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement('<button class="btn green" type="submit"><i class="fa fa-remove"></i> Remove File</button>');
                        var editbutton = Dropzone.createElement('<button class="btn green" type="submit"><i class="fa fa-edit"></i> Edit file</button>');

                         // var removeButton = myDropzone.createElement('<button class="btn green" onclick="delete_item_image('+gallery['id']+');" ><i class="fa fa-remove"></i> Remove File</button>');
                        // var editbutton = myDropzone.createElement('<button class="btn green" href="#configure-edit-div" data-toggle="modal"  id="popup_'+gallery['id']+'" onclick=choose_image('+gallery['id']+',"'+gallery['image_description']+'","'+gallery['id']+'");><i class="fa fa-edit"></i> Edit file</button>');


                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                        file.previewElement.appendChild(editbutton);
                    });
                }
            }
        }
    };
}();