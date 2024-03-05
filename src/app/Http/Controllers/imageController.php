<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\tbl_image;

use Illuminate\Support\Facades\DB;
  
class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $img = DB::table('tbl_images')
        ->select('*')
        ->get();
        return view('imageUpload', ['tbl_images' => $img]);
    }
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function equipImg(Request $request, $equipmentID)
    {
        
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);
      
        $imageName = time().'.'.$request->image->extension();  
       
        $request->image->move(public_path('images'), $imageName);
        
        $save = new tbl_image();
        $save->ImagePath = $imageName; 
        $save->primarypath = $equipmentID;
        $save->save();
    
        return back()
            ->with('success','You have successfully uploaded image.')
            ->with('image',$imageName);
        
    }
    
}