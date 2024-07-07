<?php

namespace App\Repositories;

use App\Http\Requests\AnnounceRequest;
use App\Models\Announce;
use App\Models\Scopes\IsAnnounceActivatedScope;

class AnnounceRepository{

    public function store(AnnounceRequest $request) : void
    {
        Announce::create($request->all());
    }

    public function update(AnnounceRequest $request,Announce $announce) : void
    {
        $announce->update($request->all());
    }

    public function announceWithoutScope($id) : Announce
    {
        return Announce::withoutGlobalScope(IsAnnounceActivatedScope::class)->find($id);
    }
}
