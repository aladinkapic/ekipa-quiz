/*
 *  Import base libraries
 */

require('./bootstrap');

window.$ = window.jQuery = require('jquery'); // Include jQuery

/*
 *  Include all scripts that should load on every page such as:
 *
 *      - MENU
 *      - Search
 *      - Notify.JS
 *      - jQuery-UI
 *      - Select-2
 *      - Validation.JS
 *      - Submit.JS
 */

require('./layout/snippets/jquery-ui');
require('./layout/snippets/select-2');

// Require validator
window.validator = require('./layout/snippets/validation');

// Require custom notify.JS script for auto fadeout notifications
window.notify = require('./layout/snippets/notify');

// Pop up delete scripts
require('./layout/snippets/delete');

require('./layout/snippets/submit');
require('./layout/snippets/classes');
require('./layout/snippets/filters');

require('./layout/menu/menu');

/*
 *  Questions
 */
require('./app/quiz/questions');
require('./app/quiz/quiz');
