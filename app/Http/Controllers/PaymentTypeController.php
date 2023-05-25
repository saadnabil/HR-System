<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $paymenttypes = PaymentType::query();

        if (request()->ajax()) {
            $paymenttypes->where(function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
            $search = view('new-theme.settings.salary.paginations.paymenttype_pagination', [
                'paymenttypes' => $paymenttypes->get(),
            ]);
            return response()->json(['search' => $search->render()]);
        }

        $paymenttypes = $paymenttypes->get();

        return view('new-theme.settings.salary.paymenttypes', compact('paymenttypes'));
    }

    public function create()
    {
        if(auth()->user()->can('Create Payment Type'))
        {
            return view('paymenttype.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {


            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                $key = array_keys($messages->getMessages())[0] ?? "";
                return redirect()->back()->with('error',$key ." ". $messages->first());
            }

            $paymenttype             = new PaymentType();
            $paymenttype->name       = $request->name;
            $paymenttype->created_by = auth()->user()->creatorId();
            $paymenttype->save();

            return redirect()->route('paymenttype.index')->with('success', __('PaymentType  successfully created.'));

    }

    public function show(PaymentType $paymenttype)
    {
        return redirect()->route('paymenttype.index');
    }

    public function edit(PaymentType $paymenttype)
    {
        if(auth()->user()->can('Edit Payment Type'))
        {


                return view('paymenttype.edit', compact('paymenttype'));

        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, PaymentType $paymenttype)
    {


                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',

                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    $key = array_keys($messages->getMessages())[0] ?? "";
                    return redirect()->back()->with('error',$key ." ". $messages->first());
                }
                $paymenttype->name = $request->name;
                $paymenttype->save();

                return redirect()->route('paymenttype.index')->with('success', __('PaymentType successfully updated.'));


    }

    public function destroy(PaymentType $paymenttype)
    {

        $paymenttype->delete();

        return redirect()->route('paymenttype.index')->with('success', __('PaymentType successfully deleted.'));
    }
}
