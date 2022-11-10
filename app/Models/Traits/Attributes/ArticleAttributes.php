<?php

namespace App\Models\Traits\Attributes;

trait ArticleAttributes
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group" role="group" aria-label="'.trans('labels.backend.access.users.user_actions').'">'.
                $this->getEditButtonAttribute('view-article', 'admin.editex.article.show').
                $this->getDeleteButtonAttribute('delete-article', 'admin.editex.article.destroy').
                '</div>';
    }

    /**
     * @return string
     */
    public function getNoecsLabelAttribute()
    {
        if ($this->noecs==1) {
            return "<label class='label label-success'>".trans('labels.general.yes').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.no').'</label>';
    }
    /**
     * @return string
     */
    public function getGalleypdfLabelAttribute()
    {
        if ($this->galleypdf==1) {
            return "<label class='label label-success'>".trans('labels.general.yes').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.no').'</label>';
    }
    /**
     * @return string
     */
    public function getTypesetLabelAttribute()
    {
        if ($this->typeset==1) {
            return "<label class='label label-success'>".trans('labels.general.yes').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.no').'</label>';
    }
    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if ($this->isActive()) {
            return "<label class='label label-success'>".trans('labels.general.active').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.inactive').'</label>';
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active == 1;
    }

    /**
     * Get Display Status Attribute.
     *
     * @var string
     */
    public function getDisplayStatusAttribute(): string
    {
        return $this->isActive() ? 'Active' : 'In-Active';
    }
    
    
}
