<?php

namespace App\Repositories;

use App\Apartment;
use Illuminate\Support\Facades\Auth;
use Image;
use File;

class ApartmentRepository extends Repository
{
    public function __construct(Apartment $apartment)
    {
        $this->model = $apartment;
    }

    public function one($alias, $attr = array(), $where = false)
    {

        $apartment = parent::one($alias, $attr, $where);

        if ($apartment && !empty($attr)) {
            $apartment->load('book');
        }

        return $apartment;
    }

    public function createApartment($request)
    {
        $data = $request->except('_token');

        if ($request->hasFile('img')) {

            $imgNames = $this->moveImg($data);

            $data['img'] = json_encode($imgNames);
        }

        $this->model->fill($data);
        if ($request->user()->apartments()->save($this->model)) {
            return ['status' => 'Apartment added'];
        }
    }

    public function updateApartment($request, $apartment)
    {
        $data = $request->except('_token', '_method');

        $dir = config('settings.apartments.image.dir');

        if ($apartment->alias != $data['alias']) {
            rename($dir . $apartment->alias, $dir . $data['alias']);
        }

        $path = $dir . $data['alias'];

        if ($data['delete'] != null && count($data['delete']) == count($apartment->img) && !$request->hasFile('img')) {
            array_pop($data['delete']);
        }

        if ($request->hasFile('img')) {

            $imgNames = $this->moveImg($data);

            if ($data['delete'] != null) {
                $result = $this->removeImg($data['delete'], $apartment['img'], $path);
                $arr = array_merge($imgNames, $result);
            } else {
                if (empty($apartment['img'])) {
                    $arr = $imgNames;
                } else {
                    $arr = array_merge($apartment['img'], $imgNames);
                }
            }

            $data['img'] = json_encode($arr);
        }

        if ($data['delete'] != null && !$request->hasFile('img')) {
            $result = $this->removeImg($data['delete'], $apartment['img'], $path);
            $data['img'] = json_encode($result);
        }

        $data['status'] = 0;
        $apartment->fill($data);

        if ($apartment->update()) {
            return ['status' => 'Apartment updated'];
        }
    }

    public function moveImg($data)
    {
        $names = [];
        $width = config('settings.apartments.image.width');
        $dir = config('settings.apartments.image.dir');
        $path = $dir . $data['alias'];

        if (!File::exists($path)) {
            File::makeDirectory($path);
        }

        foreach ($data['img'] as $image) {
//            $filename = str_random() . "." . $image->getClientOriginalExtension();
            $filename = $image->getClientOriginalName();
            $names[] = $filename;
            $img = Image::make($image->getRealPath());

            if ($img->width() > $width || $img->height() > $width) {
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $img->save($path . '/' . $filename);
        }

        return $names;
    }

    public function deleteApartment($apartment)
    {
        $dir = config('settings.apartments.image.dir');

        $apartment->book()->delete();

        if ($apartment->delete()) {
            File::deleteDirectory($dir . $apartment->alias);
            return ['status' => 'Apartment deleted'];
        }
    }

    public function removeImg($deleteList, $dbList, $path)
    {
//        $delete = array_filter(explode("|", $deleteList));
        $delete = $deleteList;
        $result = array_values(array_diff($dbList, $delete));
        $del = [];
        foreach ($delete as $item) {
            $del[] = $path . '/' . $item;
        }
        File::delete($del);

        return $result;
    }

    public function userApartment($id)
    {
        $apartment = $this->model->where('user_id', $id)->get();
        $apartment->load('book');

        return $apartment;
    }

    public function checkApartmentOwner($apartment)
    {
        $userId = Auth::id();
        $apartment = $this->model->where('alias', $apartment->alias)->first();

        if ($apartment == null) {
            return true;
        }

        if ($apartment->user_id != $userId) {
            return true;
        }

        return false;
    }

    public function checkApartmentCount()
    {
        $userId = Auth::id();
        $apartment = $this->model->where('user_id', $userId)->get();

        if (count($apartment) >= config('settings.apartments.user_count_create')) {
            return true;
        }

        return false;
    }

}