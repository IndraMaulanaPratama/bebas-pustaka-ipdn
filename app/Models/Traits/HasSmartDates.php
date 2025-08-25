<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

trait HasSmartDates
{
    /**
     * Fungsi kanggo ngadamel field created_at janten langkung keren
     * upami waktos kirang ti 8 jam, bakalan nganggo format relative
     * mung upami tos langkung ti 8 jam, bakalan nganggo formatted full
     */
    public function getCreatedAtSmartAttribute()
    {
        return $this->getSmartDate($this->created_at);
    }

    /**
     * Fungsi kanggo ngadamel field updated_at janten langkung keren
     * upami waktos kirang ti 8 jam, bakalan nganggo format relative
     * mung upami tos langkung ti 8 jam, bakalan nganggo formatted full
     */
    public function getUpdatedAtSmartAttribute()
    {
        return $this->getSmartDate($this->updated_at);
    }

    /**
     * Fungsi kanggo ngadamel field deleted janten langkung keren
     * upami waktos kirang ti 8 jam, bakalan nganggo format relative
     * mung upami tos langkung ti 8 jam, bakalan nganggo formatted full
     */
    public function getDeletedAtSmartAttribute()
    {
        return $this->getSmartDate($this->deleted_at);
    }

    /**
     * Salam pangabaktos ka Den Rama nu tos ngadamel code nu keren tur bermangfaat ieu
     */
    public function getSmartDate($date, $thresholdHours = 8)
    {
        if (!$date)
            return '-';

        $date = Carbon::parse($date);

        // Jika kurang dari threshold, pakai relative time
        if ($date->diffInHours() < $thresholdHours) {
            return $date->locale('id')->diffForHumans();
        }

        // Jika lebih dari threshold, pakai formatted date
        return $date->locale('id')->translatedFormat('j F Y, H:i');
    }

    /**
     * nyandak tanggal hungkul tinu field created_at
     */
    public function getCreatedDateFormattedAttribute()
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->locale('id')->translatedFormat('j F Y')
            : '-';
    }

    /**
     * nyandak waktos hungkul tinu field created_at
     */
    public function getCreatedTimeFormattedAttribute()
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->locale('id')->translatedFormat('H:i')
            : '-';
    }

    /**
     * nyandak tanggal hungkul tinu field updated_at
     */
    public function getUpdatedDateFormattedAttribute()
    {
        return $this->updated_at
            ? Carbon::parse($this->updated_at)->locale('id')->translatedFormat('j F Y')
            : '-';
    }

    /**
     * nyandak waktos hungkul tinu field updated_at
     */
    public function getUpdatedTimeFormattedAttribute()
    {
        return $this->updated_at
            ? Carbon::parse($this->updated_at)->locale('id')->translatedFormat('H:i')
            : '-';
    }

    /**
     * nyandak tanggal hungkul tinu field deleted_at
     */
    public function getDeletedDateFormattedAttribute()
    {
        return $this->deleted_at
            ? Carbon::parse($this->deleted_at)->locale('id')->translatedFormat('j F Y')
            : '-';
    }

    /**
     * nyandak waktos hungkul tinu field deleted_at
     */
    public function getDeletedTimeFormattedAttribute()
    {
        return $this->deleted_at
            ? Carbon::parse($this->deleted_at)->locale('id')->translatedFormat('H:i')
            : '-';
    }
}
