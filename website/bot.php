<?php

require_once "vendor/autoload.php";

$token = "697929164:AAFh_tjU41GvlObfc6qow21ewvw-hK694ZM";
$bot = new \TelegramBot\Api\Client($token);


//ALERTING POST/////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($_POST["ready"] == "yes") {
    $bot->sendMessage(550070094, "Your drink is ready, bon appétit!");
}

//COMMANDS//////////////////////////////////////////////////////////////////////////////////////////////////////////////

//start command <maybe add authorization later>
$bot->command('start', function ($message) use ($bot) {
    //user registration
    $answer = "Hi) I'm UCup bot, Your humble servant. My duty is to remind you about your drink, when it's ready.";
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

//help command
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Commands:
/help - lists all commands
/id - shows your id';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

//command for getting the id <development stuff>
$bot->command('id', function ($message) use ($bot) {
    $answer = $message->getChat()->getId();
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

/*//command for setting the temperature
$bot->command('temp', function ($message) use ($bot) {
    $answer = "Set the temperature that is comfortable for you.";
    $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("Hotter", "Medium", "Colder")), true);
    $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);

    if ($text = 'Hotter'){
        $fp = fopen("buf.txt", "w");
        $test = fwrite($fp, 60);
        fclose($fp);
    }
    if ($text = 'Medium'){
        $fp = fopen("buf.txt", "w");
        $test = fwrite($fp, 50);
        fclose($fp);
    }
    if ($text = 'Colder'){
        $fp = fopen("buf.txt", "w");
        $test = fwrite($fp, 40);
        fclose($fp);
    }

});*/

$bot->run();