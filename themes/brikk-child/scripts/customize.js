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
function cert_add(cert_action, n) {

    if (cert_action == 'edit') {
        $('[data-id = "add_certificate"]').off('click');
        $('[data-id = "add_certificate"]').on('click', function (event) {

            event.preventDefault();
            let rz_course_name = $('[name=rz_course-name]').val();
            let rz_course_year = $('[name=rz_course-year]').val();


            $.ajax({
                url: '/form_wizard_step/',
                method: 'post',
                data: {
                    ajax_edit_certificate: true,
                    rz_course_index: n,
                    rz_course_name: rz_course_name,
                    rz_course_year: rz_course_year,
                    cert_action: cert_action
                },
                success: function (response) {
                    $('[name = rz_course-name],[name=rz_course-year]').val('');
                    $('#certificate-test').html(response);

                },
                beforeSend: function () {
                    $('#certificate-test .rz-preloader').fadeTo('fast', 1.0);
                },
                complete: function () {
                    $('#certificate-test .rz-preloader').fadeTo('fast', 0.0);
                }
            });
        });

    } else {
        $('[data-id = "add_certificate"]').off('click');
        $('[data-id = "add_certificate"]').on('click', function (event) {

            event.preventDefault();
            let rz_course_name = $('[name=rz_course-name]').val();
            let rz_course_year = $('[name=rz_course-year]').val();

            $.ajax({
                url: '/form_wizard_step/',
                method: 'post',
                data: {
                    ajax_certificate: true,
                    rz_course_name: rz_course_name,
                    rz_course_year: rz_course_year,
                    cert_action: cert_action
                },
                success: function (response) {
                    $('[name = rz_course-name],[name=rz_course-year]').val('');
                    $('#certificate-test').html(response);

                },
                beforeSend: function () {
                    $('#certificate-test .rz-preloader').fadeTo('fast', 1.0);
                },
                complete: function () {
                    $('#certificate-test .rz-preloader').fadeTo('fast', 0.0);
                }
            });
        });
    }
}


jQuery(function cert_delete() {

    let certBlock = document.querySelector('#certificate-test');
    function del_cert() {
        let $certToDelete = $('[data-id=delete_certificate]');
        $($certToDelete).on('click', function () {
            let n = $certToDelete.index(this);

            $.ajax({
                url: '/form_wizard_step/',
                method: 'post',
                data: {
                    ajax_delete_certificate: true,
                    rz_course_index: n
                },
                success: function (response) {
                    $('#certificate-test').html(response);

                },
                beforeSend: function () {
                    $('#certificate-test .rz-preloader').fadeTo('fast', 1.0);
                },
                complete: function () {
                    $('#certificate-test .rz-preloader').fadeTo('fast', 0.0);
                }
            })
        });
    }

    let certToDel = new MutationObserver(function (mutations, observer) {
        // fired when a mutation occurs
        del_cert();
    });

    // define what element should be observed by the observer
    // and what types of mutations trigger the callback
    certToDel.observe(certBlock, {
        childList: true

    });
    del_cert();
});

jQuery(function edit_certificate() {

    let certBlock = document.querySelector('#certificate-test');
    function edit_cert() {

        let certToAdd = $("#add_certificate");
        $(certToAdd).on('click', function () {
            cert_add('add', null);
        });

        let $certToEdit = $('[data-id=edit_certificate]');
        $($certToEdit).on('click', function () {

            let n = $certToEdit.index(this);
            let $nameEditFull = $('#certificate-test .tab-content_style__presentation-input-name');
            let $yearEditFull = $('#certificate-test .tab-content_style__presentation-input-year');
            let $yearEdit = $yearEditFull.eq(n).text().slice(1, -1);
            let $nameEdit = $nameEditFull.eq(n).text();
            $('[name=rz_course-name]').val($nameEdit);
            $('[name=rz_course-name]').html($nameEdit);
            $('[name=rz_course-year]').val($yearEdit);
            $('[name=rz_course-year]').html($yearEdit);

            cert_add('edit', n);


        });
    };

    let certEdit = new MutationObserver(function (mutations, observer) {
        // fired when a mutation occurs
        edit_cert();
    });


    certEdit.observe(certBlock, {
        childList: true,
        characterData: true

    });
    edit_cert();

});

jQuery(function switch_certificate() {

    let $switch_cert = $('[data-id=switch_certificate]');

    $($switch_cert).on('click', function () {
        let n = $switch_cert.index(this);
        let $switch_cert_data = $switch_cert.eq(n).val();

        $.ajax({
            url: '/form_wizard_step/',
            method: 'post',
            data: {
                ajax_switch_certificate: true,
                switch_certificate: $switch_cert.eq(n).attr('name'),
                switch_user_certificate: $switch_cert.eq(n).attr('id'),
                switch_data: $switch_cert_data
            },
            beforeSend: function () {
                $('.switch-certificate .rz-preloader').fadeTo('fast', 1.0);
            },
            complete: function () {
                $('.switch-certificate .rz-preloader').fadeTo('fast', 0.0);
            }
        });
    });

});

jQuery(function receiveNotifications() {

    let $receive_notif = $('#receive_notif');
    $($receive_notif).on('click', function () {
        $.ajax({
            url: '/form_wizard_step/',
            method: 'post',
            data: {
                ajax_receive_notif: true,
                receive_data: $receive_notif.val()
            },
            beforeSend: function () {
                $('.receive_notif  .rz-preloader').fadeTo('fast', 1.0);
            },
            complete: function () {
                $('.receive_notif  .rz-preloader').fadeTo('fast', 0.0);
            },
        });
    });
});

