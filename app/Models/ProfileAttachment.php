<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'category',
        'file_name',
        'file_path',
        'meta',
        'uploaded_by'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public static function getCategories()
    {
        return [
            'photo' => 'Photo',
            'biodata' => 'Biodata',
            'id' => 'ID Proof'
        ];
    }

    public function getFileIcon()
    {
        $extension = strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
        
        $icons = [
            'pdf' => 'file-pdf',
            'doc' => 'file-word',
            'docx' => 'file-word',
            'xls' => 'file-excel',
            'xlsx' => 'file-excel',
            'jpg' => 'file-image',
            'jpeg' => 'file-image',
            'png' => 'file-image',
            'gif' => 'file-image',
        ];

        return $icons[$extension] ?? 'file';
    }
}