<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;

class AdminDocumentController extends Controller
{
	public function index()
	{
		$documents = Document::with('user')->latest()->paginate(20);
		return view('admin.documents.index', compact('documents'));
	}
}
