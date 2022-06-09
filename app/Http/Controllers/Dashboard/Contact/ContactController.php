<?php

namespace App\Http\Controllers\Dashboard\Contact;

use App\Services\Dashboard\Contact\ContactService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class ContactController extends Controller
{
    //

    public function showContactMessages(){
        $data['title'] = trans('admin.contact_messages_title');
        $data['user'] = auth()->user();
        $data['active'] = 'contact_messages';
        $data['debatable_names'] = array(trans('admin.name') , trans('admin.email'),
            trans('admin.title') , trans('admin.message_delivery_date'),
            trans('admin.actions'));
        $data['locale'] = App::getLocale();
        return view('admin.contact.contact')->with($data);
    }

    public function getContactMessagesData(Request $request){
        $data = $request->all();
        return ContactService::getContactMessagesData($data);
    }

    public function deleteContact(Request $request){
        $data = $request->all();
        return ContactService::deleteContact($data);
    }

    public function showContactDetails($id)
    {
        return ContactService::getContactDetails($id);
    }

    public function sendReplayMessage(Request $request){
        $data = $request->all();
        return ContactService::sendReplayMessage($data);
    }

}
