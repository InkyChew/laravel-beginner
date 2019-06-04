<?php
namespace App\Http\Controllers\Merchandise;

use App\Http\Controllers\Controller;

//Eloquent ORM Model
use App\Shop\Entity\User;
use App\Shop\Entity\Merchandise; 
use App\Shop\Entity\Transaction; 

use Validator; //use Validator class 
use DB;
use Exception;
use Image;

class MerchandiseController extends Controller{

    //index
    public function indexPage(){
        return redirect('/merchandise');
    }
   
    //addItem
    public function merchandiseCreateProcess(){
        $merchandise_data = [
            'status' => 'C',
            'name' => '',
            'name_en' => '',
            'introduction' => '',
            'introduction_en' => '',
            'photo' => null,
            'price' => '0',
            'remain_count' => '0',
        ];
        $Merchandise = Merchandise::create($merchandise_data);
        //重新導向至商品編輯頁
        return redirect('/merchandise/' . $Merchandise->id . '/edit');
    }

    //editItem
    public function merchandiseItemEditPage($merchandise_id){
        $Merchandise = Merchandise::findOrFail($merchandise_id);
        if(!is_null($Merchandise->photo)){
            $Merchandise->photo = url($Merchandise->photo);
        }
        $binding = [
            'title' => 'Edit Item',
            'Merchandise' => $Merchandise,
        ];
        return view('merchandise.editMerchandise', $binding);
    }

    //updateItem
    public function merchandiseItemUpdateProcess($merchandise_id){
        $Merchandise = Merchandise::findOrFail($merchandise_id);
        $input = request()->all();

        $rules = [
            'status' => [
                'required',
                'in:C,S',
            ],
            'name' => [
                'required',
                'max:80',
            ],
            'introduction' => [
                'required',
                'max:2000',
            ],
            'introduction_en' => [
                'required',
                'max:2000',
            ],
            'photo' => [
                'file',
                'image',
                'max:10240', //10MB
            ],
            'price' => [
                'required',
                'integer',
                'min:0',
            ],
            'remain_count' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
        
        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return redirect('/merchandise/' . $Merchandise->id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($input['photo'])){
            //有上傳圖片
            $photo = $input['photo']; //檔案格式資料轉成Illuminate\Http\UploadedFile(Object)
            $file_extension = $photo->getClientOriginalExtension(); //取得副檔名
            $file_name = uniqid() . '.' . $file_extension; //產生自訂隨機檔案
            $file_relative_path = 'images/merchandise/' . $file_name;
            $file_path = public_path($file_relative_path); //相對路徑中的檔案存在public目錄下
            $image = Image::make($photo) //$photo 物件化
                ->fit(450,300) //限制長寬
                ->save($file_path); //儲存檔案至指定路徑
            $input['photo'] = $file_relative_path; //設定檔案相對路徑
        }

        $Merchandise->update($input);

        return redirect('/merchandise/' . $Merchandise->id . 'edit');
    }

    //manageItem
    public function merchandiseManageListPage(){
        
        $row_per_page = 10;
        $MerchandisePaginate = Merchandise::OrderBy('created_at', 'desc')
            ->paginate($row_per_page);

        foreach($MerchandisePaginate as &$Merchandise){ //"&"直接修改value
            if(!is_null($Merchandise->photo)){
                $Merchandise->photo = url($Merchandise->photo);
            }
        }

        $binding = [
            'title' => 'Manage Item',
            'MerchandisePaginate' => $MerchandisePaginate,
        ];
        return view('merchandise.manageMerchandise', $binding);
    }

///////////////////////////////////////////////////////////////////////////////////////////

    //viewItemList
    public function merchandiseListPage(){
        
        $row_per_page = 10;
        $MerchandisePaginate = Merchandise::OrderBy('updated_at','desc')
            ->where('status', 'S')
            ->paginate($row_per_page);
        
        foreach($MerchandisePaginate as &$Merchandise){
            if(!is_null($Merchandise->photo)){
                $Merchandise->photo = url($Merchandise->photo);
            }
        }

        $binding = [
            'title' => 'Item List',
            'MerchandisePaginate' => $MerchandisePaginate,
        ];

        return view('merchandise.listMerchandise', $binding);
    }

    //viewSpecificItem
    public function merchandiseItemPage($merchandise_id){
        
        $Merchandise = Merchandise::findOrFail($merchandise_id);

        if(!is_null($Merchandise->photo)){
            $Merchandise->photo = url($Merchandise->photo);
        }

        $binding = [
            'title' => 'Item Page',
            'Merchandise' => $Merchandise,
        ];

        return view('merchandise.showMerchandise', $binding);
    }

    //buyItem
    public function merchandiseItemBuyProcess($merchandise_id){

        $input = request()->all();
        $rules = [
            'buy_count' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return redirect('/merchandise/' . $merchandise_id)
            ->withErrors($validator)
            ->withInput();
        }

        try{
            $user_id = session()->get('user_id');
            $User = User::findOrFail($user_id);

            //DB::beginTransaction(); //鎖定資料
            $Merchandise = Merchandise::findOrFail($merchandise_id);
            $buy_count = $input['buy_count'];
            $remain_count_after_buy = $Merchandise->remain_count - $buy_count;
            if($remain_count_after_buy < 0){
                throw new Exception('商品數量不足，無法購買');
            }
            $Merchandise->remain_count = $remain_count_after_buy;
            $Merchandise->save(); //更新EloquentModel資料
            $total_price = $buy_count * $Merchandise->price;
            $transaction_data = [
                'user_id' => $User->id,
                'merchandise_id' => $Merchandise->id,
                'price' => $Merchandise->price,
                'buy_count' => $buy_count,
                'total_price' => $total_price,
            ];
            Transaction::create($transaction_data);
            //DB::commit(); //解除鎖定
            $message = [
                'msg'=>[
                    'transaction successful',
                ],
            ];
            return redirect()->to('/merchandise/' . $Merchandise->id)
                ->with('success', $message);
        }catch(Exception $exception){
            DB::rollback();
            $error_message = [
                'msg' => $exception->getMessage(),
            ];
            return redirect()
                ->back()
                ->withErrors($error_message)
                ->withInput();
        }
    }

    //delete item
    public function merchandiseDeleteItem($merchandise_id){
        $Merchandise = Merchandise::findOrFail($merchandise_id);
        $Merchandise->delete();
        $message = [
            'msg'=>[
                'successful',
            ],
            'del'=>[
                'delete',
            ],
        ];      
        return redirect()->to('/merchandise/manage')
            ->with('success', $message);
    }
}
?>