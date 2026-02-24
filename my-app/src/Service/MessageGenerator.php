<?php

namespace App\Service;

class MessageGenerator
{
    public function getHappyMessage(): string
    {
        $messages = [
            '做得好！你快要精通 Symfony 了！',
            '太棒了，這就是 DI 的力量！',
            '你是未來的 Drupal 大師！',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }
}
