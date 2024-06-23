<?php

namespace App\Repositories;

use App\Models\Section;

class SectionRepository{

    public function store($request)
    {
        Section::create($request->all());
    }

    public function update($section, $request)
    {
        $section->update($request->all());
    }

    public function destroy($section)
    {
        $section->delete();
    }
}
