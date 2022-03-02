$(document).ready(function () {

    let questionCounter = 1;

    $("body").on('click', '.add-question', function () {

        let question = $('#question-zero').clone().prop("id", "question-" + (questionCounter ++));
        question.find('input[name="answer[]"]').val('');
        question.find('select[name="correct[]"]').val('0');
        question.find('input[name="delete[]"]').addClass('c-p');

        question.appendTo(".questions");
    });

    $("body").on('click', '.c-p', function () {
        $(this).parent().parent().remove();
    })
});
