$(document).ready(function() {
    $('.load-group-file').click(function() {
        var id = $(this).data('group');
        $('#loadFile input[name=group_id]').val(id);
    });

    if ($('#triggerform').length > 0)
        $('#triggerform').submit();

    $('#textfilter').keyup(function() {
        var t = $(this).val().toLowerCase();

        if (t == '') {
            $('.filteratable tbody tr').show();
        }
        else {
            $('.filteratable tbody tr').each(function() {
                var a = $(this).find('td').text().toLowerCase();
                if (a.indexOf(t) == -1)
                    $(this).hide();
                else
                    $(this).show();
            });
        }
    });

    $('#buttonfilter input[type=radio]').change(function() {
        if ($(this).prop('checked') == false)
            return;

        var t = $(this).val();
        var name = $('#buttonfilter').attr('data-filter-attribute');

        if (t == 'all') {
            $('.filteratable tbody tr').show();
        }
        else {
            $('.filteratable tbody tr[data-filter-' + name + '=' + t + ']').show();
            $('.filteratable tbody tr[data-filter-' + name + '!=' + t + ']').hide();
        }
    });

    var index = 0;
    var tot = $('.waiting-count').length;

    if($('.waiting-count').length != 0) {
        setInterval(function() {
            var row = $('.waiting-count').eq(index);
            var folder = row.attr('id');

            $.ajax('/admin/count/' + folder, {
                method: 'GET',
                dataType: 'HTML',
                success: function(c, status, request) {
                    var id = request.getResponseHeader('Folder-ID');
                    var target = $('.waiting-count[id=' + id + ']');
                    target.parent().append('<span>' + c + '</span>');
                    target.remove();
                }
            });

            index++;
            if (index >= tot)
                return false;

        }, 200);
    }
});
