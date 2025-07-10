<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'position',
        'department',
        'phone',
        'is_active',
    ];

    /**
     * Get the user that owns the employee.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the timesheets for the employee.
     */
    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    /**
     * Get the leaves for the employee.
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    /**
     * Get the employee's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the employee's active timesheet (if any).
     */
    public function activeTimesheet()
    {
        return $this->timesheets()
            ->where('status', 'active')
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->first();
    }

    /**
     * Get the employee's pending leave requests.
     */
    public function pendingLeaves()
    {
        return $this->leaves()
            ->where('status', 'pending')
            ->get();
    }

    /**
     * Get the employee's approved leaves.
     */
    public function approvedLeaves()
    {
        return $this->leaves()
            ->where('status', 'approved')
            ->get();
    }
}
