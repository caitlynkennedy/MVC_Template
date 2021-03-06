$(document).ready(function(){
    // code goes here


    $(".project-post").on('click', '.comment-btn', function(){
        var comment_loop = $(this).closest('.project-post').find('.comment-loop');

        comment_loop.slideToggle();
    });

    $(" .project-post").on('click', '.delete-comment', function(){
        $deleteComment = $(this);
        $userComment = $deleteComment.closest('.user-comment');
        var $commentCount = $deleteComment.closest('.project-post').find('.comment-count');
        var comment_id = $deleteComment.attr('data-id');
        var formData = {"id":comment_id};


        console.log(formData);
        $.post('/comments/delete.php', formData, function(data){
            console.log('data from delete.php: ',data);
            $userComment.remove();

            $commentCount.text(parseInt($commentCount.text())-1);


        });
    });

    /*
    * LOVE BUTTON
    */

    $(" .project-post").on('click', '.love-btn', function(){

        // store the components in variables
        var love_btn = $(this);
        var love_icon = love_btn.find('.love-icon');
        var love_count = love_btn.find('.love-count');

        // values
        var project_id = love_btn.data('project');

        $.post(
            '/loves/add.php',
            {
                'project_id': project_id
            },
            function(love_results){
                love_results = JSON.parse(love_results);
                console.log(love_results);
                if(love_results.error == false){ // love worked
                    if(love_results.loved == 'loved') {
                        love_icon.removeClass('far').addClass('fas');
                        love_count.html(love_results.love_count);
                    } 
                    else if( love_results.loved == 'unloved') {
                        love_icon.removeClass('fas').addClass('far');
                        love_count.html(love_results.love_count);
                    }

                }

            }
        );
    });


    /*
    * SUBMIT COMMENT
    */
    $(".project-post").on('submit', '.comment-form', function(e) {
        e.preventDefault();

        // store comment components
        var comment_form = $(this);
        var comment_box = comment_form.find('.comment-box');
        var comment_count = comment_form.closest('.project-post').find('.comment-count');
        var comment_loop = comment_form.closest('.project-post').find('.comment-loop');

        // store values 
        var project_id = comment_form.data('project');
        var comment_text = comment_box.val();

        console.log(project_id, comment_text);

        if($.trim( comment_text ).length > 0 ) { //if you typed something

            $.post(
                '/comments/add.php', // url
                {
                    project_id: project_id,
                    comment: comment_text
                }, // data
                function(comment_data) { // complete function
                    // do stuff here...
                    comment_data = JSON.parse(comment_data);
                    console.log(comment_data);

                    if(comment_data.error == false){
                        comment_count.html(comment_data.comment_count);
                        var comment_html = '';

                        $.each(comment_data.comments, function(index, comment){
                            comment_html += "<div class='user-comment ";
                            comment_html += (comment.user_owns == 'true') ? 'my_comment' : '';
                            comment_html += "'><p>";
                            comment_html += "<span class='font-weight-bold comment-username'>" +
                                        comment.username +
                                        ":</span> " + "<a data-id='"+ comment.id +"' class='delete-comment'><i class='fas fa-trash-alt float-right text-dark'></i></a>";
                            comment_html += comment.comment;
                            comment_html += "</p></div>";
                        }); 

                        comment_loop.html(comment_html);
                        comment_loop.slideDown();
                        comment_box.val('');
                    }

                }
            );

        }
    });





    /*
    * FILE UPLOADING
    */

    $("#file-with-preview").on("change", function(){
        previewFile();
    })

    function previewFile(){
        // Select our preview <img>
        // Get the file contents from upload field
        // Set the src of our image to the uploaded file location

        var preview = $("#img-preview");
        var file = $("#file-with-preview")[0].files[0];
        console.log(file);

        var reader = new FileReader;

        // Run when file finishes reading
        reader.onloadend = function() {
            preview.attr('src', reader.result);
        }

        if(file){
            reader.readAsDataURL(file);
        } else {
            preview.attr('src', '');
        }

    }

  
    /*
    *
    * SEARCH
    *
    */
   $("#search_form").on('submit', function(e){
        //e.preventDefault();
   });

   $("input#search").on('keyup', function(e){
        var user_search = $(this).val();
        if(user_search.length > 2){

            $.ajax({
                method: 'get',
                url: '/search_results.php',
                data: {
                    search: user_search
                },
                success: function(search_results){
                    search_results = JSON.parse(search_results);

                    var output = "<div class='list-group'>";
                    $.each(search_results, function(i, search_result){
                        output += "<a class='list-group-item' href='/projects?id="+search_result.id+"'>"+ search_result.title +"</a>"
                    });
                    output += "</div>";
                    $("#search_results").html(output);
                    console.log(search_results);
                }
            });
        } else {
            $("#search_results").html('');
        }
   });


}); 