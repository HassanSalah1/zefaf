<?php

namespace App\Services\Dashboard\Contact;

use App\Repositories\Dashboard\Contact\ContactRepository;
use App\Repositories\General\UtilsRepository;
use App\Repositories\General\ValidationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class ContactService
{

    public static function getContactMessagesData(array $data)
    {
        return ContactRepository::getContactMessagesData($data);
    }

    public static function deleteContact(array $data)
    {
        $response = ContactRepository::deleteContact($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

    public static function getContactDetails($id)
    {
        $contact = ContactRepository::getContactDetails($id);
        if ($contact) {
            $data['title'] = $contact->page_title;
            $data['active'] = '';
            $data['user'] = auth()->user();
            $data['contact'] = $contact;
            $data['locale'] = App::getLocale();
            return view('admin.contact.contact_details')->with($data);
        } else {
            return redirect()->back();
        }
    }

    public static function sendReplayMessage(array $data)
    {
        $rules = [
            'message' => 'required',
        ];
        $validate = ValidationRepository::validateWebGeneral($data, $rules);
        if (!$validate) {
            return $validate;
        }
        $response = ContactRepository::sendReplayMessage($data);
        return UtilsRepository::response($response, trans('admin.process_success_message')
            , trans('admin.success_title'));
    }

}

?>