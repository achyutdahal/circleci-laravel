$(document).ready(function () {

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#uploadedImage').attr('src', e.target.result).show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function () {
        readURL(this);
    });

    $('.product-create-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                message: 'The product name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The product name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 2,
                        max: 255,
                        message: 'The product name must be more than 2 and less than 255 characters long'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'The description is required and cannot be empty'
                    },
                    stringLength: {
                        min: 2,
                        max: 2000,
                        message: 'The description must be more than 2 and less than 2000 characters long'
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: 'Price is required'
                    },
                    numeric: {
                        message: 'Please enter a valid numeric value'
                    }
                }
            },
            image: {
                validators: {
                    notEmpty: {
                        message: 'Image is required'
                    },
                    file: {
                        extension: 'jpeg,png,jpg,gif',
                        type: 'image/jpeg,image/png,image/jpg,image/gif',
                        message: 'The selected file is not valid. JPEG, PNG, GIF and JPG are only accepted'
                    }
                }
            }
        }
    });

    $('.product-edit-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                message: 'The product name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The product name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 2,
                        max: 255,
                        message: 'The product name must be more than 2 and less than 255 characters long'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'The description is required and cannot be empty'
                    },
                    stringLength: {
                        min: 2,
                        max: 2000,
                        message: 'The description must be more than 2 and less than 2000 characters long'
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: 'Price is required'
                    },
                    numeric: {
                        message: 'Please enter a valid numeric value'
                    }
                }
            },
            image: {
                validators: {
                    file: {
                        extension: 'jpeg,png,jpg,gif',
                        type: 'image/jpeg,image/png,image/jpg,image/gif',
                        message: 'The selected file is not valid. JPEG, PNG, GIF and JPG are only accepted'
                    }
                }
            }
        }
    });

    $(".deleteProduct").click(function (e) {
        e.preventDefault();
        var productId = $(this).attr('data-id');
        bootbox.confirm({
            message: "Are you sure you want to delete the product?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    window.location.href = '/delete/' + productId;
                }
            }
        });
    })

    $("#sortOptions").change(function (e) {
        var currentUrl = window.location.href;
        var sortOption = $(this).val();
        if (currentUrl.indexOf('?') > -1) {
            window.location.href = currentUrl + '&sortby=' + sortOption;
        } else {
            window.location.href = currentUrl + '?sortby=' + sortOption;
        }
        
        
    });
    
    $("sortOptionsForm").submit(function (e) {
        e.preventDefault();
    });

});