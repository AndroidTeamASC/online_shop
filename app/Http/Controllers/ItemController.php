<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Brand;
use App\Item;
use App\Size;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $sizes = Size::all();
        return view('backend.item.index',compact('categories','brands','sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $request->validate([
            "item_name"     => "required|min:3|max:151",
            "item_price"    => "required|min:1|max:151",
            "item_image"    => "required",
            "item_image.*"  =>'required|image|mimes:jpeg,jpg,gif,png,svg|max:2048',
            "brand"         => "required",
            "category"      => "required",
            "size"          => "required",
              
        ]);
           $data=array();
        if ($request->hasfile('item_image')) {

            foreach ( $request->file('item_image') as $image) {
            $name=uniqid().time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('image/storage'),$name);
            $path='image/storage/'.$name; 
                $data[] = $path;
            }
        }
            else{
             $data[]="";
        }
        // dd($request);
        $item = Item::Create([
             'id'       => $request->item_id,
            'item_name' => $request->item_name,
            'item_price'=> $request->item_price,
            'item_image'=> json_encode($data),
            'brand_id'  => $request->brand,
            'category_id' => $request->category,
            'size'      => json_encode($request->size),
            'user_id'   => 1
        ]);
     return response()->json(['success' => 'Item saved Successful']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $sizes = Size::all();
        return response()->json([
            'item' => $item,
            'sizes' => $sizes,
                    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            "edit_item_name" => "required|min:3|max:151",
            "edit_item_price" => "required|min:1|max:151", 
            "edit_item_image.*"=>'image|mimes:jpeg,jpg,gif,png,svg|max:2048'

              
        ]);
        // dd($request);
          $data=array();
        if ($request->hasfile('edit_item_image')) {

            foreach ( $request->file('edit_item_image') as $image) {
            $name=uniqid().time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('image/storage'),$name);
            $path='image/storage/'.$name; 
                $data[] = $path;
            }
        }
        else{
            $data = $request->item_old_image;
        }

        $item = Item::find($id);
        $item->item_name = $request->edit_item_name;
        $item->item_price = $request->edit_item_price;
        $item->item_image = json_encode($data);
        $item->brand_id = $request->edit_brand;
        $item->category_id = $request->edit_category;
        $item->size      = json_encode($request->size);
        $item->save();
        return response()->json(['success'=>'item Updated successfully.']);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();

         return response()->json(['success'=>'Item deleted successfully.']);
    }

    public function getItem()
    {
        $items = Item::all();
        return $items;
    }
}
