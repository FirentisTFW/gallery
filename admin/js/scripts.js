$(document).ready(function() {      // jQuery - to, co jest w nawiasach wykona się dopiero wtedy, gdy cały dokument się załaduje

    let userId;
    let imageSrc;
    let imageName;

    $(".modal_thumbnails").click(function() {       // przypisywanie funkcji do elementu z daną klasą (na kliknięcie)
        $("#set_user_image").prop('disabled', false);       // zmiana atrybutu 'disabled' na false w elemencie o id 'set_user_image'

        userId = $('#user-id').prop('value');

        imageSrc = $(this).prop("src");
        imageSrc = imageSrc.split("/");
        imageName = imageSrc[imageSrc.length-1];
    });

    $("#set_user_image").click(function() {

        $.ajax({
            url: "includes/ajax_code.php",
            data:{image_name: imageName, user_id: userId},
            type: "POST",
            success: function(data) {           // wykonuje się, jeśli wszystko się uda
                if(!data.error) {     // sprawdzamy, czy nie ma errorów
                    // location.reload(true);
                    // alert(data);
                }
            }
        });

    });

    tinymce.init({selector:'textarea'});
})
