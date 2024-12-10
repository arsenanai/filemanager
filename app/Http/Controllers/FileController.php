<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFile;
use App\Http\Requests\UpdateFile;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\File as StorageFile;
use Inertia\Inertia;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $r = File::select(['id','title', 'path', 'extension', 'size']);
        if ($request->has('search')) {
            try {
                $s = $request->input('search');
                $r->where('title', 'like', "%$s%");
            } catch (\Throwable $t) {}
        }
        $files = $r->orderBy('id', 'desc')->paginate(50/*config('cnf.PAGINATION_SIZE')*/);
        return Inertia::render('File/Index', ['files' => $files]);
    }
    public function create()
    {
        return Inertia::render('File/Create');
    }
    public function store(StoreFile $request)
    {
        $file = $request->file('path');
        $filePath = $file->store('files', 'public');
        try {
            File::create([
                'path'      => $filePath,
                'title'     => $request->input('title'),
                'extension' => $file->extension(),
                'size'      => $file->getSize(),
            ]);
        } catch (\Throwable $t) {}
        return redirect()->route('files.index');
    }
    public function edit(File $file)
    {
        return Inertia::render('File/Edit', ['file' => $file]);
    }
    public function update(UpdateFile $request, File $file)
    {
        // $original = File::find($file->id);
        if ($request->hasFile('path')) {
            $this->deleteFileFromStorage($file->path);
            $fileObject = $request->file('path');
            $filePath = $fileObject->store('files', 'public');
            
            $file->path = $filePath;
            $file->extension = $fileObject->extension();
            $file->size = $fileObject->getSize();
        }
        $file->title = $request->input('title');
        $file->update();
        if ( $request->has('redirectURL') && str_starts_with( $request->input('redirectURL'), '/files') ) {
            return redirect($request->input('redirectURL'));
        } else {
            return redirect()->back();
        }
    }
    public function destroy(File $file)
    {
        $this->deleteFileFromStorage($file->path);
        $file->delete();
        return redirect()->back();
    }

    private function deleteFileFromStorage(String $path)
    {
        if (StorageFile::exists($path)) {
            return StorageFile::delete($path);
        }
        return false;
    }
}
