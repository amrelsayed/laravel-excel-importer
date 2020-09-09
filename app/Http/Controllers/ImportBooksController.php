<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use App\Mail\ExcelImported;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ImportBooksController extends Controller
{
    public function index()
    {
    	$books = Book::with('author')->get();
    	
    	return view('books', compact('books'));
    }

    public function import(Request $request)
    {
    	$this->validate($request, [
	    	'excel_sheet'  => 'required|mimes:xls,xlsx'
	    ]);
		
		$import = new BooksImport();

		Excel::import($import, request()->file('excel_sheet'));

		$data = $import->rows;

	    for ($i = 1; $i < count($data); $i++) {
	    	$author = Author::create(['name' => $data[$i][2]]);
	    	
	    	Book::create([
	    		'title' => $data[$i][0],
	    		'description' => $data[$i][1],
	    		'author_id' => $author->id,
	    	]);
	    }

	    Mail::to(env('MAIL_TO'))
    		->queue(new ExcelImported(count($data) - 1));

	    return back()->with('success', 'Excel Data Imported successfully.');
    }
}
