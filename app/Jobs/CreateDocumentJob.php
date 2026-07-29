<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use App\Models\Document;

class CreateDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected array $request;
    public function __construct(array $request)
    {
        $this->request = $request;
    }
    public function handle(): void
    {
        $str_partner = Arr::pull($this->request, 'partner');
        $str_division = Arr::pull($this->request, 'division');
        $str_pic = Arr::pull($this->request, 'pic');
        $obj = Document::create($this->request);
        $str_institution = [];
        if (!empty($str_partner)) {
            $ids_partner = array_map("intval", explode(',', $str_partner));
            $str_institution = array_merge($str_institution, $ids_partner);
        }
        if (!empty($str_division)) {
            $ids_division = array_map("intval", explode(',', $str_division));
            $str_institution = array_merge($str_institution, $ids_division);
        }
        // Run sync ONCE for the shared relation table
        if (!empty($str_institution)) $obj->institutions()->sync($str_institution);
        else $obj->institutions()->detach();
        if (!empty($str_pic)) {
            $ids_pic = array_map("intval", explode(',', $str_pic));
            $obj->pics()->sync($ids_pic);
        } else $obj->pics()->detach();
    }
}
