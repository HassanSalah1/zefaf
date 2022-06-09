<?php

namespace App\Repositories\Dashboard\User;


use App\Entities\CategoryQuestionType;
use App\Entities\EditRequestStatus;
use App\Entities\MembershipType;
use App\Entities\UserRoles;
use App\Entities\UserStatus;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CityResource;
use App\Models\Setting\Category;
use App\Models\Setting\City;
use App\Models\Setting\Membership;
use App\Models\User\EditRequest;
use App\Models\User\Notification;
use App\Models\User\Package;
use App\Models\User\Review;
use App\Models\User\User;
use App\Models\User\UserImage;
use App\Models\User\Vendors;
use App\Repositories\General\UtilsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class VendorRepository
{

    public static function getVendorsData(array $data)
    {
        $vendors = User::join('vendors', 'vendors.user_id', '=', 'users.id')
            ->join('memberships', 'vendors.membership_id', '=', 'memberships.id')
            ->select(['users.id', 'status', 'name', 'phone', 'email',
                'membership_duration', 'membership_id', 'membership_date', 'memberships.type',
                DB::raw("DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY)) AS end_membership_date")])
            ->where(['role' => UserRoles::VENDOR]);

        if (isset($data['searchStatus']) && !empty($data['searchStatus'])
            && $data['searchStatus'] !== 'all') {
            $vendors = $vendors->where(['status' => $data['searchStatus']]);
        }

        if (isset($data['category_id']) && !empty($data['category_id'])
            && $data['category_id'] !== '-1') {
            $vendors = $vendors->where(['category_id' => $data['category_id']]);
        }

        if (isset($data['city_id']) && !empty($data['city_id'])
            && $data['city_id'] !== '-1') {
            $vendors = $vendors->where(['city_id' => $data['city_id']]);
        }

        return DataTables::of($vendors)
            ->filterColumn('end_membership_date', function ($query, $keyword) {
                $sql = "DATE(DATE_ADD(membership_date, INTERVAL membership_duration DAY)) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('status', function ($vendor) {
                if ($vendor->status === UserStatus::ACTIVE) {
                    return '<span class="btn btn-success">' . trans('admin.active_status') . '</span>';
                } else if ($vendor->status === UserStatus::REVIEW) {
                    return '<span class="btn btn-warning">' . trans('admin.review_status') . '</span>';
                } else if ($vendor->status === UserStatus::BLOCKED) {
                    return '<span class="btn btn-danger">' . trans('admin.blocked_status') . '</span>';
                }
            })
//            ->addColumn('membership', function ($vendorObj) {
//                if ($vendorObj->membership_id) {
//                    $membership = Membership::find($vendorObj->membership_id);
//                    return $membership->type;
//                }
//            })
//            ->addColumn('end_membership_date', function ($vendorObj) {
//                $vendor = Vendors::where(['user_id' => $vendorObj->id])
//                    ->select(,
//                        'user_id', 'biography', 'category_id', 'from_price'
//                        , 'to_price', 'membership_id', 'membership_duration', 'membership_date'
//                        , 'category_questions', 'website', 'instagram', 'facebook')
//                    ->first();
//                return $vendor ? $vendor->end_membership_date : '';
//            })
            ->editColumn('membership_duration', function ($vendorObj) {
                if ($vendorObj->membership_duration) {
                    $duration = ($vendorObj->membership_duration / 30);
                    return (($duration >= 1) ? ($duration . ' Months') :
                        ($vendorObj->membership_duration . ' Days'));
                }
            })
            ->addColumn('actions', function ($vendorObj) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.details_action') . '" href="/vendor/details/' . $vendorObj->id . '" class="on-default edit-row btn btn-primary"><i class="fa fa-eye"></i></a> ';
                // block or activate account
                if ($vendorObj->status === UserStatus::BLOCKED) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.active_action') . '" id="' . $vendorObj->id . '" onclick="activeVendor(this);return false;" href="#" class="on-default remove-row btn btn-success"><i class="fa fa-check"></i></a> ';
                } else if ($vendorObj->status === UserStatus::ACTIVE) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.block_action') . '" id="' . $vendorObj->id . '" onclick="blockVendor(this);return false;"  href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-lock"></i></a> ';
                } else if ($vendorObj->status === UserStatus::REVIEW) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.approve_action') . '" id="' . $vendorObj->id . '" onclick="approveVendor(this);return false;"  href="#" class="on-default remove-row btn btn-warning"><i class="fa fa-check-circle"></i></a> ';
                }
//                // verify
//                if ($vendorObj->status === UserStatus::UNVERIFIED) {
//                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.verify_action') . '" id="' . $vendorObj->id . '" onclick="verifyAccount(this);return false;" href="#" class="on-default remove-row btn btn-warning"><i class="fa fa-certificate"></i></a> ';
//                }
                return $ul;
            })
            ->make(true);
    }

    public static function changeStatus(array $data)
    {
        $vendor = User::where(['id' => $data['id']])->first();
        if ($vendor && $vendor->status === UserStatus::REVIEW) {
            $vendor->update(['status' => UserStatus::ACTIVE]);
            $notification_obj = [
                'title_ar' => 'تفعيل الحساب',
                'message_ar' => 'لقد تم تفعيل حسابك',
                'title_en' => 'account approval',
                'message_en' => 'your account has been approved',
                'user_id' => $vendor->id,
//                'type' => NotificationType::Notify
            ];
            if ($vendor->device_token != null) {
                $notification_data = [
                    'title' => $notification_obj['title_' . $vendor->lang],
                    'message' => $notification_obj['message_' . $vendor->lang],
                ];
                $notification_data_obj = array_merge($notification_data, [
                    'user_id' => $vendor->id,
                ]);
                UtilsRepository::sendAndroidFCM($notification_data_obj, $vendor->device_token);
            }
            Notification::create($notification_obj);

            return true;
        } else if ($vendor && $vendor->status === UserStatus::ACTIVE) {
            $vendor->update(['status' => UserStatus::BLOCKED]);
            return true;
        } else if ($vendor && $vendor->status === UserStatus::BLOCKED) {
            $vendor->update(['status' => UserStatus::ACTIVE]);
            return true;
        }
        return false;
    }


    public static function changeRequestStatus(array $data)
    {
        $request = EditRequest::where(['id' => $data['id']])->first();
        // approve edit request
        if ($request) {
            $request->update([
                'status' => $data['status'],
            ]);
            if ($data['status'] === EditRequestStatus::APPROVED) {
                $vendor = Vendors::where(['user_id' => $request->user_id])->first();
                $user = User::where(['id' => $request->user_id])->first();
                $user->update([
                    'name' => $request->name ? $request->name : $user->name,
                    'phone' => $request->phone ? $request->phone : $user->phone,
                    'email' => $request->email ? $request->email : $user->email,
                    'city_id' => $request->city_id ? $request->city_id : $user->city_id,
                ]);
                $vendor->update([
                    'biography' => $request->biography ? $request->biography : $vendor->biography,
                    'from_price' => $request->from_price ? $request->from_price : $vendor->from_price,
                    'to_price' => $request->to_price ? $request->to_price : $vendor->to_price,
                    'category_questions' => $request->category_questions ? $request->category_questions : $vendor->category_questions,
                    'website' => $request->website ? $request->website : $vendor->website,
                    'instagram' => $request->instagram ? $request->instagram : $vendor->instagram,
                    'facebook' => $request->facebook ? $request->facebook : $vendor->facebook,
                    'locations' => $request->locations ? $request->locations : $vendor->locations
                ]);
            }
            return true;
        } // approve user

        return false;
    }


    public static function verifyVendor(array $data)
    {
        $vendor = User::where(['id' => $data['id']])->first();
        if ($vendor) {
            $vendor->update(['status' => UserStatus::ACTIVE]);
            return true;
        }
        return false;
    }

    public static function saveAddVendor(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => UserRoles::VENDOR,
            'status' => UserStatus::ACTIVE,
            'city_id' => $data['city_id'],
            'lang' => 'en',
        ];
        //image
        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'image';
        $image_path = 'uploads/vendors/';
        $image = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id, true);
        if ($image === false) {
            unset($image);
        }
        $user = User::create($userData);
        if ($user) {
            if (isset($image)) {
                UserImage::create([
                    'user_id' => $user->id,
                    'image' => $image
                ]);
            }
            $membership = null;
            if (isset($data['membership_id'])) {
                $membership = Membership::find($data['membership_id']);
                if ($membership && $membership->type === MembershipType::FREE) {
//                    $data['duration'] = $membership->duration;
                    $data['duration'] = $data['free_duration'];
                }
            }
            $vendorData = [
                'user_id' => $user->id,
                'biography' => $data['biography'],
                'category_id' => $data['category_id'],
                'from_price' => $data['price_from'],
                'to_price' => $data['price_to'],
                'membership_id' => $membership ? $membership->id : null,
                'membership_duration' => $data['duration'],
                'membership_date' => $membership ? date('Y-m-d') : null,
                'category_questions' => null
            ];
            Vendors::create($vendorData);
            return true;
        }
        return false;
    }

    public static function getVendorPackagesData(array $data)
    {
        $packages = Package::where(['user_id' => $data['id']])->get();
        return DataTables::of($packages)
            ->editColumn('price', function ($package) {
                return number_format($package->price, 0);
            })
            ->make(true);
    }

    public static function getVendorReviewsData(array $data)
    {
        $reviews = Review::where(['vendor_id' => $data['id']])->get();
        return DataTables::of($reviews)
            ->addColumn('name', function ($review) {
                $user = User::where(['id' => $review->user_id])->first();
                return $user->name;
            })
            ->make(true);
    }

    public static function getRequestsData(array $data)
    {
        $requests = EditRequest::where(['edit_requests.status' => EditRequestStatus::PENDING])
            ->join('users', 'users.id', '=', 'edit_requests.user_id')
            ->select([
                'users.name AS user_name', 'users.phone AS user_phone',
                'edit_requests.user_id',
                'edit_requests.id', 'edit_requests.name', 'edit_requests.phone', 'edit_requests.email',
                'edit_requests.city_id', 'edit_requests.biography', 'edit_requests.category_questions',
                'edit_requests.from_price', 'edit_requests.to_price', 'edit_requests.instagram',
                'edit_requests.facebook', 'edit_requests.website', 'edit_requests.locations',
                'edit_requests.status'
            ]);
        return DataTables::of($requests)
            ->addColumn('category', function ($request) {
                return @$request->user->vendor->category->name;
            })
            ->addColumn('sub_category', function ($request) {
                return @$request->user->vendor->category->category->name;
            })
            ->addColumn('new', function ($request) {
                $html = '<ul>';
                if ($request->name) {
                    $html .= '<li>name: ' . $request->name . '</li>';
                }
                if ($request->phone) {
                    $html .= '<li>phone: ' . $request->phone . '</li>';
                }
                if ($request->email) {
                    $html .= '<li>email: ' . $request->email . '</li>';
                }
                if ($request->biography) {
                    $html .= '<li>biography: ' . $request->biography . '</li>';
                }
                if ($request->from_price) {
                    $html .= '<li>from_price: ' . $request->from_price . '</li>';
                }
                if ($request->to_price) {
                    $html .= '<li>to_price: ' . $request->to_price . '</li>';
                }
                if ($request->instagram) {
                    $html .= '<li>instagram: ' . $request->instagram . '</li>';
                }
                if ($request->facebook) {
                    $html .= '<li>facebook: ' . $request->facebook . '</li>';
                }
                if ($request->website) {
                    $html .= '<li>website: ' . $request->website . '</li>';
                }
                if ($request->locations) {
                    $html .= '<li>locations:';
                    $html .= '<ul>';
                    foreach (json_decode($request->locations, true) as $location) {
                        $html .= '<li>' . (isset($location['name']) ? $location['name'] : '') . '(' . (isset($location['location']) ? $location['location'] : '') . ')' . '</li>';
                    }
                    $html .= '</ul>';
                    $html .= '</li>';
                }
                if ($request->city_id) {
                    $city = City::where(['id' => $request->city_id])->first();
                    $html .= '<li>city: ' . $city->name . '</li>';
                }
                if ($request->category_questions) {
                    $questions = json_decode($request->category_questions, true);
                    $vendor = Vendors::where(['user_id' => $request->user_id])->first();
                    $category = Category::where(['id' => $vendor->category_id])->first();
                    if ($category->question_type === CategoryQuestionType::CAPACITY_RANGE && isset($questions[$category->question_type])) {
                        $html .= '<li>capacity range: ' . $questions[$category->question_type] . '</li>';
                    } else if ($category->question_type !== CategoryQuestionType::DIAMOND_GOLD && isset($questions[$category->question_type]) && intval($questions[$category->question_type]) === 1) {
                        $html .= '<li>' . trans('admin.type_' . $category->question_type) . '</li>';
                    } else if ($category->question_type !== CategoryQuestionType::DIAMOND_GOLD &&
                        isset($questions[$category->question_type]) && intval($questions[$category->question_type]) === 0) {
                        $html .= '<li>' . trans('admin.type_' . $category->question_type) . ' (off)</li>';
                    } else if ($category->question_type === CategoryQuestionType::DIAMOND_GOLD) {
                        if (isset($questions['diamond']) && intval($questions['diamond']) === 1) {
                            $html .= '<li>diamond</li>';
                        } else if (isset($questions['diamond']) && intval($questions['diamond']) === 0) {
                            $html .= '<li>diamond (off)</li>';
                        }
                        if (isset($questions['gold']) && intval($questions['gold']) === 1) {
                            $html .= '<li>gold</li>';
                        } else if (isset($questions['gold']) && intval($questions['gold']) === 0) {
                            $html .= '<li>gold (off)</li>';
                        }
                    }
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('actions', function ($vendorObj) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="refuse" id="' . $vendorObj->id . '" onclick="blockVendor(this);return false;"  href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-lock"></i></a> ';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.approve_action') . '" id="' . $vendorObj->id . '" onclick="approveVendor(this);return false;"  href="#" class="on-default remove-row btn btn-success"><i class="fa fa-check-circle"></i></a> ';
                return $ul;
            })
            ->make(true);
    }

    public static function getSearchCategories(array $data)
    {
        $search = [];
        $search['category_id'] = $data['category_id'];
        if (isset($data['deleted']) && intval($data['deleted']) === 1) {
            $search['is_deleted'] = 0;
        }
        return CategoryResource::collection(Category::where($search)->get());
    }

    public static function getCountryCities(array $data)
    {
        return CityResource::collection(City::where(['is_deleted' => 0])
            ->where(['country_id' => $data['country_id']])->get());
    }

    public static function getVendorsReviewData(array $data)
    {
        $vendors = User::join('vendors', 'vendors.user_id', '=', 'users.id')
            ->select(['users.id', 'status', 'name', 'phone', 'email'])
            ->where([
                'role' => UserRoles::VENDOR,
                'status' => UserStatus::REVIEW
            ]);

        if (isset($data['category_id']) && !empty($data['category_id'])
            && $data['category_id'] !== '-1') {
            $vendors = $vendors->where(['category_id' => $data['category_id']]);
        }

        if (isset($data['city_id']) && !empty($data['city_id'])
            && $data['city_id'] !== '-1') {
            $vendors = $vendors->where(['city_id' => $data['city_id']]);
        }

        return DataTables::of($vendors)
            ->addColumn('actions', function ($vendorObj) {
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.details_action') . '" href="/vendor/details/' . $vendorObj->id . '" class="on-default edit-row btn btn-primary"><i class="fa fa-eye"></i></a> ';
                // block or activate account
                if ($vendorObj->status === UserStatus::BLOCKED) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.active_action') . '" id="' . $vendorObj->id . '" onclick="activeVendor(this);return false;" href="#" class="on-default remove-row btn btn-success"><i class="fa fa-check"></i></a> ';
                } else if ($vendorObj->status === UserStatus::ACTIVE) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.block_action') . '" id="' . $vendorObj->id . '" onclick="blockVendor(this);return false;"  href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-lock"></i></a> ';
                } else if ($vendorObj->status === UserStatus::REVIEW) {
                    $ul .= '<a data-toggle="tooltip" title="' . trans('admin.approve_action') . '" id="' . $vendorObj->id . '" onclick="approveVendor(this);return false;"  href="#" class="on-default remove-row btn btn-warning"><i class="fa fa-check-circle"></i></a> ';
                }
                return $ul;
            })
            ->make(true);
    }

}

?>
