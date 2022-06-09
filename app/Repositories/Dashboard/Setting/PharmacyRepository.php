<?php
namespace App\Repositories\Dashboard\Setting;


use App\Models\Pharmacy;
use App\Models\WorkingDay;
use App\Repositories\General\UtilsRepository;
use Yajra\DataTables\Facades\DataTables;

class PharmacyRepository
{

    // get Pharmacies and create datatable data.
    public static function getPharmaciesData(array $data)
    {
        $Pharmacies = Pharmacy::get();
        return DataTables::of($Pharmacies)
            ->editColumn('logo', function ($pharmacy) {
                if ($pharmacy->logo !== null) {
                    return '<a href="' . url($pharmacy->logo) . '" data-popup="lightbox">
                    <img src="' . url($pharmacy->logo) . '" class="img-rounded img-preview"
                    style="max-height:50px;max-width:50px;"></a>';
                }
            })
            ->addColumn('actions', function ($pharmacy) {
                $user = auth()->user();
                $ul = '';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.edit') . '" id="' . $pharmacy->id . '"  href="' . url('/pharmacy/edit/' . $pharmacy->id) . '" class="on-default edit-row btn btn-info"><i class="fa fa-edit"></i></a>
                   ';
                $ul .= '<a data-toggle="tooltip" title="' . trans('admin.delete_action') . '" id="' . $pharmacy->id . '" onclick="deletePharmacy(this);return false;" href="#" class="on-default remove-row btn btn-danger"><i class="fa fa-trash-o"></i></a>';
                return $ul;
            })->make(true);
    }

    public static function addPharmacy(array $data)
    {
        $pharmacyData = [
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'city_id' => $data['city_id'],
            'phone' => $data['phone'],
            'lat' => $data['latitude'],
            'long' => $data['longitude'],
            'short_description_ar' => $data['short_description_ar'],
            'short_description_en' => $data['short_description_en'],
            'description_ar' => $data['description_ar'],
            'description_en' => $data['description_en']
        ];
        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'logo';
        $image_path = 'uploads/pharmacies/';
        $pharmacyData['logo'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);
        if ($pharmacyData['logo'] === false) {
            unset($pharmacyData['logo']);
        }

        $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
        $image_name = 'image';
        $image_path = 'uploads/pharmacies/';
        $pharmacyData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);
        if ($pharmacyData['image'] === false) {
            unset($pharmacyData['image']);
        }

        $created = Pharmacy::create($pharmacyData);
        if ($created) {
            if (isset($data['workDays']) && count($data['workDays']) > 0) {
                foreach ($data['workDays'] as $key => $workDay) {
                    $workDayData = [
                        'pharmacy_id' => $created->id,
                        'day' => $workDay,
                        'from' => date('H:i:s', strtotime($data['fromTimes'][$key])),
                        'to' => date('H:i:s', strtotime($data['toTimes'][$key]))
                    ];
                    WorkingDay::create($workDayData);
                }
            }
            return true;
        }
        return false;
    }

    public static function deletePharmacy(array $data)
    {
        $pharmacy = Pharmacy::where(['id' => $data['id']])->first();
        if ($pharmacy) {
            $pharmacy->forceDelete();
            return true;
        }
        return false;
    }

    public static function changePharmacy(array $data)
    {
        $pharmacy = Pharmacy::where(['id' => $data['id']])->first();
        if ($pharmacy) {
            $pharmacy->update(['is_active' => !$pharmacy->is_active]);
            return true;
        }
        return false;
    }

    public static function getPharmacyData(array $data)
    {
        $pharmacy = Pharmacy::where(['id' => $data['id']])->first();
        if ($pharmacy) {
            return $pharmacy;
        }
        return false;
    }

    public static function editPharmacy(array $data)
    {
        $pharmacy = Pharmacy::where(['id' => $data['id']])->first();
        if ($pharmacy) {
            $pharmacyData = [
                'name_ar' => $data['name_ar'],
                'name_en' => $data['name_en'],
                'city_id' => $data['city_id'],
                'phone' => $data['phone'],
                'lat' => $data['latitude'],
                'long' => $data['longitude'],
                'short_description_ar' => $data['short_description_ar'],
                'short_description_en' => $data['short_description_en'],
                'description_ar' => $data['description_ar'],
                'description_en' => $data['description_en']
            ];
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'logo';
            $image_path = 'uploads/pharmacies/';
            $pharmacyData['logo'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);
            if ($pharmacyData['logo'] === false) {
                unset($pharmacyData['logo']);
            } else {
                if ($pharmacy->logo !== null && file_exists($pharmacy->logo)) {
                    unlink($pharmacy->logo);
                }
            }
            // image
            $file_id = 'IMG_' . mt_rand(00000, 99999) . (time() + mt_rand(00000, 99999));
            $image_name = 'image';
            $image_path = 'uploads/pharmacies/';
            $pharmacyData['image'] = UtilsRepository::createImage($data['request'], $image_name, $image_path, $file_id);
            if ($pharmacyData['image'] === false) {
                unset($pharmacyData['image']);
            } else {
                if ($pharmacy->image !== null && file_exists($pharmacy->image)) {
                    unlink($pharmacy->image);
                }
            }
            $updated = $pharmacy->update($pharmacyData);
            if ($updated) {
                return true;
            }
        }
        return false;
    }

}

?>
