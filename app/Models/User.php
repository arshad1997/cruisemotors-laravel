<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected $with = ['city', 'state', 'country', 'passport'];
    protected $appends = ['is_verified'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function passport()
    {
        return $this->belongsTo(Upload::class, 'passport_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'source_id');
    }

    public function getIsVerifiedAttribute()
    {
        // Check if user is an admin
        if ($this->roles()->where('name', 'admin')->exists()) {
            return true;
        }

        // Fetch the user's first role to determine if they're a company or individual user
        $role = $this->roles()->first();

        if (!$role) {
            return false;
        }

        // Check for company verification
        if ($role->name === 'company') {
            // Check if both passport and company license are verified
            $passportVerified = $this->attachments()
                ->where('attachment_for', 'Passport')
                ->whereHas('statusTracking', function ($query) {
                    $query->where('status', StatusEnum::VERIFIED->value);
                })
                ->exists();

            $licenseVerified = $this->attachments()
                ->where('attachment_for', 'CompanyLicense')
                ->whereHas('statusTracking', function ($query) {
                    $query->where('status', StatusEnum::VERIFIED->value);
                })
                ->exists();

            return $passportVerified && $licenseVerified;
        }

        // Check for individual user verification (only passport needed)
        if ($role->name === 'user') {
            return $this->attachments()
                ->where('attachment_for', 'Passport')
                ->whereHas('statusTracking', function ($query) {
                    $query->where('status', StatusEnum::VERIFIED->value);
                })
                ->exists();
        }

        return false;  // Default case if no matching role is found
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function vehicleOrders()
    {
        return $this->hasMany(VehicleOrder::class);
    }

    public function supplyContracts()
    {
        return $this->hasMany(SupplyContract::class);
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }

    public function offerVehicles()
    {
        return $this->hasMany(OfferVehicle::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function carBookings()
    {
        return $this->hasMany(CarBooking::class);
    }
}
