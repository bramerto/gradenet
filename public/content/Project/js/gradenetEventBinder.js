$(document).ready(function() {

    //function msieversion()  //checks if user has older version of IE
    //{
    //    var ua = window.navigator.userAgent;
    //    var msie = ua.indexOf ( "MSIE " );
    //
    //    if ( msie > 0 )      // If Internet Explorer, return version number
    //        return parseInt (ua.substring (msie+5, ua.indexOf (".", msie )));
    //    else                 // If another browser, return 0
    //        return 0
    //}

    //function isValidDate(dateString) {
    //    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    //    return dateString.match(regEx) != null;
    //}

    var _token = $('input[name="_token"]').val();

    function linkEvent(link, data, inbetween)    //links a page with a neccesary dataId link. Link should be a string like: '/test/hallo/'
    {
        var path = rootPath;
        var splitPath = link.split('/');
        var firstpart = '/' + splitPath[1] + '/' + splitPath[2] + '/';
        var secondpart = '/' + splitPath[3] + '/' + splitPath[4] + '/';

        if(inbetween == 1) {
            path += firstpart + data + '/' + splitPath[3];

        }
        else if(inbetween == 2) {

            path += firstpart + data[0] + secondpart + data[1];

        } else {
            path += link + data;
        }

        document.location = path;
    }

    $('.btn-score-project').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var dataId = $this.parent().parent().attr("data-id");

        var projectId = (dataId) ? dataId : $('#projectId').val();

        linkEvent('/teacher/project/score/', projectId, 1);
    });

    $('.btn-score-student').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var projectId = $('#projectId').val();
        var studentId = $this.parent().parent().attr("data-id");

        var data = [projectId ,studentId];

        linkEvent('/teacher/project/score/student/', data, 2);
    });

    $('.btn-see-project').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var dataId = $this.parent().parent().attr("data-id");

        linkEvent('/teacher/project/', dataId, false);
    });

    $('.btn-student-see-project').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var dataId = $this.parent().parent().attr("data-id");

        linkEvent('/student/project/', dataId, false);
    });

    $('.btn-see-project-teacher').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var dataId = $this.parent().parent().attr("data-id");

        linkEvent('/teacher/project/', dataId, false);

    });

    $('.btn-see-student').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var dataId = $this.parent().parent().attr("data-id");

        linkEvent('/teacher/student/', dataId, false);
    });

    $('.btn-set-grades').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var dataId = $this.parent().parent().attr("data-id");

        linkEvent('/teacher/student/', dataId, false);
    });


    $('.btn-delete-project').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);

        var dataId = $this.parent().parent().attr("data-id");

        swal({
            title: 'Are you sure you want to delete this project?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'

        }).then(function () {

            $.ajax({
                url: rootPath + '/teacher/project/delete/' + dataId,
                data: {
                    _token: _token
                },
                dataType:   'json',
                type:       'POST',
                async:      false,

                success: function(d) {
                    if (d == 'success') {

                        $this.closest('tr').find('td').fadeOut(1000, function() {

                                $(this).parents('tr:first').remove();
                            });

                        swal (
                            'Deleted!',
                            'This project has been deleted.',
                            'success'
                        )

                    } else {
                        swal (
                            'Something went wrong!',
                            'Project has not been deleted',
                            'error'
                        )
                    }
                }
            });
        })
    });

    $('.btn-delete-period').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);

        var dataId = $this.parent().parent().attr("data-id");

        swal({
            title: 'Are you sure you want to delete this period?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'

        }).then(function () {

            $.ajax({
                url: rootPath + '/teacher/block/delete/' + dataId,
                dataType:   'json',
                data: {
                    _token: _token
                },
                type:       'POST',
                async:      false,

                success: function(d) {
                    if (d == 'success') {

                        $this.closest('tr').find('td').fadeOut(1000, function() {

                            $(this).parents('tr:first').remove();
                        });

                        swal (
                            'Deleted!',
                            'This period has been deleted.',
                            'success'
                        )

                    } else {
                        swal (
                            'Something went wrong!',
                            'Period has not been deleted',
                            'error'
                        )
                    }
                }
            });
        })
    });

    $('.btn-modal-edit-period').on('click', function(e, data) {
        e.preventDefault();

        var $this        = $(this);
        var periodId     = typeof data !== 'undefined' ? data.id : $this.parent().parent().attr("data-id");
        var schoolyearId = $this.parent().parent().find('.schoolyearId').attr('data-id');
        var period       = $this.parent().parent().find('.blockNumber').text();
        var date_start   = $this.parent().parent().find('.date_start').text();
        var date_end     = $this.parent().parent().find('.date_end').text();

        $('#editPeriod').val(period);
        $('input[name="editDate_start"]').val(date_start);
        $('input[name="editDate_end"]').val(date_end);
        $('#editSchoolyear').val(schoolyearId).trigger('change');

        $('.datepickeredit').datepicker({
            dateFormat: "yy-mm-dd",
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 999999999999999);
                }, 0);
            }
        });

        $('#periodId').val(periodId);
    });

    $('#btn-new-modal').on('click', function(e) {
        e.preventDefault();

        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 999999999999999);
                }, 0);
            }
        });

        //TODO: set a date range for start and deadline
    });

    $('#addWorkProcess').on('click', function(e) {
        e.preventDefault();

        var projectId = $('#projectId').val();
        var selectedId = $('#select-workProcess').val();

        $.ajax({
            url: rootPath + '/teacher/project/' + projectId + '/addWorkProcess',
            data: {
                work_processId: selectedId,
                _token: _token
            },
            dataType:   'json',
            type:       'POST',

            success: function(data) {

                if (data == 'success') {
                    swal (
                        'Werk proces toegevoegd!',
                        'Werk proces is toegevoegd aan het project',
                        'success'

                    ).then(function() {
                        location.reload();
                    });
                }
            }
        })
    });

    $('#addUserToProject').on('click', function(e) {
        e.preventDefault();

        var projectId = $('#projectId').val();
        var selectedId = $('#select-project-student').val();
        var periodId = $('#select-project-student-period').val();

        $.ajax({
            url: rootPath + '/teacher/project/' + projectId + '/addStudentToProject',
            data: {
                studentId: selectedId,
                periodId: periodId,
                _token: _token
            },
            dataType:   'json',
            type:       'POST',

            success: function(data) {

                if (data == 'success') {
                    swal (
                        'Student toegevoegd!',
                        'Student is toegevoegd aan het project',
                        'success'

                    ).then(function() {
                        location.reload();
                    });
                }
            }
        });
    });

    //$('.btn-add-period').on('click', function() {  //Form validation for add_period - FRONT END SIDE - DO NOT DELETE
    //    var formIsValid  = true;
    //
    //    var period       = $('#period').val();
    //    var date_start   = $('#date_start').val();
    //    var date_end     = $('#date_end').val();
    //    var schoolyearId = $('#schoolyear').val();
    //
    //    var periodError       = $('#periodError');
    //    var date_startError   = $('#date_startError');
    //    var date_endError     = $('#date_endError');
    //    var schoolyearIdError = $('#schoolyearError');
    //
    //    switch (period) {
    //        case null :
    //            formIsValid = false;
    //            periodError.html('Dit veld moet ingevuld zijn');
    //            break;
    //
    //        case period < 1 :
    //            formIsValid = false;
    //            periodError.html('Nummer moet boven de 1 zijn');
    //            break;
    //
    //        case !$.isNumeric(period) :
    //            formIsValid = false;
    //            periodError.html('Moet numeriek zijn');
    //            break;
    //    }
    //
    //    switch (schoolyearId) {
    //        case null :
    //            formIsValid = false;
    //            periodError.html('Dit veld moet ingevuld zijn');
    //            break;
    //
    //        case schoolyearId < 1 :
    //            formIsValid = false;
    //            periodError.html('Nummer moet boven de 1 zijn');
    //            break;
    //
    //        case !$.isNumeric(schoolyearId) :
    //            formIsValid = false;
    //            periodError.html('Moet numeriek zijn');
    //            break;
    //    }
    //
    //    if (!date_start) {
    //        formIsValid = false;
    //        date_startError.html('Moet ingevuld zijn');
    //    }
    //    if (!isValidDate(date_start)) {
    //        formIsValid = false;
    //        date_startError.html('Moet correcte datum format zijn');
    //    }
    //
    //    if (!date_end) {
    //        formIsValid = false;
    //        date_endError.html('Moet ingevuld zijn');
    //    }
    //    if (!isValidDate(date_end)) {
    //        formIsValid = false;
    //        date_endError.html('Moet correcte datum format zijn');
    //    }
    //
    //    //if(formIsValid) {
    //    //    $('#add-period').submit();
    //    //}
    //});
});