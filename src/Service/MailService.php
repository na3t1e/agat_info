<?php

namespace App\Service;

use App\Entity\Contact;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\TelegramBotHandler;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
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

class MailService
{
    private MailerInterface $mailer;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendOrder(Order $data): bool
    {
        $email = (new TemplatedEmail())
            ->from('akagat.info@mail.ru')
            ->to(new Address('antondead1337@gmail.com'))
            ->subject('Новый заказ! | Авиакомпания "АГАТ"')

            // path of the Twig template to render
            ->htmlTemplate('emails/order.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'order' => $data
            ]);
        try {
            $this->mailer->send($email);
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            dd($e);
        }
        return true;
    }
}