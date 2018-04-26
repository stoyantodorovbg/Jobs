<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nitmedia\Wkhtml2pdf\Facades\Wkhtml2pdf;

class Candidate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $employerEmail;

    protected $fillable = [
        'name',
        'email'
    ];

    /**
     * The jobs which belong to a candidate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class)->withTimestamps();;

    }

    /**
     * Save a .pdf file with job candidate data
     * 
     * @return string
     */
    public function saveCandidatePDF ()
    {
        $candidate = $this;
        $date = date("Y-m-d H:i:s");
        Wkhtml2pdf::setOutputMode('F');
        Wkhtml2pdf::html('candidates.candidate_pdf', compact('candidate'), "/home/developer/PhpstormProjects/JobsApp/JobsApp/storage/app/public/$date.pdf");

        return "storage/$date.pdf";
    }
}

