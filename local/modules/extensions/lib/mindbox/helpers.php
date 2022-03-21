<?php


namespace Extensions\remoteServer;

use Extensions\RemoteCards;


class Helpers
{
    const SECRET_KEY = 'yourSecretKey';

    static function getUsualHeaders(): array
    {
        return array(
            "Content-Type: application/json",
            "Authorization: Mindbox secretKey=\"" . static::SECRET_KEY . "\"",
            "charset: utf-8"
        );
    }

    protected static $isInit;
    /**
     * @var RemoteCards $remoteCardLoyalty
     */
    protected static $remoteCardLoyalty;

    protected static function init(): bool
    {
        if (static::$isInit) {
            return false;
        }
        //иницилизация объекта ответсвенного за remoteServer
        static::$remoteCardLoyalty = new RemoteCards();
        /**
         * to do include modules
         */
        return static::$isInit = true;
    }


    /**
     * методо позволяющий запушить карту для текущего пользователя в MindBox
     * @param string $cardNumber
     * @param string $password
     * @return void
     */
    public static function pushCardForCurrentUser(string $cardNumber, string $password)
    {
        static::init();
        $user = User::getCurrent(); //singleton for current user
        $arCard = Card::GetArrAllByCardNumberPassword($cardNumber, $password); //get Card for current user
        if (!$arCard) {
            return; //if we havent the card
        }
        static::$remoteCardLoyalty->setArCards([ //пушим в удаленный сервера карту
            [
                //RemoteCards содердит константы не пушим непосредственные данные
                RemoteCards::KEY_MOBILE_PHONE => $user->getPhoneForManzana(), //phone of user
                RemoteCards::KEY_CARD_NUMBER => $cardNumber,    //card's number
                RemoteCards::KEY_CARD_BALANCE => $arCard[Card::FILED_BALANCE] //balance of card of current user
            ]]);
        static::$remoteCardLoyalty->pushCards();
    }
}