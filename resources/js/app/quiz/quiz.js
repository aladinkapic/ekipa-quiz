$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let letters = ['A', 'B', 'C', 'D'];
    let questionData = '', answerObject = '', disabled = false, joker = false, left = 0, end = false;

    $(".start-quiz").click(function () {
        $(".logo").fadeOut(0);
        $(".start-quiz").parent().fadeOut(0);

        $(".all-questions").fadeIn();
        $(".controls").fadeIn();
    });

    /*
     *  Start over - reload page
     */
    $(".start-over").click(function () {
        location.reload();
    });

    /*
     *  Pick an answer from user input
     */

    let finnishQuiz = function(finished = false){
        $(".letter-commands").fadeOut(0);
        $(".joker-next").fadeOut(0);

        if(finished === false) $(".go-home-w").fadeIn();
        else $(".well-done-w").fadeIn();

        $(".start-counting-w").fadeOut(0);
    };

    let changeQuestion = function(data){
        $(".question").attr('attr-id', data['question']['id']).find("p").text(data['question']['question']);
        $(".odgovori").empty();

        for(let i=0; i<data['answers'].length; i++){
            $(".odgovori").append(function () {
                return $("<li>").append(function () {
                    return $("<div>").attr('class', 'slovo')
                        .text(letters[i]);
                }).append(function () {
                    return $("<div>").attr('class', 'odgovor answer-' + letters[i])
                        .attr('attr-id', data['answers'][i]['id'])
                        .text(data['answers'][i]['answer']);
                });
            });
        }
    };

    let createRequest = function(answer, question, set){
        $.ajax({
            url: '/answer-question',
            method: 'POST',
            dataType: "json",
            data: {
                answer : answer,
                question : question,
                set : set
            },
            success: function success(response) {
                let code = response['code'];

                if(code === '0000'){
                    left = parseInt(response['left']);
                    if(end === true){
                        finnishQuiz(true);
                        return;
                    }

                    $(".logo").fadeOut(0);
                    $(".all-questions").fadeIn();

                    $(".total-points").text(response['points']);

                    if(response['joker'] === true){
                        changeQuestion(response['data']);
                        disabled = false;
                        return;
                    }else{
                        questionData = response['data'];

                        if(response['correct'] === 0){
                            $(answerObject).parent().addClass('netacan');
                            finnishQuiz();
                            return;
                        }else{
                            $(answerObject).parent().addClass('tacan');
                        }

                        if(response['data']['done'] === true) finnishQuiz(true);
                        disabled = true;
                    }

                    /* if(typeof response['message'] !== 'undefined') notify.Me([response['message'], "success"]);

                    setTimeout(function (){
                        if(typeof response['url'] !== 'undefined') window.location = response['url'];
                    }, 2000); */
                }else{
                    notify.Me([response['message'], "warn"]);
                }
                console.log('Ajax: ', response);
            }
        });
    };
    let pickAnswer = function (letter) {
        answerObject = '.answer-' + letter;

        let answer   = $('.answer-' + letter).attr('attr-id');
        let question = $(".question").attr('attr-id');
        let set      = $("#set_id").val();

        if(disabled === true) return;
        createRequest(answer, question, set);
    };

    $(".pick-value").click(function () { pickAnswer($(this).attr('val-attr')); });
    $(".use-joker").click(function () {
        joker = true;
        $(".all-questions").fadeOut(0);
        $(".logo").fadeIn().attr('src','/images/joker.png');

        $(this).fadeOut(0);
        $(".next-question").css('width', '100%');
        $(".pulse").fadeIn();

        if(left === 1){
            createRequest(0, $(".question").attr('attr-id'), $("#set_id").val());
            end = true;
        }
    });

    /*
     *  Next question -- can use joker before that
     */
    $(".next-question").click(function () {
        if(joker === true){
            createRequest(0, $(".question").attr('attr-id'), $("#set_id").val());
            joker = false;
        }else{
            disabled = false;
            changeQuestion(questionData);
        }
    });

    /*
     *  Custom messages
     */
    $(".well-done").click(function () {
        $(".all-questions").fadeOut(0);
        $(".logo").fadeIn().attr('src','/images/brao-brao.svg');
    });
    $(".go-home").click(function () {
        $(".all-questions").fadeOut(0);
        $(".logo").fadeIn().attr('src','/images/dobio-si-po-usima.svg');
    });
});
