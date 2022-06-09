<?php

namespace App\Repositories\Dashboard\Contact;


use App\Models\Contact;
use App\Models\User\User;
use App\Repositories\General\UtilsRepository;
use Yajra\DataTables\Facades\DataTables;

class ContactRepository
{

    // get contact messages for datatable with search params
    public static function getContactMessagesData($data)
    {
        $contacts = Contact::orderBy('created_at', 'desc');

        if (isset($data['date']) && !empty($data['date'])) {
            $data['date'] = date('Y-m-d', strtotime($data['date']));
            $contacts->where(function ($query) use ($data) {
                $query->whereDate('created_at', '=', $data['date']);
            });
        }
        $contacts = $contacts->get();

        return DataTables::of($contacts)
            ->addColumn('name', function ($contact) {
                $user = User::where(['id' => $contact->user_id])->first();
                return ($user) ? $user->name : null;
            })
            ->addColumn('email', function ($contact) {
                $user = User::where(['id' => $contact->user_id])->first();
                return ($user) ? $user->email : null;
            })
            ->addColumn('receive_date', function ($contact) {
                return date('Y M d', strtotime($contact->created_at));
            })
            ->addColumn('actions', function ($contact) {
                $ul = '<a data-toggle="tooltip" title="' . trans('admin.details_action') . '"  href="' . url('/contact/details/' . $contact->id) . '" class="on-default edit-row btn ' . (($contact->seen === 0) ? 'btn-info' : 'btn-success') . '"><i class="fa fa-eye"></i></a>
                   ';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '"  href="#" id="' . $contact->id . '" onclick="deleteContact(this);return false;" class="on-default edit-row btn btn-danger"><i class="fa fa-trash"></i></a>
                   ';
                return $ul;
            })
            ->make(true);
    }

    // delete contact message
    public static function deleteContact(array $data)
    {
        $deleted = Contact::where(['id' => $data['id']])->forceDelete();
        if ($deleted)
            return true;
        else
            return false;
    }

    // get contact message details
    public static function getContactDetails($id)
    {
        $contact = Contact::where(['id' => $id])->first();
        if ($contact) {
            $user = User::where(['id' => $contact->user_id])->first();
            $contact->name = $user->name;
            $contact->email = $user->email;
            $contact->page_title = trans('admin.contact_details');
            $contact->receive_date = date('Y M d', strtotime($contact->created_at));
            return $contact;
        } else
            return false;
    }

    // send replay message to user email if exist
    // then send push notification to user
    public static function sendReplayMessage($data)
    {

        $contact = Contact::where(['id' => $data['id']])->first();
        if ($contact) {
            $contact->update(['seen' => 1]);
            $message = $data['message'];
            // send email
            $subject = 'Glaragine Support';
            $template = 'general/email/contact';
            $data = [
                'subject' => $subject,
                'message' => $message,
                'template' => $template,
                'email' => $contact->email
            ];
            UtilsRepository::sendEmail($data);
            return true;
        }
        return false;
    }

}

?>
