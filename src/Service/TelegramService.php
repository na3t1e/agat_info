<?php

namespace App\Service;

use App\Entity\Contact;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\TelegramBotHandler;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramTransport;
use Symfony\Component\Notifier\Chatter;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Notifier;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Transport;
use Symfony\Component\Notifier\Transport\TransportInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

class TelegramService
{

    public function sendOrder(Order $data): bool
    {

        $chatter = new TelegramTransport($_ENV['TELEGRAM_API_KEY']);
        $chatMessage = new ChatMessage((string) $data);
        $telegramOptions = (new TelegramOptions())
            ->chatId('-1001864724757')
            ->parseMode('HTML')
            ->disableWebPagePreview(true)
            ;

        $chatMessage->options($telegramOptions);
        try {
            $chatter->send($chatMessage);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }

//    public function dataFormat($data): string {
//        $message = '';
//        foreach ($data as $key => $value) {
//            $key = $this->translator->trans('general.' . $key);
//            $message .= $key . ": " . $value . "\n";
//        }
//        return $message;
//    }
}