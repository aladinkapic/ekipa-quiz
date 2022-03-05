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
        $(".reset-counter-w").fadeOut(0);
    };

    let changeQuestion = function(data){
        $(".question").attr('attr-id', data['question']['id']).find("p").text(data['qNumber'] + '. ' + data['question']['question']);
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
        $('.radio').prop('checked', false);
    });

    /*
     *  Custom messages
     */
    $(".well-done").click(function () {
        $(".all-questions").fadeOut(0);
        $(".logo").fadeIn().attr('src','/images/brao-brao.svg');

        const audio = new Audio("/sounds/brao.mp3");
        audio.play();
    });
    $(".go-home").click(function () {
        $(".all-questions").fadeOut(0);
        $(".logo").fadeIn().attr('src','/images/dobio-si-po-usima.svg');

        const audio = new Audio("/sounds/ofiras.mp3");
        audio.play();
    });

    /**
     *  High score
     */

    let highScore = 0;

    $(".high-score").click(function () {
        if(highScore === 0){
            highScore ++;
            $.ajax({
                url: '/high-score',
                method: 'POST',
                dataType: "json",
                data: {
                    id : $("#quiz_id").val()
                },
                success: function success(response) {
                    let code = response['code'];
                    if(code === '0000'){
                        $(".high-score-avatars").empty();

                        for(let i=0; i<response['data'].length; i++){
                            $(".high-score-avatars").append(function(){
                                return $("<li>").append(function(){
                                    return $("<div>").attr('class', 'rank')
                                        .text( i + 1)
                                }).append(function () {
                                    return $("<img>").attr('class', 'badge')
                                        .attr('src', '/images/avatari/' + response['data'][i]['avatar'])
                                }).append(function () {
                                    return $("<div>").attr('class', 'ime')
                                        .text(response['data'][i]['name']);
                                }).append(function () {
                                    return $("<div>").attr('class', 'bodovi')
                                        .text(response['data'][i]['points']);
                                });
                            });
                            console.log(response['data'][i]);
                        }
                    }else{
                        notify.Me([response['message'], "warn"]);
                    }

                    $(".haj-skor").css('height', window.innerHeight).fadeIn();
                }
            });
        }else{
            highScore = 0;
            $(".haj-skor").fadeOut();
        }
    });

    /**
     *  Time intervals for counting seconds
     */
    let started = 0;
    $(".start-counting").click(function () {
        if(!started) started++;
        else started = 0;
    });

    let counter = 1;

    let intervalId = window.setInterval(function(){
        if(started){
            if(counter === 6){
                $.ajax({
                    url: '/finish-quiz',
                    method: 'POST',
                    dataType: "json",
                    data: {
                        id : $("#set_id").val()
                    },
                    success: function success(response) {
                        finnishQuiz();
                    }
                });
                finnishQuiz();
                return;
            }

            $('.radio').prop('checked', false);
            $(".radio-" + counter).prop('checked', true);

            const audio = new Audio("/sounds/beep-08b.wav");
            audio.play();

            counter++;
        }else{
            counter = 1;
        }
    },1000);
    $(".reset-counter").click(function () {
        $('.radio').prop('checked', false);
        $(".radio-0").prop('checked', true);
        counter = 1;
        started = 0;
    });
    /*
     *  Reset question in case of error
     */
    $(".reset-question").click(function () {
        $.ajax({
            url: '/reset-question',
            method: 'POST',
            dataType: "json",
            data: {
                id : $("#set_id").val()
            },
            success: function success(response) {
                location.reload();
            }
        });
    });
});
