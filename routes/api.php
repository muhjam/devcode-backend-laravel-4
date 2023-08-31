<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\contact;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('hello', function () {
    return response()->json([
        'message' => 'Hello world'
    ]);
});

Route::get('/contacts', function () {
    $contacts = contact::all();
    return response()->json([
        'status' => 'Success',
        'data' => $contacts,
    ]);
});

Route::post('/contacts', function (Request $request) {
    $newContact = $request->all();
    $contact = new contact();
    $contact->full_name = $newContact['full_name'];
    $contact->phone_number = $newContact['phone_number'];
    $contact->email = $newContact['email'];
    $contact->save();
    $response = response()->json([
        'status' => 'Success',
        'message' => 'Contact created',
        'data' => $contact,
    ]);
    return $response;
});

// TODO: Tambahkan handler untuk PUT & DELETE contact
Route::put('/contacts/{id}', function (Request $request, $id) {
    $contact = contact::findOrFail($id);
    $contact->update($request->all());
    $response = response()->json([
        'status' => 'Success',
        'message' => 'Contact updated',
        'data' => $contact,
    ]);
    return $response;
});

Route::delete('/contacts/{id}', function (Request $request, $id) {
    $contact = contact::findOrFail($id);
    $contact->delete();
    $response = response()->json([
        'status' => 'Success',
        'message' => 'Contact deleted',
        'deletedId' => $contact->id,
    ]);
    return $response;
});