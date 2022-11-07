<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreBookRequest;
use App\Services\API\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(BookService $bookService)
    {
        try {
            $books = $bookService->getBooks();

            return $books;

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function create(\App\Services\BookService $bookService, StoreBookRequest $request)
    {
        try {
            $bookService->addBook($request->title,
                $request->price,
                $request->qty,
                $request->authors
            );
            return response()->json([
                'status' => false,
                'message' => 'Book created successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function destroy(\App\Services\BookService $bookService, Request $request)
    {
        try {
            $bookService->delete($request->id);
            return response()->json([
                'status' => false,
                'message' => 'Book deleted successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
