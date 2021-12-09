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

        $.ajax({
            url: '/form_wizard_step/',
            method: 'post',
            data: {
                ajax_certificate: true,
                rz_course_name: rz_course_name,
                rz_course_year: rz_course_year
            },
            success: function (response) {

                $('[name = rz_course-name],[name=rz_course-year]').val('');
                $('#certificate-test').html(response);
            }
        });
    });
});





jQuery(function cert_delete() {

    let set = document.querySelector('#certificate-test');


    let certToDel = new MutationObserver(function (mutations, observer) {
        // fired when a mutation occurs
        let $set = $('[data-id=delete_certificate]');
        $($set).on('click', function () {
            let n = $set.index(this);

            $.ajax({
                url: '/form_wizard_step/',
                method: 'post',
                data: {
                    ajax_delete_certificate: true,
                    rz_course_index: n
                },//
                success: function (response) {
                    $('#certificate-test').html(response);

                }
            })
        });
        //console.log(mutations, observer);
        // ...
    });

    // define what element should be observed by the observer
    // and what types of mutations trigger the callback
    certToDel.observe(set, {
        //subtree: true,
        //attributes: true,
        childList: true
        //...
    });

    let $set = $('[data-id=delete_certificate]');
    $($set).on('click', function () {
        let n = $set.index(this);
        console.log(n);
        $.ajax({
            url: '/form_wizard_step/',
            method: 'post',
            data: {
                ajax_delete_certificate: true,
                rz_course_index: n
            },//
            success: function (response) {
                $('#certificate-test').html(response);

            }
        })
    });



});

