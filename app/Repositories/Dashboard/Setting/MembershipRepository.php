<?php
namespace App\Repositories\Dashboard\Setting;


use App\Entities\MembershipType;
use App\Models\Setting\Membership;
use App\Repositories\General\UtilsRepository;
use Yajra\DataTables\Facades\DataTables;

class MembershipRepository
{

    // get Memberships and create datatable data.
    public static function getMembershipsData(array $data)
    {
        $memberships = Membership::get();
        return DataTables::of($memberships)
            ->editColumn('image', function ($membership) {
                if ($membership->image !== null) {
                    return '<a href="' . url($membership->image) . '" data-popup="lightbox">
                    <img src="' . url($membership->image) . '" class="img-rounded img-preview"
                    style="max-height:50px;max-width:50px;"></a>';
                } else {
                    return $membership->type;
                }
            })
            ->addColumn('features', function ($membership) {
                $html = '<ul>';
                foreach (json_decode($membership->features, true) as $feature) {
                    $html .= '<li>' . $feature . '</li>';
                }
                $html .= '</ul>';
                return $html;
            })->addColumn('actions', function ($membership) {
                $user = auth()->user();
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $membership->id . '" onclick="editMembership(this);return false;" href="#" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                if (intval($membership->is_active) === 1) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.inactive_action') . '" id="' . $membership->id . '" onclick="blockMembership(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-ban"></i></a>';
                } else {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.active_action') . '" id="' . $membership->id . '" onclick="activeMembership(this);return false;" href="#" class="on-default remove-row btn btn-success"><i class="fa fa-check"></i></a>';
                }
                return $ul;
            })->make(true);
    }

    public static function addMembership(array $data)
    {
        $membershipData = [
            'type' => $data['type'],
            'features_ar' => json_encode($data['features_ar']),
            'features_en' => json_encode($data['features_en']),
            'duration' => $data['type'] === MembershipType::FREE ? $data['duration'] : null,
            'price' => $data['type'] !== MembershipType::FREE ? $data['price'] : null,
            'discount' => $data['type'] !== MembershipType::FREE && isset($data['discount']) ?
                $data['discount'] : null,
        ];
        if ($data['type'] !== MembershipType::FREE) {
            //image
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'image';
            $image_path = 'uploads/memberships/';
            $membershipData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id, true);
            if ($membershipData['image'] === false) {
                unset($membershipData['image']);
            }
        }
        $created = Membership::create($membershipData);
        if ($created) {
            return true;
        }
        return false;
    }

    public static function deleteMembership(array $data)
    {
        $membership = Membership::where(['id' => $data['id']])->first();
        if ($membership) {
            $membership->update(['is_deleted' => 1]);
            return true;
        }
        return false;
    }

    public static function changeMembership(array $data)
    {
        $membership = Membership::where(['id' => $data['id']])->first();
        if ($membership) {
            $membership->update(['is_active' => !$membership->is_active]);
            return true;
        }
        return false;
    }

    public static function getMembershipData(array $data)
    {
        $membership = Membership::where(['id' => $data['id']])->first();
        if ($membership) {
            $membership->image = $membership->image !== null ? url($membership->image) : null;
            $membership->features_ar = json_decode($membership->features_ar, true);
            $membership->features_en = json_decode($membership->features_en, true);
            return $membership;
        }
        return false;
    }

    public static function editMembership(array $data)
    {
        $membership = Membership::where(['id' => $data['id']])->first();
        if ($membership) {
            $membershipData = [
                'type' => $data['type'],
                'features_ar' => json_encode($data['features_ar']),
                'features_en' => json_encode($data['features_en']),
                'duration' => $data['type'] === MembershipType::FREE ? $data['duration'] : null,
                'price' => $data['type'] !== MembershipType::FREE ? $data['price'] : null,
                'discount' => $data['type'] !== MembershipType::FREE && isset($data['discount']) ?
                    $data['discount'] : null,
            ];
            if ($data['type'] !== MembershipType::FREE) {
                // image
                $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
                $image_name = 'image';
                $image_path = 'uploads/memberships/';
                $membershipData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id, true);
                if ($membershipData['image'] === false) {
                    unset($membershipData['image']);
                } else {
                    if ($membership->image !== null && file_exists($membership->image)) {
                        unlink($membership->image);
                    }
                }
            }
            $updated = $membership->update($membershipData);
            if ($updated) {
                return true;
            }
        }
        return false;
    }

}

?>
