<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Ticket};
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{

    //create ticket
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'title'=>'required',
            'description'=>'required',

        ]);

        $request['status'] =1;
        $request['uid'] = hexdec(uniqid());
        $data =  Ticket::create($request->all());

        Mail::to("ihshaan10@gmail.com")->send(new TicketMail($data));


        $response=[
            'data'=>$data,
            'status'=>true
        ];

        return response($response,201);
       
    }

    //get all
    public function getAll()
    {   
        $tickets =  Ticket::all();
        $response=[
            'data'=>$tickets,
            'status'=>true
        ];

        return response($response,201);
    }

    //get single information
    public function getSingle(Ticket $ticket)
    {   
        $response=[
            'data'=>$ticket,
            'status'=>true
        ];

        return response($response,201);
    }

    //delete ticket
    public function destroy(Ticket $ticket)
    {   
        Ticket::destroy($ticket->id);
        $response=[
            'data' => $ticket,
            'status'=>true
        ];
        return response($response,201);
    }


    //update ticket
    public function update(Request $request,$id)
    {
        //
        $ticket=Ticket::find($id);
        $ticket->update($request->all());
        $response=[
            'data' => $ticket,
            'status'=>true
        ];
        return response($response,201);

    }

   
}
