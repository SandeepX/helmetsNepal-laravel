<?php

namespace App\Helper;

use Exception;

class SendInBlueMail
{
    const WELCOME_LIST_ID = 6;

    public $sendInBlueApiKey = '';

    public $apiSendInBlueUrl = 'https://api.sendinblue.com/v3/contacts';

    public $addExistingContactToListUrl = 'https://api.sendinblue.com/v3/contacts/lists/'.self::WELCOME_LIST_ID.'/contacts/add';

    public $removeContactApiSendInBlueUrl = 'https://api.sendinblue.com/v3/contacts/lists/listId/contacts/remove';


    public function __construct()
    {
        $this->sendInBlueApiKey = config('sendInBlue.sendInBlue_api_key') ?? '';
        if (!$this->sendInBlueApiKey) {
            throw new Exception('Send IN BLue Api key missing.');
        }
    }

    public function sendSendInBlueMail($newLetterEmail)
    {
        try{
            $payload = [
                'email' => $newLetterEmail,
                'listIds' => [self::WELCOME_LIST_ID]
            ];
            $payload = json_encode($payload);

            $headers[] = 'accept: application/json';
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'api-key:' .$this->sendInBlueApiKey;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiSendInBlueUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_exec($ch);
            $response = curl_getinfo($ch);
            curl_close($ch);

            if($response['http_code'] !== 201){
                throw new Exception('Oops ! something went wrong.');
            }
            return true;
        }catch(\Exception $error){
            throw $error;
        }

    }

    public function addExistingContactsToList($listId)
    {
        try{
            $payload['ids'] = [$listId->id];
            $headers[] = 'accept: application/json';
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'api-key:' .$this->sendInBlueApiKey;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->addExistingContactToListUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false)
            ;
            curl_exec($ch);
            $response = curl_getinfo($ch);
            curl_close($ch);

            if($response['http_code'] == 404){
                throw new Exception('List ID not found.');
            }
            if($response['http_code'] == 400){
                throw new Exception('Adding contact to a list failed.');
            }
        }catch(\Exception $error){
            throw $error;
        }

    }



}
