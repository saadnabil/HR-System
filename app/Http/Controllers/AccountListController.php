<?php

namespace App\Http\Controllers;

use App\Models\AccountList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountListController extends Controller
{
    public function index()
    {
        if(auth()->user()->can('Manage Account List'))
        {
            $accountlists = AccountList::get();

            return view('accountlist.index', compact('accountlists'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function create()
    {
        if(auth()->user()->can('Create Account List'))
        {
            return view('accountlist.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(auth()->user()->can('Create Account List'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'account_name' => 'required',
                                   'initial_balance' => 'required',
                                   'account_number' => 'required',
                                   'branch_code' => 'required',
                                   'bank_branch' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $accountlist                  = new AccountList();
            $accountlist->account_name    = $request->account_name;
            $accountlist->initial_balance = $request->initial_balance;
            $accountlist->account_number  = $request->account_number;
            $accountlist->branch_code     = $request->branch_code;
            $accountlist->bank_branch     = $request->bank_branch;
            $accountlist->created_by      = auth()->user()->creatorId();
            $accountlist->save();

            return redirect()->route('accountlist.index')->with('success', __('Account successfully created.'));
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function show(AccountList $accountlist)
    {
        return redirect()->route('accountlist.index');
    }

    public function edit(AccountList $accountlist)
    {
        if(auth()->user()->can('Edit Account List'))
        {
            if($accountlist->created_by == auth()->user()->creatorId())
            {

                return view('accountlist.edit', compact('accountlist'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, AccountList $accountlist)
    {
        if(auth()->user()->can('Edit Account List'))
        {
            if($accountlist->created_by == auth()->user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'account_name' => 'required',
                                       'initial_balance' => 'required',
                                       'account_number' => 'required',
                                       'branch_code' => 'required',
                                       'bank_branch' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $accountlist->account_name    = $request->account_name;
                $accountlist->initial_balance = $request->initial_balance;
                $accountlist->account_number  = $request->account_number;
                $accountlist->branch_code     = $request->branch_code;
                $accountlist->bank_branch     = $request->bank_branch;
                $accountlist->save();

                return redirect()->route('accountlist.index')->with('success', __('Account successfully updated.'));
            }
            else
            {
                flash()->addError(__('Permission denied'));
            return redirect()->back();
            }
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function destroy(AccountList $accountlist)
    {
        if(auth()->user()->can('Delete Account List'))
        {
            if($accountlist->created_by == auth()->user()->creatorId())
            {
                $accountlist->delete();

                return redirect()->route('accountlist.index')->with('success', __('Account successfully deleted.'));
            }
            else
            {
                flash()->addError(__('Permission denied'));
            return redirect()->back();
            }
        }
        else
        {
            flash()->addError(__('Permission denied'));
            return redirect()->back();
        }
    }

    public function account_balance()
    {
        $accountLists = AccountList::get();

        return view('accountlist.account_balance', compact('accountLists'));
    }


}
