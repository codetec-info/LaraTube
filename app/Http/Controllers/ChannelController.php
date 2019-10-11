<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Channel;
use Laratube\Http\Requests\Channels\UpdateChannelRequest;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only('update');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->home();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Channel $channel
     * @return void
     */
    public function show(Channel $channel)
    {
        return view('channels.show', compact('channel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateChannelRequest $request
     * @param Channel $channel
     * @return void
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        if ($request->hasFile('image')) {

            // Clear any previous image
            $channel->clearMediaCollection('images');

            // Add the new image
            $channel->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        $channel->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
