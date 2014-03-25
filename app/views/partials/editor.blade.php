<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{ url('js/medium-editor.js') }}"></script>
<script src="{{ url('js/medium-editor-insert.js') }}"></script>
<script>
    var titleEditor = new MediumEditor('.title-editable', {
        buttonLabels: 'fontawesome'
    });
    var bodyEditor = new MediumEditor('.body-editable', {
        buttonLabels: 'fontawesome'
    });
    $(function () {
        $('.body-editable').mediumInsert({
            editor: bodyEditor,
            images: true,
            imagesUploadScript: "{{ URL::to('upload') }}"
        });
        if ($('#hideEditor').length) {
            $('.body-editable').mediumInsert('disable');
            bodyEditor.deactivate();
            titleEditor.deactivate();
        }
    });
    $('.error').hide().empty();
    $('.success').hide().empty();

    $('body').on('click', '#form-submit', function(e){
        e.preventDefault();
        var postTitle = titleEditor.serialize();
        var postContent = bodyEditor.serialize();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url : "{{ URL::action('PostsController@store') }}",
            data: { title: postTitle['post-title']['value'], body: postContent['post-body']['value'] },
            success: function(data) {
                if(data.success === false)
                {
                    $('.error').append(data.message);
                    $('.error').show();
                } else {
                    $('.success').append(data.message);
                    $('.success').show();
                    setTimeout(function() {
                        window.location.href = "{{ URL::action('PostsController@index') }}";
                    }, 2000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went wrong. Please Try again later...');
            }
        });
        return false;
    });

    $('body').on('click', '#form-update', function(e){
        e.preventDefault();
        var postTitle = titleEditor.serialize();
        var postContent = bodyEditor.serialize();

        $.ajax({
            type: 'PUT',
            dataType: 'json',
            url : "{{ URL::action('PostsController@update', array(Request::segment(2))) }}",
            data: { title: postTitle['post-title']['value'], body: postContent['post-body']['value'] },
            success: function(data) {
                if(data.success === false)
                {
                    $('.error').append(data.message);
                    $('.error').show();
                } else {
                    $('.success').append(data.message);
                    $('.success').show();
                    setTimeout(function() {
                        window.location.href = "{{ URL::action('PostsController@index') }}";
                    }, 2000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went wrong. Please Try again later...');
            }
        });
        return false;
    });
</script>