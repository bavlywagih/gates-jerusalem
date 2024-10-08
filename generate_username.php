<?php
session_start();
require_once('connect.php'); // افتراض أن هذا الملف يتضمن الاتصال بقاعدة البيانات

function generateRandomUsername($con)
{
    $words = [
        'saint',
        'icon',
        'cross',
        'liturgy',
        'bishop',
        'priest',
        'deacon',
        'monk',
        'nun',
        'cathedral',
        'psalm',
        'gospel',
        'apostle',
        'martyr',
        'holy',
        'baptism',
        'chrismation',
        'eucharist',
        'orthodox',
        'vespers',
        'hymn',
        'fasting',
        'pascha',
        'nativity',
        'trinity',
        'resurrection',
        'ascension',
        'pentecost',
        'transfiguration',
        'annunciation',
        'theotokos',
        'iconostasis',
        'clergy',
        'divine',
        'sacrament'
    ];

    $stmt = $con->prepare("SELECT username FROM users WHERE username LIKE 'user-%'");
    $stmt->execute();
    $usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $usedWords = array_map(function ($name) {
        return explode('-', $name)[1];
    }, $usernames);

    if (count($usedWords) == count($words)) {
        do {
            $randomNumber = rand(1000, 9999);
            $username = 'user-' . $randomNumber;
            $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $count = $stmt->fetchColumn();
        } while ($count > 0);
    } else {
        do {
            $randomWord = $words[array_rand($words)];
        } while (in_array($randomWord, $usedWords));
        $username = 'user-' . $randomWord;
    }
    return $username;
}

echo generateRandomUsername($con);
