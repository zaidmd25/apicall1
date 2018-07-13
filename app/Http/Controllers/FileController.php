<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class FileController extends Controller
{
    //

	public function uploadform()
	{
		return view('imageupload');
	}

	public function uploadfile(Request $request)
	{
		$this->validate($request, [
		   'filename' => 'required|mimes:jpeg,bmp,png',
		]);
		$data = User::first();
		$data->fill($request->except('filename'));
		if($file = $request->hasFile('filename'))
		{
			$file = $request->file('filename');
			$fileName = time()."-".$file->getClientOriginalName();
			$destinationPath = public_path().'/uploads';
			if(!\File::isDirectory($destinationPath))
			{
				\File::makeDirectory($destinationPath);
			}
				$file->move($destinationPath,$fileName);
				$data->filename = $fileName;
				$data->save();
		}
		return redirect('/multiuploads')->with('message','successfully uploaded');
	}
}