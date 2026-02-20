<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    protected $fillable = [
        'reference',
        'code',
        'libelle',
        'description',
        'date_debut',
        'date_fin',
        'montant',
        'montant_estimatif',
        'devis_path',
        'facture_path',
        'date_debut_reelle',
        'date_fin_reelle',
        'rapport_path',
        'rapport_commentaire',
        'statut',
        'motif_refus',
        'admin_id',
        'site_id',
        'prestataire_id',
        'financier_id',
        'personnel_id',
        'responsable_id',
        'forfait_id',
        'document_1',
        'document_2',
        'date_soumission_finance',
        'delai_paiement',
        'date_paiement_prevue',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function prestataire()
    {
        return $this->belongsTo(User::class, 'prestataire_id');
    }

    public function financier()
    {
        return $this->belongsTo(User::class, 'financier_id');
    }

    public function personnels()
    {
        return $this->belongsToMany(User::class, 'intervention_user')->withPivot('is_responsible');
    }

    /**
     * @deprecated Use personnels() instead
     */
    public function personnel()
    {
        return $this->belongsTo(User::class, 'personnel_id'); // Keeping this for now until all references are fixed, but wait, I migrated data. 'personnel_id' column still exists? Yes, I didn't drop it.
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * The equipments used during this intervention.
     */
    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'intervention_equipement')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function forfait()
    {
        return $this->belongsTo(Forfait::class);
    }

    public function forfaitTasks()
    {
        return $this->belongsToMany(ForfaitTask::class, 'intervention_forfait_task')
            ->withTimestamps();
    }

    public function documents()
    {
        return $this->hasMany(InterventionDocument::class);
    }
}
