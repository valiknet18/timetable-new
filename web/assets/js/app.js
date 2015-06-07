$(function(){
    $(document).on('change', '#repeat_type', function() {
        var option = $(this).val() * 1;


        switch (option) {
            case 0:
                display_none();
                break;

            case 1:
                display_none();

                $('#everyday').css({'display' : 'block'});
                break;

            case 2:
                display_none();

                $('#everyweek').css({'display' : 'block'});
                break;

            case 3:
                display_none();

                $('#everymonth').css({'display' : 'block'});

                break;

            case 4:
                display_none();

                $('#exception').css({'display' : 'block'});
                break;

            default:
                display_none();
        }
    });

    $(document).on('change', '#event_date_start', function() {
        $('#event_date_end').attr('min', $(this).val());
    });

    $(document).on('change', '#event_time_start', function () {
        $('#event_time_end').attr('min', $(this).val());
    });

    $(document).on('change', '#teacher', function () {
        var value = $(this).val();
        var self = $(this);

        $.get(
            '/admin/teachers/get',
            {'teacher_code' : value},
            function (data) {
                console.log(data.subjects);

                var options = "";

                for (key in data.subjects) {
                    subject = data.subjects[key];

                    options += "<option value='" + subject.subject_code + "'>" + subject.subject_name + "</option>";
                }

                var select = "<div class='form-group'>" +
                                "<label for='subject' class='control-label col-sm-2'>Виберіть предмет</label>" +
                                "<div class='col-sm-9'>" +
                                    "<select name='subject' id='subject' class='form-control'>" + options +  "</select>" +
                                "</div>" +
                             "</div>";

                $('#subject').parent().parent().remove();

                self.parent().parent().after(select);
            }
        )
    });

    $(document).on('change', '#group_course', function () {
        var value = $(this).val();
        var self = $(this);

        $.get(
            '/admin/groups/get',
            {'group_course' : value},
            function (data) {

                var options = "";

                if (data.length > 0) {
                    for (key in data) {
                        group = data[key];

                        options += "<option value='" + group.group_code + "'>" + group.group_name + "</option>";
                    }

                    var select = "<div class='form-group'>" +
                                    "<label for='groups' class='control-label col-sm-2'>Виберіть групу</label>" +
                                    "<div class='col-sm-9'>" +
                                        "<select name='groups[]' class='form-control' id='groups' multiple>" + options +  "</select>" +
                                    "</div>" +
                                 "</div>";

                } else {
                    var select = "<div class='form-group'>" +
                                    "<label for='groups' class='control-label col-sm-2'>Виберіть групи</label>" +
                                    "<div class='col-sm-9'>" +
                                        "<span id='groups'>До цього року не прив’язана ні одна група</span>" +
                                    "</div>" +
                                "</div>";
                }

                $('#groups').parent().parent().remove();
                self.parent().parent().after(select);
            }
        )
    });

    $(document).on('change', '#event_type', function(){
        var value = $(this).val();
        var self = $(this);

        $.get(
            '/admin/auditories/get',
            {'auditory_type' : value},
            function (data) {

                var options = "";
                var select = "";

                if (data.length > 0) {
                    for (key in data) {
                        auditory = data[key];

                        options += "<option value='" + auditory.auditory_number + "'>" + auditory.auditory_number + "</option>";
                    }

                    select = "<div class='form-group'>" +
                                "<label for='auditory' class='control-label col-sm-2'>Виберіть аудиторію </label>" +
                                "<div class='col-sm-9'>" +
                                    "<select name='auditory' id='auditory' class='form-control'>" + options +  "</select>" +
                                "</div>" +
                             "</div>";

                } else {
                    select = "<div class='form-group'>" +
                                "<label class='control-label col-sm-2'>Виберіть аудиторію </label>" +
                                "<div class='col-sm-9'>" +
                                    "<span id='auditory'>Цього типу немає ні однієї аудиторії</span>" +
                                "</div>" +
                            "</div>";
                }

                $('#auditory').parent().parent().remove();
                self.parent().parent().after(select);
            }
        )
    });

    $(document).on('change', '#repeat_type', function () {
        var value = $(this).val();

        self = $(this);


        $('#repeat_event_block').remove();

        console.log(value);

        switch (value) {
            case "1":
                data = everyday();
                break;

            case "2":
                data = everyweek();
                break;

            case "3":
                data = everymonth();
                break;

            case "4":
                data = exception();
                break;
        }

        self.parent().parent().after(data);
    });
});

function display_none () {
    $('#everyday, #everyweek, #everymonth, #exception').css({'display': 'none'});
}

function everyday () {
    var result  = "<div class='form-group' id='repeat_event_block'>" +
                        "<label for='everyday' class='control-label col-sm-2'>" +
                            "Частота повторення в днях" +
                        "</label>" +

                        "<div class='col-sm-9'>" +
                            "<span>Кожен <input type='number' min='1' max='6' name='everyday' id='everyday' class='form-control' /> день</span>" +
                        "</div>" +
                 "</div>";

    return result;
}

function everyweek () {
    var result = "<div id='repeat_event_block'>" +
                    "<div class='form-group'>" +
                        "<label for='everyday' class='control-label col-sm-2'>" +
                            "В які дні повторювати" +
                        "</label>" +

                        "<div class='col-sm-9'>" +
                            "<select name='everyday[]' class='form-control' id='everyday' multiple>" +
                                "<option value='0'>Понеділок</option>" +
                                "<option value='1'>Вівторок</option>" +
                                "<option value='2'>Середа</option>" +
                                "<option value='3'>Четвер</option>" +
                                "<option value='4'>Пятниця</option>" +
                                "<option value='5'>Субота</option>" +
                                "<option value='6'>Неділя</option>" +
                            "</select>" +
                        "</div>" +
                    "</div>" +

                    "<div class='fo" +
        "rm-group'>" +
                        "<label for='everyweek' class='control-label col-sm-2'>Частота повторення в тижнях:</label>" +
                        "<div class='col-sm-9'>" +
                            "<span>Кожен <input type='number' min='1' max='4' class='form-control' id='everyweek' name='everyweek' /> тиждень</span>" +
                        "</div>" +
                    "</div>" +
                "</div>";

    return result;
}

function everymonth () {
    var result = "<div id='repeat_event_block'>" +
                    "<div class='form-group'>" +
                        "<label class='control-label col-sm-2'>" +
                            "В який день повторювати"+
                        "</label>"+

                        "<div class='col-sm-9'>" +
                            "<input type='number' min='1' max='12' name='repeated_at' class='form-control' />"+
                        "</div>" +
                    "</div>" +

                    "<div class='form-group'>" +
                        "<label class='control-label col-sm-2'>" +
                            "Частота повторення в місяцях:" +
                        "</label>" +

                        "<div class='col-sm-9'>" +
                            "<span>Кожен <input type='number' min='1' max='12' name='everymonth' class='form-control' /> місяць</span>" +
                        "</div>" +
                    "</div>" +
                "</div>";

    return result;
}

function exception () {

    var options = "";

    $.get(
        '/admin/events/get',
        function (data) {
            if (data.length > 0) {
                for (key in data) {
                    event = data[key];


                    options += "<option value='" + event.event_code + "'>" + event.event_code + "</option>";
                }

                result = "<div id='repeat_event_block'>" +
                    "<div class='form-group'>" +
                    "<label class='col-sm-2 control-label'>" +
                    "Початкова дата події яку треба замінити" +
                    "</label>" +

                    "<div class='col-sm-9'>" +
                    "<input type='date' name='event_replace_date_start' class='form-control'/>" +
                    "</div>" +
                    "</div>" +

                    "<div class='form-group'>" +
                    "<label class='col-sm-2 control-label'>" +
                    "Кінцева дата події яку треба замінити" +
                    "</label>" +

                    "<div class='col-sm-9'>" +
                    "<input type='date' name='event_replace_date_end' class='form-control' />" +
                    "</div>" +
                    "</div>" +


                    "<div class='form-group'>" +
                    "<label class='col-sm-2 control-label'>" +
                    "Початковий час який треба замінити" +
                    "</label>" +

                    "<div class='col-sm-9'>" +
                    "<input type='time' name='event_replace_time_start' class='form-control' />" +
                    "</div>" +
                    "</div>" +

                    "<div class='form-group'>" +
                    "<label class='col-sm-2 control-label'>" +
                    "Кінцевий час який треба замінити" +
                    "</label>" +

                    "<div class='col-sm-9'>" +
                    "<input type='time' name='event_replace_time_end' class='form-control' />" +
                    "</div>" +
                    "</div>" +

                    "<div class='form-group'>" +
                    "<label class='col-sm-2 control-label'>Яку подію треба замінити</label>" +

                    "<div class='col-sm-9'>" +
                    "<select id='parent_event' name='parent_event' class='form-control'>" +
                    options +
                    "</select>" +
                    "</div>" +
                    "</div>" +
                    "</div>";


                self.parent().parent().after(result);
            }
        }
    );

    return "";
}