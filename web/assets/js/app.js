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

                var select = "<div><label>Виберіть предмет</label><select name='subject' id='subject'>" + options +  "</select></div>";

                $('#subject').parent().remove();

                self.after(select);
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

                    var select = "<div><label>Виберіть групи</label><select name='groups[]' id='groups' multiple>" + options +  "</select></div>";

                } else {
                    var select = "<div><label>Виберіть групи</label><span id='groups'>В цьому курсі немає ні одної группи</span></div>";
                }

                $('#groups').parent().remove();
                self.after(select);
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

                    select = "<div><label>Виберіть аудиторію </label><select name='auditory' id='auditory'>" + options +  "</select></div>";

                } else {
                    select = "<div><label>Виберіть аудиторію </label><span id='auditory'>Цього типу немає ні однієї аудиторії</span></div>";
                }

                $('#auditory').parent().remove();
                self.after(select);
            }
        )
    });
});

function display_none(){
    $('#everyday, #everyweek, #everymonth, #exception').css({'display': 'none'});
}
