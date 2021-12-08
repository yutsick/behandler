function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}


//Textarea limit
function maxLength(el) {
    if (!('maxLength' in el)) {
        var max = el.attributes.maxLength.value;
        el.onkeypress = function () {
            if (this.value.length >= max) return false;
        };
    }
}

document.querySelectorAll('.text-limit').forEach(el => {
    maxLength(el);
});

//AJAX requests
jQuery(function ($) {
    $('[data-id = "add_certificate"]').click(function (event) {

        event.preventDefault();
        let rz_course_name = $('[name=rz_course-name]').val();
        let rz_course_year = $('[name=rz_course-year]').val();
        //alert('ffff' + rz_course_name + rz_course_year);
        $.ajax({
            //url: '/wp-admin/admin-ajax.php',
            url: '/form_wizard_step/',
            method: 'post',
            data: {
                //action: 'ajax_certificate',
                ajax_certificate: true,
                rz_course_name: rz_course_name,
                rz_course_year: rz_course_year

            },
            success: function (response) {
                console.log('fff' + response);
                //alert(response);
                $('#certificate-test').html(response);
            }
        });
    });
});

